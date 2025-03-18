<?php

namespace App\Admin\Controllers;

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
            });
        }
        
            $grid->actions(function ($actions) {
                if ($actions->row->status == 'approved') {
                    $actions->disableEdit();
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
        $grid->column('id', __('Requisition Documents'))->display(function ($id)
        {
            $requisition = Requisition::find($id);
        
            // if ($requisition && $requisition->status == 'approved') {
                $token = csrf_token();
                $downloadLink = admin_url('/requisitions/download/'. $id);
                return "<b>
                          Download documents
                        </b>";
            // } else
            // {          
            //     return '<b> No accountability</b>';
            // }
        })
        ->link(function () {
            // Use the dynamically generated link
            return $this->value; // This is the link returned by the `display()` method
        }, '_blank', function () {
            // Optional attributes or classes for the link
            return ['class' => 'btn btn-sm btn-primary']; // Example: add a button style
        });;
        // $grid->column('id', __('Inspection Report'))->display(function ($id) {
        //     $downloadLink = admin_url('/requisitions/download/' . $id);
            
        //     return $downloadLink; // Return the dynamic link for each row
        // })->link(function () {
        //     // Use the dynamically generated link
        //     return $this->value; // This is the link returned by the `display()` method
        // }, '_blank', function () {
        //     // Optional attributes or classes for the link
        //     return ['class' => 'btn btn-sm btn-primary']; // Example: add a button style
        // });
        
        

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

        return view('requisition_request', compact('requisition'));

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
                }
                else{
                    foreach ($requisition_items as $item) {
                        // Check if the category_id is already in the $categories array
                        if (in_array($item['budget_line_id'], $budget_lines)) {
                            $duplicateCategoryFound = true;
                            break; // Exit the loop early if a duplicate is found
                        }
                        
                        // Add the category_id to the $categories array
                        $budget_lines[] = $item['budget_line_id'];
                        
                        // Calculate the total amount of the requisition
                        $total_amount += $item['quantity'] * $item['unit_price']; // Fixed unit_price to unit_cost to match the form field
                    }
                
                    // If a duplicate category was found, show an error message and return back with input
                    if ($duplicateCategoryFound) {
                        admin_toastr('You have selected the same budget line twice', 'error');
                        return back()->withInput();
                    }
                }
            
                // Set the total amount after validation
                $form->amount = $total_amount;
            
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
                $form->select('admin_program_id', __('Program'))->options(AdminProgram::where('user_id', $staff_id)->pluck('name', 'id'))->attribute('id', 'adminprogram_id')->required();
                $form->select('activity', __('Activity'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = AdminActivity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'adminactivity_id')->required();
            
                $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                    $form->select('admin_budget_line_id', __('Budget Line'))
                    ->options(function ($id) {
                        // Preload the selected budget line for editing
                        $adminbudgetLine = AdminBudget_lines::find($id);
                        return $adminbudgetLine ? [$adminbudgetLine->id => $adminbudgetLine->name] : [];
                    })
                    ->attribute('id', 'admin_budget_line_id')
                    ->required();
                    $form->decimal('quantity', __('Quantity'))->required();
                    $form->text('unit_of_measure', __('Unit of measure'))->required();
                    $form->decimal('unit_price', __('Unit cost(UGX)'))->required();
                
                });
            }else{
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
                // $form->date('setOff_date', __('Set Off Date'))->required();
                // $form->date('return_date', __('Return Date'))->required();

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
                        $form->decimal('unit_price', __('Unit cost(UGX)'))->attribute([
                            'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                        ])->required();
                    
                    });
            }
            $form->file('concept_note', __('Concept note'))->required();
            $form->textarea('description', __('Description'));
            $form->hidden('amount', __('Amount(UGX)'));
            
        Admin::script
        ('
            $("form").on("submit", function(e) {
                console.log("Form submitted", $(this).serialize());
            });
            
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
            $("#program_id").change(function(){
                var program_id = $(this).val();
                $.get("/program-outcomes/"+program_id, function(data){
                    $("#outcome_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#outcome_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
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
                        $("#output_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
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
                        $("#activity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
                    } else {
                        // Add a default option
                        $("#activity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#activity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
           
            $("#activity_id").change(function() {
                var activity_id = $(this).val();
                if (!activity_id) {
                    alert("Please select an activity");
                    return;
                }

                 $.get("/budgetlines/" + activity_id)
                    .done(function(data) {
                    var budgetLines = data[0]; // Extract budget lines object
                    var activity_budget = Number(data[1]).toLocaleString(\'en-US\'); // Extract activity budget

                    // // Format activity_budget with commas
                    // var formattedBudget = Number(activity_budget).toLocaleString(\'en-US\');

                    
                    $("#activity_budget").val(activity_budget);
                    if ($.isEmptyObject(budgetLines)) {
                        alert("No budget lines available for the selected activity");
                        return;
                    }

                    // Clear existing requisition items
                    $("#has-many-requisition_items").find(".has-many-requisition_items-forms").empty();

                    // Dynamically add requisition items for each budget line
                    $.each(budgetLines, function(key, value) {
                        $(".add").click(); // Simulate clicking the "Add" button to add a new requisition item
                        
                        // Wait for the new form to be added, then populate its fields
                        setTimeout(function() {
                            var lastForm = $("#has-many-requisition_items").find(".has-many-requisition_items-forms").children().last();
                            var budgetLineField = $("[id^=budget_line_id]");
                            
                                budgetLineField.append(new Option(value, key, true, true)); // Add and select the option
                                budgetLineField.trigger("change"); // Trigger change for any dependencies
                            
                            // Optionally, set other default values here (e.g., quantity, unit_of_measure)
                        }, 100); // Add a small delay to ensure the form is rendered
                    });
                });
            });

        ');

        Admin::script('
            $("#adminprogram_id").change(function(){
                var program_id = $(this).val();
                $.get("/admin-activities/"+program_id, function(data){
                    $("#adminactivity_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#adminactivity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
                    } else {
                        // Add a default option
                        $("#adminactivity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#adminactivity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
           
            $("#adminactivity_id").change(function() {
                var activity_id = $(this).val();
                if (!activity_id) {
                    alert("Please select an activity");
                    return;
                }

                 $.get("/adminprogram-budgetlines/" + activity_id)
                    .done(function(data) {
                    if ($.isEmptyObject(data)) {
                        alert("No budget lines available for the selected activity");
                        return;
                    }

                    // Clear existing requisition items
                    $("#has-many-requisition_items").find(".has-many-requisition_items-forms").empty();

                    // Dynamically add requisition items for each budget line
                    $.each(data, function(key, value) {
                        $(".add").click(); // Simulate clicking the "Add" button to add a new requisition item
                        
                        // Wait for the new form to be added, then populate its fields
                        setTimeout(function() {
                            var lastForm = $("#has-many-requisition_items").find(".has-many-requisition_items-forms").children().last();
                            var budgetLineField = $("[id^=admin_budget_line_id]");
                            
                                budgetLineField.append(new Option(value, key, true, true)); // Add and select the option
                                budgetLineField.trigger("change"); // Trigger change for any dependencies
                            
                            // Optionally, set other default values here (e.g., quantity, unit_of_measure)
                        }, 100); // Add a small delay to ensure the form is rendered
                    });
                });
            });
            
        ');
        
        return $form;
    }


    // function to fetch budget lines under a chosen activity
    public function getActivitiesbudgetlines($id)
    {
        $activity_budget = Activity::where('id', $id)->pluck('budget');
        
        $budgetlines = BudgetLines::where('activity_id', $id)->pluck('name', 'id'); // Returns {id: name}
        

        return [$budgetlines, $activity_budget];
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
