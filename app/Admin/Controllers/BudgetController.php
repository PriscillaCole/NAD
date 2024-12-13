<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\ProgramsController;
use App\Models\Outcome;
use App\Models\Program;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Layout\Content;

class BudgetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Budgets';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Program());

        $grid->model()->where('user_id', auth()->id());


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
        $program = Program::findOrFail($id);

        return view('budgets.show', compact('program'));

    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Program());
       
        // redirect to the create view
        if ($form->isCreating()){
            $user = auth()->user()->id;
            $programs = Program::where('user_id', $user)->get();
            // dd($programs);
            
            return view('budgets.create', compact('programs'));
        }
        

        return $form;
    }

    public function edit($id, Content $content)
    {
        // Fetch the program using the provided ID
        $program = Program::findOrFail($id);

        return $content
            ->title('Edit Program') // Page title
            ->description('Edit the program details') // Page description
            ->body(view('budgets.edit', compact('program'))); // Custom view for editing
    }

}
