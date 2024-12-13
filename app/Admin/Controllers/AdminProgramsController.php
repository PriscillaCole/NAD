<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\ProgramsController;
use App\Models\AdminProgram;
use App\Models\Outcome;
use App\Models\Program;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Layout\Content;

class AdminProgramsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Admin Program';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminProgram());
        $grid->disableBatchActions();

        $user = auth()->user();

        //filter by name 
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', 'Name')->placeholder('Search Name');
        });

        if($user->isRole('finance', 'staff')){
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
        
            $grid->model()->where('staff_id', $staff_id);
            $grid->column('id', __('Id'));
        }
        $grid->column('name', __('Name'));
        
        

        // change function for edit action
        $grid->actions(function ($actions) {
            // Disable delete button
            $actions->disableDelete();
        });

        $grid->column('user_id', __('Project Manager'))->display(function ($user_id) {
            // Use the relationship to fetch the user's name
            return Staff::find($user_id)->name;
        });
        $grid->column('description', __('Description'));
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
    $show = new Show(AdminProgram::findOrFail($id));

    // Display the Admin Program details
    // $show->field('id', __('ID'));
    $show->field('name', __('Name'));
    $show->field('description', __('Description'));
    $show->field('budget', __('Budget'));
    $show->field('user_id', __('Created by'))->as(function ($userId) {
        $staff = Staff::find($userId);
        return $staff ? $staff->name : 'N/A'; // Assuming `Staff` has a `name` attribute
    });

    // Display related budget lines
    $show->adminBudgetlines('Budget Lines', function ($budgetLine) {
        $budgetLine->resource('/admin-budgetlines');
        
        $budgetLine->name('Item Name');
        $budgetLine->unit_cost(__('Unit Cost'));
        $budgetLine->quantity( __('Quantity'));
        $budgetLine->frequency( __('Frequency'));
        $budgetLine->total_cost( __('Total Cost'));

        $budgetLine->disableActions();
    });

    return $show;
}


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form= new Form(new AdminProgram());
       
        $user = auth()->user();

        $staff_id = Staff::where('user_id', $user->id)->first()->id;
        

        $form->text('name', __('Name'));
        $form->textarea('description');
        $form->text('budget');
        $form->hidden('user_id')->default($staff_id);


        $form->hasMany('adminBudgetlines', 'Items', function (Form\NestedForm $form) {
            $form->text('name');
            $form->text('unit_cost');
            $form->text('quantity');
            $form->text('frequency');
            $form->text('total_cost');
           
        });

        return $form;
    }

}
