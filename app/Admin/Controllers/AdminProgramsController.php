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
        $grid->column('budget', __('Budget'));
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
        $program = AdminProgram::findOrFail($id);

        return view('adminbudgets.show', compact('program'));
        
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
            $programs = AdminProgram::get();
            
            return view('adminbudgets.create', compact('programs', 'user'));
        }
        

        return $form;
    }

    public function edit($id, Content $content)
    {
        // Fetch the program using the provided ID
        $adminprogram = AdminProgram::findOrFail($id);

        return $content
            ->title('Edit Budget') // Page title
            ->description('Edit the Admin program details') // Page description
            ->body(view('adminbudgets.edit', compact('adminprogram'))); // Custom view for editing
    }

}
