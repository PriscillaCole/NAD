<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Admin\CustomProgramController as AdminCustomProgramController;
use App\Models\Outcome;
use App\Models\Program;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\CustomProgramController;
use Encore\Admin\Form\Layout\Column;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use GuzzleHttp\Psr7\Request;

use function Laravel\Prompts\form;
use function Laravel\Prompts\text;

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

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        // $show->has

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
       
        $user = auth()->user()->id;

        // redirect to the create view
        if ($form->isCreating()){
            // if(!$user->isRole('manager')){
            //     return Validation:: allowBasicUserToCreate($form);
            //     }
            return view('programs.create', compact('user'));
        }
        

        if ($form->isEditing()) {
            // $id = request()->route('program') ;
            // $program = Program::FindOrFail($id);

            // return view('programs.edit', compact('program'));
          
            $form->text('name');
            $form->hasMany('outcomes', function (Form\NestedForm $outcomeform) {
            $outcomeform->text('name');
            
            // $outcomeId = $outcomeform->model();
            // dd($outcomeId);
            $output= Outcome::FindOrFail($outcomeId);
            $outcomeform->html('
                <div class="form-group" >
                    <label for="outcome_name" class="col-sm-2 asterisk control-label">Outcome Name</label>
                    <div class="col-sm-8" >
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="text" name="outcomes[__INDEX__][name]" value="'.$output->name.'" class="form-control mb-2" placeholder="Enter Outcome Name" required />
                        </div>
                    </div>
                </div>
            ');
            });
        }
        return $form;
    }

}
