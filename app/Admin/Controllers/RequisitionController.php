<?php

namespace App\Admin\Controllers;

use App\Models\Accountability;
use App\Models\Activity;
use App\Models\AdminActivity;
use App\Models\AdminBudget_lines;
use App\Models\AdminProgram;
use App\Models\BudgetLines;
use App\Models\Comments;
use App\Models\Outcome;
use App\Models\Output;
use App\Models\Program;
use App\Models\Requisition;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

use function App\Http\Controllers\formatAmount;

class RequisitionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Requisition';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
        $grid = new Grid(new Requisition());
        $grid->disableBatchActions();

        $user = auth()->user();
        // disable create button for finance and CD
        if ($user->inRoles(['finance', 'director'])){
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
                    $actions->disableDelete();
            });
        }
        
            $grid->actions(function ($actions) {
                if ($actions->row->status == 'approved') {
                    $actions->disableEdit();
                    $actions->disableDelete();
                }
            });
        

        // order by latest requisition
        $grid->model()->orderBy('created_at', 'desc');

        //show staff only requisitions made by them if they are not admin
        if ($user->inRoles(['staff', 'admin'])) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
        }
        
        // show the CD only accepted requisitions
        if ($user->inRoles(['director'])) {
            $grid->model()->where('status', 'accepted');
        }

         //filter by program and activity
         $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            $filter->equal('program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
            $filter->equal('activity_id', 'Activity')->select(Activity::all()->pluck('name', 'id'));
            //status filter
            $filter->equal('status', 'Status')->select([
                'pending' => 'Pending',
                'approved' => 'Authorized',
                'rejected' => 'Rejected',
                'accepted' => 'Approved',
                'amended' => 'Amended'
            ]);
        });
       
        $grid->column('code', __('Code'));
        $grid->column('staff_id', __('Requested by'))->display(function($staff_id){
            return Staff::find($staff_id)->name;
        });
        
            $grid->column('', 'Program')->display(function(){
                if ($this->program_id) {
                    return Program::find($this->program_id)->name ?? 'N/A';
                }
                if ($this->admin_program_id) {
                    return AdminProgram::find($this->admin_program_id)->name ?? 'N/A';
                }
                return 'N/A';
                
            });
        
        $grid->column('amount', __('Amount (UGX)'))->display(function ($value) {
            return number_format($value, 0, '.', ','); // Format with commas
        });
        $grid->column('status', __('Status'))->display(
            function ($status) {
                if ($status == 'pending') {
                    return "<span class='label label-warning'>pending</span>";
                } elseif ($status == 'approved') {
                    return "<span class='label label-success'>Authorized</span>";
                } elseif ($status == 'rejected') {
                    return "<span class='label label-danger'>Rejected</span>";
                } elseif ($status == 'amended') {
                    return "<span class='label label-info'>Amended</span>";
                }elseif ($status == 'accepted') {
                    return "<span class='label label-primary'>Approved</span>";
                }
            }
        );
        
        // $id = $grid->column('id');
        // $downloadLink = admin_url('/requisitions/download/'. $id);
        // $grid->column('id', __('Requisition Documents'))->display(function ($id)
        // {
        //     $requisition = Requisition::find($id);

        //     // if ($requisition && $requisition->status == 'approved') {
        //         $token = csrf_token();
        //         $downloadLink = admin_url('/requisitions/download/'. $id);
        //         return "<b>Download documents</b>";
        //     // } else
        //     // {          
        //     //     return '<b> No accountability</b>';
        //     // }
        // })
        // ->link(function ($value, $row) {
        //     // Generate the download link using the row's ID
        //     return admin_url('/requisitions/download/'. $row->id);
        // }, '', function () {
        //     // Add download attribute to force download instead of opening new tab
        //     return [
        //         'class' => 'btn btn-sm btn-primary',
        //         'download' => true  // This forces download
        //     ];
        // });

        $grid->column('id', __('Requisition Documents'))->display(function ($id)
        {
            $requisition = Requisition::find($id);

            if ($requisition && $requisition->status == 'approved') {
                 $downloadLink = admin_url('/requisitions/download/'. $id);
                 $token = csrf_token();
            
            return "
                    <form method='POST' action='{$downloadLink}' style='display: inline;'>
                        <input type='hidden' name='_token' value='{$token}'>
                        <button type='submit' class='btn btn-sm btn-primary'>
                            <b>Download documents</b>
                        </button>
                    </form>";
            }
            else
            {          
                return '<b> No accountability</b>';
            }
           
        });
        
        

    // or pass in a specified href
        // $grid->column('homepage')->link($href);
        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            //return human readable format
            return (Carbon::parse($created_at)->diffForHumans());
        });
         

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Requisition::findOrFail($id));
        $requisition = Requisition::findOrFail($id);
        

        if($requisition->program?->type == 2){
            $activityid = $requisition->activity?->id;
            Log::info($requisition->program->adminActivities);
            // Sum of accountabilities for all requisitions under this activity
            $activity_budget = $requisition->adminoutcome?->budget;
            $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityid) {
            $query->where('activity_id', $activityid);
        })->sum('amount_used');
            //  $remaining =  0;
            Log::info($usedAmount);
            Log::info($activity_budget);

            $remaining = $activity_budget - $usedAmount;
        }else{
            $activityid = $requisition->activity->id;
            // Sum of accountabilities for all requisitions under this activity
            $activity_budget = $requisition->activity->budget;
            $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityid) {
            $query->where('activity_id', $activityid);
            })->sum('amount_used');

            Log::info($usedAmount);
            Log::info($activity_budget);

            $remaining = $activity_budget - $usedAmount;
        }

        return view('requisition_request', compact('requisition', 'remaining'));

    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Requisition());
        //get the logged in users's staff id
        $user = auth()->user();
        if ($form->isCreating()) {
            // Check if the user has any pending accountabilities
            $user = auth()->user();
            $staff_id = Staff::where('user_id', $user->id)->first()->id;

            $pendingRequisition = Requisition::where('staff_id', $staff_id)
                ->where('status', 'approved')
                ->whereDoesntHave('accountability') // Check if there's no accountability
                ->first();

            if ($pendingRequisition) {
                // Prevent new requisition creation
                $error = new MessageBag([
                    'title'   => 'Warning',
                    'message' => 'You cannot create a new requisition until you submit accountability for your  requisition '.$pendingRequisition->code,
                ]);

                return back()->with(compact('error'));
            }
        };
        
        $staff_id = Staff::where('user_id', $user->id)->first()->id;
        
            //when saving the form, calculate the total amount of the requisition items and save it in the amount field
            $form->saving(function (Form $form) {
                $requisition_items = request()->input('requisition_items');
                // dd($requisition_items);
        
                // Check that the requisition items are not empty
                if (empty($form->requisition_items)) {
                    admin_toastr('Please add requisition items', 'error');
                    return back()->withInput();
                }
            
                $total_amount = 0;
                $budget_lines = [];
                $duplicateCategoryFound = false;
                
                $user = auth()->user();
                // $staff = Staff::where('user_id', $user->id);
                if($user->isRole('admin')){
                    foreach ($requisition_items as $item) {
                        // dd($requisition_items);
                        // Check if the category_id is already in the $categories array
                        if (in_array($item['admin_budget_line_id'], $budget_lines)) {
                            $duplicateCategoryFound = true;
                            break; // Exit the loop early if a duplicate is found
                        }
                        
                        // Add the category_id to the $categories array
                        $budget_lines[] = $item['admin_budget_line_id'];

                        // Calculate the total amount of the requisition
                        $total_amount += $item['quantity'] * $item['unit_price']; // Fixed unit_price to unit_cost to match the form field
                    }
                
                    // If a duplicate category was found, show an error message and return back with input
                    if ($duplicateCategoryFound) {
                        admin_toastr('You have selected the same budget line twice', 'error');
                        return back()->withInput();
                    }

                    
                // Set the total amount after validation
                $form->amount = $total_amount;
                }
                else{
                    /* foreach ($requisition_items as $item) {
                        // Check if the category_id is already in the $categories array
                        if (in_array($item['budget_line_id'], $budget_lines)) {
                            $duplicateCategoryFound = true;
                            break; // Exit the loop early if a duplicate is found
                        }
                        
                        // Add the category_id to the $categories array
                        $budget_lines[] = $item['budget_line_id'];
                        
                        // Calculate the total amount of the requisition
                        $total_amount += $item['quantity'] * $item['unit_price'] * $item['frequency']; // Fixed unit_price to unit_cost to match the form field
                        Log::info($total_amount);
                    } */
                    // If a duplicate category was found, show an error message and return back with input
                    if ($duplicateCategoryFound) {
                        admin_toastr('You have selected the same budget line twice', 'error');
                        return back()->withInput();
                    }
                }
            
            });
        

            //when the form is saved , redirect to the show view with a success message that has the total amount of the requisition
            $form->saved(function (Form $form) {
                //get the total amount of the requisition
                $total_amount = $form->amount;
                $id = $form->model()->id;
                admin_toastr('Requistion worth '. $total_amount. ' has been successfully submitted');
                return redirect('/requisitions/'.$id);
            
            });
            
            $form->hidden('staff_id', __('Staff'))->default( $staff_id );
        
            if($user->isRole('admin')){
                $form->text('code', __('RequisitionID'))->default('Admin-'.rand(1000, 9999))->readonly();
                // dd($user->id);
                $form->select('program_id', __('Program'))->options(Program::where('user_id', $user->id)->pluck('name', 'id'))->attribute('id', 'adminprogram_id')->required();
                $form->select('outcome_id', __('Outcome'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = AdminActivity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'adminactivity_id')->required();
            
                $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                    $form->select('admin_budget_line_id', __('Output'))
                    ->options(function ($id) {
                        // Preload the selected budget line for editing
                        $adminbudgetLine = AdminBudget_lines::find($id);
                        return $adminbudgetLine ? [$adminbudgetLine->id => $adminbudgetLine->name] : [];
                    })
                    ->attribute('id', 'admin_budget_line_id')
                    ->required();
                    $form->decimal('quantity', __('Quantity'))->required();
                    $form->decimal('frequency', __('Frequency'))->required();
                    $form->text('unit_of_measure', __('Unit of measure'))->required();
                    $form->decimal('unit_price', __('Unit cost(UGX)'))->required();
                
                });
            }
            else{
                $form->text('code', __('RequisitionID'))->default('REQ-'.rand(1000, 9999))->readonly();
                $form->select('program_id', __('Program'))->options(Program::where('user_id', $user->id)->pluck('name', 'id'))->attribute('id', 'program_id')->required();
                $form->select('outcome_id', __('Outcome'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $outcome = Outcome::find($id);
                    return $outcome ? [$outcome->id => $outcome->name] : [];
                    })->attribute('id', 'outcome_id')->required();
                $form->select('output_id', __('Output'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $output = Output::find($id);
                    return $output ? [$output->id => $output->name] : [];
                    })->attribute('id', 'output_id')->required();
                $form->select('activity_id', __('Activity'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = Activity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'activity_id')->required();
                $form->text('', __('Activity budget(UGX)'))->attribute(
                    'id', 'activity_budget',
                    )->readonly();
                $form->text('', __('Remaining budget(UGX)'))->attribute(
                    'id', 'remaining_budget',
                    )->readonly();
            
                    //add requisition items
                    $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                        $form->select('budget_line_id', __('Budget Line'))
                        ->options(function ($id) {
                            // Preload the selected budget line for editing
                            $budgetLine = BudgetLines::find($id);
                            return $budgetLine ? [$budgetLine->id => $budgetLine->name] : [];
                        })
                        ->attribute('id', 'budget_line_id')
                        ->required()
                        ->readOnly();
                        $form->decimal('quantity', __('Quantity'))->required();
                        $form->text('unit_of_measure', __('Unit of measure'))->required();
                        $form->decimal('frequency', __('Frequency'))->required();
                        $form->decimal('unit_price', __('Unit cost(UGX)'))
                        /* ->attribute([
                            'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                        ]) */
                        ->required();
                        $form->decimal('total_price', __('Total amount'))->readonly();
                    
                    });
            }
            $form->decimal('amount', __('Amount(UGX)'))->readonly();
            $form->file('concept_note', __('Concept note'))->required()
            ->help('Upload concept note in pdf format');
            $form->textarea('description', __('Description'));
            
            
        Admin::script
        ('  
            $(document).ajaxError(function(event, xhr, settings, error) {
                console.error("AJAX Error:", {
                    status: xhr.status,
                    response: xhr.responseText,
                    error: error
                });
            });
        ');

        //script to show activity based on program selected
        Admin::script('
        let globalBudgetLines = {};
            $("#program_id").change(function(){
                var program_id = $(this).val();
                $.get("/program-outcomes/"+program_id, function(data){
                    $("#outcome_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#outcome_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No outcomes available for this program</span>");
                    } else {
                        // Add a default option
                        $("#outcome_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#outcome_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });

            //show outputs
            $("#outcome_id").change(function(){
                var outcome_id = $(this).val();
                $.get("/outcome-outputs/"+outcome_id, function(data){
                    $("#output_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#output_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No outputs available for this outcome</span>");
                    } else {
                        // Add a default option
                        $("#output_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#output_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
            //show activities
            $("#output_id").change(function(){
                var output_id = $(this).val();
                $.get("/output-activities/"+output_id, function(data){
                    $("#activity_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#activity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this output</span>");
                    } else {
                        // Add a default option
                        $("#activity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#activity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
           
            $("#activity_id").change(function () {
                var activity_id = $(this).val();

                if (!activity_id) {
                    alert("Please select an activity");
                    return;
                }

                $.get("/budgetlines/" + activity_id)
                    .done(function (data) {
                        globalBudgetLines = data[0]; // Store for later use
                        var activity_budget = Number(data[1]).toLocaleString(\'en-US\');
                        var remaining_budget = Number(data[2]).toLocaleString(\'en-US\');

                        $("#activity_budget").val(activity_budget);
                        $("#remaining_budget").val(remaining_budget);

                        if ($.isEmptyObject(globalBudgetLines)) {
                            alert("No budget lines available for the selected activity");
                            return;
                        }

                        // Optionally clear existing options in current select inputs
                        $("[id^=budget_line_id]").each(function () {
                            let $select = $(this);
                            $select.empty().append(\'<option value="">Select Budget Line</option>\');
                            $.each(globalBudgetLines, function (key, value) {
                                $select.append(new Option(value, key));
                            });

                        });
                        
                    });
            });

            // Observer to detect new requisition item form added
            const targetNode = document.querySelector("#has-many-requisition_items .has-many-requisition_items-forms");
            
            // Utility to sanitize input by removing commas and parsing float
            function sanitize(val) {
                return parseFloat((val || ``).toString().replace(/,/g, ``).trim()) || 0;
            }

            // Function to calculate grand total of all requisition items
            function calculateGrandTotal() {
                let grandTotal = 0;
                
                // Find all total_price inputs in requisition items
                const allTotalInputs = document.querySelectorAll("input[name*=\'total_price\']");
                
                allTotalInputs.forEach(function(input) {
                    // Get the raw value or parse the displayed value
                    let value = input.getAttribute("data-raw") || input.value;
                    grandTotal += sanitize(value);
                });
                
                // Update the main amount field
                const amountField = document.querySelector("input[name=\'amount\']");
                if (amountField) {
                    amountField.value = grandTotal.toLocaleString(`en-UG`);
                    amountField.setAttribute("data-raw", grandTotal);
                }
                
                return grandTotal;
            }

            // Fixed setupRecalculation function that works with dynamic forms
            function setupRecalculation(formNode) {
                // Find inputs within the specific form node (not globally)
                const unitPriceInput = formNode.querySelector("input[name*=\'unit_price\']");
                const quantityInput = formNode.querySelector("input[name*=\'quantity\']");
                const frequencyInput = formNode.querySelector("input[name*=\'frequency\']");
                const totalPriceInput = formNode.querySelector("input[name*=\'total_price\']");

                // console.log("Setting up recalculation for form:", formNode);
                // console.log("Found inputs:", {
                //     unitPrice: !!unitPriceInput,
                //     quantity: !!quantityInput,
                //     frequency: !!frequencyInput,
                //     totalPrice: !!totalPriceInput
                // });

                function recalculateTotal() {
                    if (!unitPriceInput || !quantityInput || !frequencyInput || !totalPriceInput) {
                        console.warn("Missing input elements for calculation");
                        return;
                    }

                    const unit = sanitize(unitPriceInput.value);
                    const qty = sanitize(quantityInput.value);
                    const freq = sanitize(frequencyInput.value);
                    const total = unit * qty * freq;

                    // console.log(`Calculated Total: ${unit} x ${qty} x ${freq} = ${total}`);

                    totalPriceInput.value = total.toLocaleString(\'en-UG\');
                    totalPriceInput.setAttribute("data-raw", total);

                    calculateGrandTotal();
                
                }
                function handleInputChange(inputElement) {
                    inputElement.value = inputElement.value.replace(/[^\\d.]/g, ``);
                    recalculateTotal();
                }

                // Add event listeners to each input
                if (unitPriceInput) {
                    $(unitPriceInput).on(`input change keyup blur paste`, function() {
                        handleInputChange(this);
                    });
                }

                if (quantityInput) {
                    $(quantityInput).on(`input change keyup blur paste`, function() {
                        handleInputChange(this);
                    });
                }

                if (frequencyInput) {
                    $(frequencyInput).on(`input change keyup blur paste`, function() {
                        handleInputChange(this);
                    });
                }
            }

            $(document).ready(function() {
                $(".has-many-requisition_items-form").each(function() {
                    setupRecalculation(this);
                });

                calculateGrandTotal();
                
            });

            // MutationObserver to watch dynamically added requisition item forms
            const requisitionObserver = new MutationObserver(function (mutationsList) {
                mutationsList.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (node) {
                        if (node.nodeType === Node.ELEMENT_NODE && $(node).hasClass("has-many-requisition_items-form")) {
                            // console.log("New requisition item form detected:", node);

                            // Populate budget line select
                            let $select = $(node).find("select[name*=\'budget_line_id\']");
                            if ($select.length) {
                                $select.empty().append(`<option value="">Select Budget Line</option>`);
                                $.each(globalBudgetLines, function (key, value) {
                                    $select.append(new Option(value, key));
                                });
                            }

                            // Set up calculation for the new form
                            setupRecalculation(node);
                        }
                    });
                });
            });

            // Observer to handle form removal (when requisition items are deleted)
            function observeFormRemovals() {
                const formsContainer = document.querySelector("#has-many-requisition_items .has-many-requisition_items-forms");
                if (!formsContainer) return;

                const removalObserver = new MutationObserver(function(mutationsList) {
                    mutationsList.forEach(function(mutation) {
                        if (mutation.type === `childList` && mutation.removedNodes.length > 0) {
                            // A form was removed, recalculate grand total
                            setTimeout(calculateGrandTotal, 100); // Small delay to ensure DOM is updated
                        }
                    });
                });

                removalObserver.observe(formsContainer, { childList: true });
            }

            if (targetNode) {
                requisitionObserver.observe(targetNode, { childList: true, subtree: true });
                console.log("MutationObserver started on requisition items container.");

                observeFormRemovals();
            } else {
                console.warn("Target node #has-many-requisition_items not found.");
            }


        ');

        Admin::script('
        let globalAdminBudgetLines = {};
            $("#adminprogram_id").change(function(){
                var program_id = $(this).val();
                $.get("/admin-activities/"+program_id, function(data){
                    $("#adminactivity_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#adminactivity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No budgetlines available for this activity</span>");
                    } else {
                        // Add a default option
                        $("#adminactivity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#adminactivity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });

            $("#adminactivity_id").change(function () {
                var activity_id = $(this).val();

                if (!activity_id) {
                    alert("Please select an outcome");
                    return;
                }

                $.get("/adminprogram-budgetlines/" + activity_id)
                    .done(function (data) {
                        globalAdminBudgetLines = data; // Store for later use

                        if ($.isEmptyObject(globalAdminBudgetLines)) {
                            alert("No outputs available for the selected outcome");
                            return;
                        }

                        // Optionally clear existing options in current select inputs
                        $("[id^=admin_budget_line_id]").each(function () {
                            let $select = $(this);
                            $select.empty().append(\'<option value="">Select Budget Line</option>\');
                            $.each(globalAdminBudgetLines, function (key, value) {
                                $select.append(new Option(value, key));
                            });
                        });
                    });
            });
            // Observer to detect new requisition item form added
            
            const adminobserver = new MutationObserver(function (mutationsList) {
                mutationsList.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (node) {
                        if ($(node).hasClass("has-many-requisition_items-form")) {
                            // Populate budget lines for the newly added form
                            let $select = $(node).find("[id^=admin_budget_line_id]");
                            $select.empty().append(\'<option value="">Select Budget Line</option>\');
                            $.each(globalAdminBudgetLines, function (key, value) {
                                $select.append(new Option(value, key));
                            });
                        }
                    });
                });
            });

            // Start observing
            if (targetNode) {
                adminobserver.observe(targetNode, { childList: true });
            }

            
        ');
        
        return $form;
    }


    // function to fetch budget lines under a chosen activity
    public function getActivitiesbudgetlines($id)
    {
        $activity_budget = Activity::where('id', $id)->value('budget');
        
        $budgetlines = BudgetLines::where('activity_id', $id)->pluck('name', 'id'); // Returns {id: name}
        
        // Sum of accountabilities for all requisitions under this activity
        $usedAmount = Accountability::whereHas('requisition', function ($query) use ($id) {
            $query->where('activity_id', $id);
        })->sum('amount_used');

        Log::info($usedAmount);
        Log::info($activity_budget);
        $remaining = $activity_budget - $usedAmount;
        Log::info($remaining);

        return [$budgetlines, $activity_budget, $remaining];
    }

    // function to fetch activities under a program
    public function getAdminActivities($id)
    {

        // $program = AdminProgram::find($id);
        $activities = AdminActivity::where('admin_program_id', $id) // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities


        return $activities;
    }


    // function to fetch budget lines under a chosen activity
    public function getAdminbudgetlines($id)
    {
        // $program = AdminProgram::find($id);
        $budgetlines = AdminBudget_lines::where('admin_activity_id', $id) // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $budgetlines;
    }
    
}
