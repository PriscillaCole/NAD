<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
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
        $user = auth()->user();
       
        // disable create button for finance and CD
        if ($user->isRole('finance')){
            $grid->disableCreateButton();
        }

        $grid->column('staff_id', __('Requested by'))->display(function($staff_id){
            return Staff::find($staff_id)->name;
        });
        $grid->column('code', __('Code'));
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

        $staff_id = Staff::where('user_id', $user->id)->first()->id;
        // \Log::info('Saving form requisition_items:', $staff_id);
                
        if ($user->isRole('manager')){
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

        
            $form->file('concept_note', __('Concept note'));
            $form->textarea('description', __('Description'));
            $form->hidden('amount', __('Amount'));
        }

        // if ($user->isRole('manager')) {
        //     // When saving the form, calculate the total amount of the requisition items
        //     $form->saving(function (Form $form) {
        //         $requisition_items = request()->input('requisition_items');
                
        //         // Check that the requisition items are not empty
        //         if (empty($requisition_items)) {  // Changed from $form->requisition_items
        //             admin_toastr('Please add requisition items', 'error');
        //             return back()->withInput();
        //         }
            
        //         $total_amount = 0;
        //         $budget_lines = [];
        //         $duplicateCategoryFound = false;
            
        //         foreach ($requisition_items as $item) {
        //             if (in_array($item['budget_line_id'], $budget_lines)) {
        //                 $duplicateCategoryFound = true;
        //                 break;
        //             }
                    
        //             $budget_lines[] = $item['budget_line_id'];
        //             $total_amount += floatval($item['quantity']) * floatval($item['unit_price']);
        //         }
            
        //         if ($duplicateCategoryFound) {
        //             admin_toastr('You have selected the same budget line twice', 'error');
        //             return back()->withInput();
        //         }
            
        //         $form->amount = $total_amount;
        //     });
        
        //     // When the form is saved, redirect to show view
        //     $form->saved(function (Form $form) {
        //         $total_amount = $form->amount;
        //         $id = $form->getKey(); // Changed from $form->model()->id
        //         admin_toastr('Requisition worth '. $total_amount. ' has been successfully submitted');
        //         return redirect('/requisitions/'.$id);
        //     });
            
        //     $form->hidden('staff_id')->default($staff_id);
        //     $form->text('code')->default('REQ-'.rand(1000, 9999))->readonly();
            
        //     // Modified program selection
        //     $form->select('program_id', __('Program'))
        //         ->options(Program::pluck('name', 'id'))
        //         ->required();
            
        //     // Modified activity selection
        //     $form->select('activity_id', __('Activity'))
        //         ->options(function ($id) {
        //             return Activity::where('id', $id)->pluck('name', 'id');
        //         })
        //         ->required();
        
        //     // Requisition items
        //     $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
        //         $form->select('budget_line_id', __('Budget Line'))
        //             ->options(function ($id) {
        //                 // Modified to use where and pluck
        //                 return BudgetLines::where('id', $id)
        //                     ->pluck('name', 'id')
        //                     ->toArray();
        //             })
        //             ->required();
                    
        //         $form->decimal('quantity', __('Quantity'))->required();
        //         $form->text('unit_of_measure', __('Unit of measure'))->required();
        //         $form->decimal('unit_price', __('Unit cost'))->required();
        //     });
        
        //     $form->file('concept_note', __('Concept note'));
        //     $form->textarea('description', __('Description'));
        //     $form->hidden('amount', __('Amount'));
        // }


        // finance comments
        else{


            $form->display('code', __('RequisitionID'))->default('REQ-'.rand(1000, 9999))->readonly();
            $form->select('program_id', __('Program'))->options(Program::all()->pluck('name', 'id'))->required()->readOnly();
            
            $form->select('activity_id', __('Activity'))->options(function ($id) {
            // Preload the selected activity for editing
            $activity = Activity::find($id);
            return $activity ? [$activity->id => $activity->name] : [];
            })->required()->readOnly();


            //add requisition items
            $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                // $form->select('budget_line_id', __('Budget Line'))->attribute('id', 'budget_line_id')->required();
                $form->select('budget_line_id', __('Budget Line'))
                ->options(function ($id) {
                    // Preload the selected budget line for editing
                    $budgetLine = BudgetLines::find($id);
                    return $budgetLine ? [$budgetLine->id => $budgetLine->name] : [];
                })
                ->required()->readOnly();
                $form->display('quantity', __('Quantity'))->required();
                $form->display('unit_of_measure', __('Unit of measure'))->required();
                $form->display('unit_price', __('Unit cost'))->required();
           
            })->disableCreate()
            ->disableDelete();

      
            $form->file('concept_note', __('Concept note'))->readonly();
            $form->display('description', __('Description'));
            $form->display('amount', __('Amount'));

            $form->divider('Approval decision');
              $form->radio('status', __('Status'))
                    ->options([
                        'approved'=> __('Approve'),
                        'amended'=> __('Amend')
                    
                    ])
                    ->when('approved', function(Form $form){
                        $form->textarea('amendment_notes', 'Approval Notes')->rules('nullable');
                    })
                    ->when('amended', function(Form $form){
                        $form->textarea('amendment_notes', __('Amendment notes'))->required();
                    });

             // Save handler for approval
            $form->saving(function (Form $form) use ($user) {
                
                    // Log the approval
                    Comments::create([
                        'requisition_id' => $form->model()->id,
                        'commented_by' => $user->id,
                        'status' => $form->approval_status,
                        'comment' => $form->amendment_notes,
                    ]);

                    // Update requisition status based on approval
                    if ($form->approval_status === 'rejected') {
                        $form->model()->status = 'rejected';
                    } elseif ($form->approval_status === 'approved') {
                        // Check if all approvers have approved
                        $allApproved = Comments::where('requisition_id', $form->model()->id)
                            ->where('status', 'approved')
                            ->distinct('role')
                            ->count() === 2; // Assuming 2 roles: head_of_finance and director

                        $form->model()->status = $allApproved ? 'approved' : 'pending';
                    }
                
            });

            // Add saved callback
            $form->saved(function (Form $form) {
                admin_toastr('Requisition status updated successfully', 'success');
                return redirect('/requisitions');
            });

        }

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
}
