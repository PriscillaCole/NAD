<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\Program;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Activity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());

        //filter by program name
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
        });

        $grid->column('id', __('Id'));
        $grid->column('program_id', __('Program'))->display(function($program_id){
            return Program::find($program_id)->name;
        });
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('budget', __('Budget'));
        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
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
        $show = new Show(Activity::findOrFail($id));

       
        $show->field('program_id', __('Program'))->as(function($program_id){
            return Program::find($program_id)->name;
        });
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('budget', __('Budget'));
        $show->field('created_at', __('Created at'));
        

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Activity());

        $form->select('program_id', __('Program'))->options(Program::all()->pluck('name', 'id'));
        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->decimal('budget', __('Budget'));
       

        return $form;
    }
}
