<?php

namespace App\Admin\Controllers;

use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class StaffController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Staff';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Staff());

        //filter by staff number,  name,contract start date, contract end date, project, region, duty station, line manager, 
        $grid->filter(function($filter){
            // Remove the default id filter
                $filter->disableIdFilter();
                $filter->like('name', 'Name')->select(Staff::all()->pluck('name', 'name'));
                $filter->like('contract_start', 'Contract start date')->select(Staff::all()->pluck('contract_start', 'contract_start'));
                $filter->like('contract_end', 'Contract end date')->select(Staff::all()->pluck('contract_end', 'contract_end'));
                $filter->like('project', 'Project')->select(Staff::all()->pluck('project', 'project'));
                $filter->like('region', 'Region')->select(Staff::all()->pluck('region', 'region'));
                $filter->like('duty_station', 'Duty station')->select(Staff::all()->pluck('duty_station', 'duty_station'));
                $filter->like('line_manager', 'Line manager')->select(Staff::all()->pluck('line_manager', 'line_manager'));
        
        });

     
        $grid->column('staff_number', __('Staff number'))->display(function ($staff_number) {
            $staff = Staff::findorFail($this->id);
            return "<a href='/staff/{$staff->id}'>$staff_number</a>";
        });
        $grid->column('nin_number', __('Nin number'));
        $grid->column('name', __('Name'));
        $grid->column('date_of_birth', __('Date of birth'));
        $grid->column('home_district', __('Home district'));
        $grid->column('title', __('Title'));
        $grid->column('contract_start', __('Contract start date'));
        $grid->column('contract_end', __('Contract end date'));
        $grid->column('telephone', __('Telephone'));
        $grid->column('email', __('Email'));
      
       

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
   
        $staff = Staff::findorFail($id);
      
 
        return view('users_profile', compact('staff'));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Staff());

        $form->text('staff_number', __('Staff number'))->attribute('number', 'true');
        $form->text('nin_number', __('Nin number'));
        $form->text('name', __('Name'));
        $form->date('date_of_birth', __('Date of birth'))->default(date('Y-m-d'));
        $form->text('home_district', __('Home district'));
        $form->text('title', __('Title'));
        $form->date('contract_start', __('Contract start date'))->default(date('Y-m-d'));
        $form->date('contract_end', __('Contract end date'))->default(date('Y-m-d'));
        $form->text('project', __('Project'));
        $form->text('region', __('Region'));
        $form->text('duty_station', __('Duty station'));
        $form->text('line_manager', __('Line manager'));
        $form->text('telephone', __('Telephone'));
        // make sure that the email address is unique
        $form->email('email', __('Email'))->rules('unique:staff,email');
        $form->text('bank', __('Bank'));
        $form->text('bank_account', __('Bank account'));
        $form->text('tin', __('Tin'));
        $form->text('nssf', __('Nssf'));
        $form->text('marital_status', __('Marital status'));
        $form->text('next_of_kin', __('Next of kin'));
        $form->text('contact_of_kin', __('Contact of kin'));
        $form->text('relationship', __('Relationship'));
        $form->file('profile_picture', __('Profile picture'));

        // Add a button at the top to upload an excel file
        $form->tools(function (Form\Tools $tools) {
            $token = csrf_token(); // Fetch CSRF token
            $tools->append('<label for="file-upload" class="btn btn-sm btn-success" style="margin-right: 10px;">
                <i class="fa fa-upload"></i>&nbsp;Upload Staff
                <input id="file-upload" type="file" style="display: none;" onchange="uploadFile(this, \''.$token.'\')">
            </label>
            <progress id="upload-progress" value="0" max="100" style="display: none;"></progress>');
        });

        //script to handle the file upload
        Admin::js('/js/uploadStaff.js');
        return $form;
    }
}
