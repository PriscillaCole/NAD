<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\ProgramsController;
use App\Models\Outcome;
use App\Models\Program;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Layout\Content;

class ProgramController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Program';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Program());

        $grid->disableBatchActions();

        // show the user their programs only
        $user= auth()->user();
        if($user->isRole('staff')){
            $grid->model()->where('user_id', auth()->id());
            $grid->disableCreateButton();
        }

        //filter by name 
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('id', 'Program')->select(Program::all()->pluck('name', 'id'));
        });

        // change function for edit action
        $grid->actions(function ($actions) {
            // Disable delete button
            $actions->disableDelete();
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('user_id', __('Project Manager'))->display(function ($user_id) {
            // Use the relationship to fetch the user's name
            return $this->user ? $this->user->name : 'No Project Manager';
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
        $show = new Show(Program::findOrFail($id));
        // $program = Program::findOrFail($id);

        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('user_id', __('Program manager'))->as(function ($userId) {
            $user = User::find($userId); // Fetch the user by their ID
            return $user ? $user->name : 'N/A'; // Return the user's name or 'N/A' if the user doesn't exist
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
        $form = new Form(new Program());
       
        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->text('budget', __('Budget'));
        $form->select('user_id', __('Choose a Program manager'))
            ->options(User::whereHas('roles', function ($query) {
                $query->where('name', 'staff'); // Adjust 'name' to the correct column if needed
            })->pluck('name', 'id')) // Replace 'name' with the field representing the user's name
            ->attribute('id', 'adminprogram_id')
            ->required();
            $form->hasMany('items', 'Requisition Items', function ($form) {
                $form->text('description', 'Description');
                $form->number('quantity', 'Quantity');
                $form->decimal('unit_price', 'Unit Price')->default(0.00);
                $form->decimal('total_price', 'Total Price')->default(0.00)->readonly();
            });

        return $form;
    }

}
