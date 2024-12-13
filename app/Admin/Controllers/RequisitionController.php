<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AdminBudget_lines;
use App\Models\AdminProgram;
use App\Models\BudgetLines;
use App\Models\Comments;
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
        if ($user->isRole('finance')){
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
        }

        // order by latest requisition
        $grid->model()->orderBy('created_at', 'desc');

        //show staff only requisitions made by them if they are not admin
        if ($user->inRoles(['staff', 'admin'])) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
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
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'amended' => 'Amended'
            ]);
        });
       
        $grid->column('code', __('Code'));
        $grid->column('staff_id', __('Requested by'))->display(function($staff_id){
            return Staff::find($staff_id)->name;
        });
        $grid->column('amount', __('Amount'));
        $grid->column('status', __('Status'))->display(
            function ($status) {
                if ($status == null) {
                    return "<span class='label label-warning'>pending</span>";
                } elseif ($status == 'approved') {
                    return "<span class='label label-success'>approved</span>";
                } elseif ($status == 'rejected') {
                    return "<span class='label label-danger'>rejected</span>";
                } elseif ($status == 'amended') {
                    return "<span class='label label-info'>amended</span>";
                }
            }
        );
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
                ->whereDoesntHave('accountabilities') // Check if there's no accountability
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
        // \Log::info('Saving form requisition_items:', $staff_id);
        
            //when saving the form, calculate the total amount of the requisition items and save it in the amount field
            $form->saving(function (Form $form) {
                \Log::info('Saving form requisition_items:', $form->requisition_items);
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
                $form->select('admin_program_id', __('Program'))->options(AdminProgram::all()->pluck('name', 'id'))->attribute('id', 'adminprogram_id')->required();
            
                $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                    $form->select('admin_budget_line_id', __('Budget Line'))
                    ->options(function ($id) {
                        // Preload the selected budget line for editing
                        $adminbudgetLine = AdminBudget_lines::find($id);
                        return $adminbudgetLine ? [$adminbudgetLine->id => $adminbudgetLine->name] : [];
                    })
                    ->attribute('id', 'Adminbudget_line_id')
                    ->required();
                    $form->decimal('quantity', __('Quantity'))->required();
                    $form->text('unit_of_measure', __('Unit of measure'))->required();
                    $form->decimal('unit_price', __('Unit cost'))->required();
                
                });
            }else{
                $form->text('code', __('RequisitionID'))->default('REQ-'.rand(1000, 9999))->readonly();
                $form->select('program_id', __('Program'))->options(Program::all()->pluck('name', 'id'))->attribute('id', 'program_id')->required();
            
                $form->select('activity_id', __('Activity'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = Activity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'activity_id')->required();
        
        
                    //add requisition items
                    $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                        $form->select('budget_line_id', __('Budget Line'))
                        ->options(function ($id) {
                            // Preload the selected budget line for editing
                            $budgetLine = BudgetLines::find($id);
                            return $budgetLine ? [$budgetLine->id => $budgetLine->name] : [];
                        })
                        ->attribute('id', 'budget_line_id')
                        ->required();
                        $form->decimal('quantity', __('Quantity'))->required();
                        $form->text('unit_of_measure', __('Unit of measure'))->required();
                        $form->decimal('unit_price', __('Unit cost'))->required();
                    
                    });
            }
            $form->file('concept_note', __('Concept note'));
            $form->textarea('description', __('Description'));
            $form->hidden('amount', __('Amount'));


        //script to show activity based on program selected
        Admin::script('
            $("#program_id").change(function(){
                var program_id = $(this).val();
                $.get("/program-activities/"+program_id, function(data){
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

            // Handle both activity changes and direct budget line dropdown clicks
            $(document).on("change", "#activity_id", function() {
                var activity_id = $(this).val();
                updateAllBudgetLineDropdowns(activity_id);
            });

            // Function to update all budget line dropdowns
            function updateAllBudgetLineDropdowns(activity_id) {
                if (!activity_id) return;

                $("[id^=budget_line_id]").each(function() {
                    var currentDropdown = $(this);
                    var messageSpan = currentDropdown.next("#no-activities-message");

                    // Clear previous options and messages
                    currentDropdown.empty();
                    if (messageSpan.length) messageSpan.remove();

                    $.get("/budgetlines/" + activity_id)
                        .done(function(data) {
                            if ($.isEmptyObject(data)) {
                                currentDropdown.after("<span id=\'no-activities-message\' style=\'color: red;\'>No budget lines available for this activity</span>");
                            } else {
                                // Add a default option
                                currentDropdown.append(new Option(\'Select Budget Line\', \'\'));
                                
                                // Add all budget lines
                                $.each(data, function(key, value) {
                                    currentDropdown.append(new Option(value, key));
                                });
                            }
                        })
                        .fail(function() {
                            alert("Error fetching budget lines. Please try again.");
                        });
                });
            }

            // Handle new items being added
            $(".add").click(function(){
                setTimeout(function(){
                    var activity_id = $("#activity_id").val();
                    if (activity_id) {
                        updateAllBudgetLineDropdowns(activity_id);
                    }
                }, 100);
            });


            $("#adminprogram_id").change(function(){
                var program_id = $(this).val();
                $.get("/adminprogram-budgetlines/"+program_id, function(data){
                    $("#Adminbudget_line_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#Adminbudget_line_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No budget line available for this program</span>");
                    } else {
                        // Add a default option
                        $("#Adminbudget_line_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#Adminbudget_line_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
        ');

        
        return $form;
    }

    // function to fetch activities under a program
    public function getProgramActivities($id)
    {
        $program = Program::find($id);
        $activities = $program->outcomes // Get all outcomes for the program
            ->flatMap(function ($outcome) {
                return $outcome->outputs; // Get all outputs for each outcome
            })
            ->flatMap(function ($output) {
                return $output->activities; // Get all activities for each output
            })
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $activities;
    }

    // function to fetch budget lines under a chosen activity
    public function getActivitiesbudgetlines($id)
    {
        $activities = Activity::find($id);
        $budgetlines = $activities->budget_lines // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $budgetlines;
    }

    // function to fetch budget lines under a chosen activity
    public function getAdminbudgetlines($id)
    {
        $program = AdminProgram::find($id);
        $budgetlines = $program->adminBudgetlines // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $budgetlines;
    }
}
