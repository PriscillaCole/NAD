<?php

namespace App\Admin\Controllers;

use App\Models\Budget;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BudgetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Budget';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Budget());

        $grid->column('id', __('Id'));
        $grid->column('requisition_id', __('Requisition id'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('actual_amount', __('Actual amount'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Budget::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('requisition_id', __('Requisition id'));
        $show->field('total_amount', __('Total amount'));
        $show->field('actual_amount', __('Actual amount'));
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
        $form = new Form(new Budget());

        $form->number('requisition_id', __('Requisition id'));
        $form->decimal('total_amount', __('Total amount'));
        $form->decimal('actual_amount', __('Actual amount'));

        return $form;
    }
}
