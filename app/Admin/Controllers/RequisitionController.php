<?php

namespace App\Admin\Controllers;

use App\Models\Program;
use App\Models\Requisition;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;

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
        });;
       

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

        //when saving the form, calculate the total amount of the requisition items and save it in the amount field
        $form->saving(function (Form $form) {

            // Check that the requisition items are not empty
            if (empty($form->requisition_items)) {
                admin_toastr('Please add requisition items', 'error');
                return back()->withInput();
            }
        
            $total_amount = 0;
            $categories = [];
            $duplicateCategoryFound = false;
        
            foreach ($form->requisition_items as $item) {
                // Check if the category_id is already in the $categories array
                if (in_array($item['category_id'], $categories)) {
                    $duplicateCategoryFound = true;
                    break; // Exit the loop early if a duplicate is found
                }
                
                // Add the category_id to the $categories array
                $categories[] = $item['category_id'];
        
                // Calculate the total amount of the requisition
                $total_amount += $item['quantity'] * $item['unit_price']; // Fixed unit_price to unit_cost to match the form field
            }
        
            // If a duplicate category was found, show an error message and return back with input
            if ($duplicateCategoryFound) {
                admin_toastr('You have selected the same category twice', 'error');
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
        $form->select('activity_id', __('Activity'))->attribute('id', 'activity_id')->required()->rules('exists:activities,id');

        //add requisition items
        $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
            $form->select('category_id', __('Category'))->options(\App\Models\Category::all()->pluck('name', 'id'))->required();
            $form->text('item', __('Item'));
            $form->decimal('quantity', __('Quantity'))->required();
            $form->text('unit_of_measure', __('Unit of measure'))->required();
            $form->decimal('unit_price', __('Unit cost'))->required();
           
            
            
        });

      
        $form->file('concept_note', __('Concept note'));
        $form->textarea('description', __('Description'));
        $form->hidden('amount', __('Amount'));

        if($user->isRole('finance')){
            $form->textarea('amendment_notes', __('Amendment notes'))->required();
            $form->hidden('status', __('Status'))->default('amended');
        }

        //script to show activity based on program selected
        Admin::script('
        $("#program_id").change(function(){
            var program_id = $(this).val();
            $.get("/program-activities/"+program_id, function(data){
                $("#activity_id").empty();
                $("#no-activities-message").remove(); // Always remove the message when a new selection is made
                
                if($.isEmptyObject(data)) {
                    // If no activities, show a red message
                    $("#activity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
                } else {
                    // If activities exist, remove any error message and populate the dropdown
                    $.each(data, function(key, value){
                        $("#activity_id").append("<option value="+key+">"+value+"</option>");
                    });
                }
            });
        });
    ');




        return $form;
    }

    public function getProgramActivities($id)
    {

        $activities = Program::find($id)->activities->pluck('name', 'id');
        return $activities;
    }
}
