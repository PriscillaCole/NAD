<?php

namespace App\Admin\Controllers;

use App\Models\Budget;
use App\Models\Program;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Requisition;
use App\Models\Activity;
use Carbon\Carbon;

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

        //disable creation, editing and deleting and viewing
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableBatchActions();

        //filter by program and activity
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('requisition_id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            $filter->equal('requisition.program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
            $filter->equal('requisition.activity_id', 'Activity')->select(Activity::all()->pluck('name', 'id'));
        });

        $grid->column('id', __('Id'));
        $grid->column('requisition_id', __('Requisition id'))->display(function ($requisition_id) {
            return Requisition::find($requisition_id)->code;
        });
        $grid->column('', __('Program'))->display(function ($total_amount) {
            $program_id = Requisition::find($this->requisition_id)->program_id;
            return Program::find($program_id)->name;
        });
        $grid->column('activity', __('Activity'))->display(function ($total_amount) {
            $activity_id = Requisition::find($this->requisition_id)->activity_id;
            return Activity::find($activity_id)->name;
        });
        $grid->column('budget', __('Budget'))->display(function ($total_amount) {
            $activity_id = Requisition::find($this->requisition_id)->activity_id;
            return number_format(Activity::find($activity_id)->budget);
        });

        $grid->column('total_amount_used', __('Total amount used'))->display(function ($total_amount) {
            return number_format($total_amount, 2);
        });

        $grid->column('balance', __('Balance'))->display(function ($total_amount) {
            $activity_id = Requisition::find($this->requisition_id)->activity_id;
            $activity = Activity::find($activity_id);
            $balance = $activity->budget - $this->total_amount_used;
        
            // Determine the color based on the balance value
            $color = $balance < 0 ? 'red' : 'black';
        
            // Return the formatted balance with inline style for color
            return "<span style='color: {$color};'>" . number_format($balance, 2) . "</span>";
        });
        

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
