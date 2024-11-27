<?php

namespace App\Admin\Controllers;

use App\Models\Outcome;
use App\Models\Program;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

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

        //filter by name 
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', 'Name')->placeholder('Search Name');
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
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

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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

        $form->text('name', __('Program Name'))->rules('unique:programs,name');
        //enter other costs
        // $form->divider('Other costs');
        // $form->text('Activity', __('Activity'));

        // $form->hasMany('outcomes', 'Outcome', function (Form\NestedForm $form) {
        //     $form->text('name', __('Outcome name'));
        //      $form->hasMany('outcomes', 'output', function (Form\NestedForm $form){
        //         $form->text('item');
        //         $form->decimal('quantity', __('Quantity'))->required();
        //         $form->text('unit_of_measure', __('Unit of measure'))->required();
        //         $form->decimal('unit_price', __('Unit cost'))->required();
            
        //     });
        // });

        // entering the activity costs
        $form->divider('Activity costs');
        
        $form->hasMany('outcomes', 'Outcome', function (Form\NestedForm $form) {
            $form->text('name', __('Outcome name'));
            // $form = new Form(new Outcome());    
            $form->hasMany('outputs', 'output', function (Form\NestedForm $form){
                $form->text('item');
            });
            
        });
        $form->text('budget lines', __('Budget lines'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
