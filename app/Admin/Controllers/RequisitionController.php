<?php

namespace App\Admin\Controllers;

use App\Models\Accountability;
use App\Models\Activity;
use App\Models\AdminActivity;
use App\Models\AdminBudget_lines;
use App\Models\AdminProgram;
use App\Models\BudgetLines;
use App\Models\Comments;
use App\Models\Outcome;
use App\Models\Output;
use App\Models\Program;
use App\Models\Requisition;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

use function App\Http\Controllers\formatAmount;

class RequisitionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Requisition';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    // protected function grid()
    // {
        
    //     $grid = new Grid(new Requisition());
    //     $grid->disableBatchActions();

    //     $user = auth()->user();
    //     // disable create button for finance and CD
    //     if ($user->inRoles(['finance', 'director'])){
    //         $grid->disableCreateButton();
    //         $grid->actions(function ($actions) {
    //             $actions->disableEdit();
    //             if ($actions->row->status == 'approved') {
    //                 $actions->disableDelete();
    //             }
    //             // $actions->disableDelete();
    //         });
    //     }else{
    //         $grid->actions(function ($actions) {
    //             if ($actions->row->status == 'approved') {
    //                 $actions->disableEdit();
    //                 $actions->disableDelete();
    //             }
    //         });
        
    //     }
        
            

    //     // order by latest requisition
    //     $grid->model()->orderBy('created_at', 'desc');

    //     //show staff only requisitions made by them if they are not admin
    //     if ($user->inRoles(['staff', 'admin'])) {
    //         $staff_id = Staff::where('user_id', $user->id)->first()->id;
    //         $grid->model()->where('staff_id', $staff_id);
    //     }
        
    //     // show the CD only accepted requisitions
    //     // if ($user->inRoles(['director'])) {
    //     //     $grid->model()->where('status', 'accepted');
    //     // }

    //      //filter by program and activity
    //      $grid->filter(function($filter){
    //         $filter->disableIdFilter();
    //         $filter->equal('id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
    //         $filter->equal('program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
    //         $filter->equal('activity_id', 'Activity')->select(Activity::all()->pluck('name', 'id'));
    //         //status filter
    //         $filter->equal('status', 'Status')->select([
    //             'pending' => 'Pending',
    //             'approved' => 'Authorized',
    //             'rejected' => 'Rejected',
    //             'accepted' => 'Approved',
    //             'amended' => 'Amended'
    //         ]);
    //     });
       
    //     $grid->column('code', __('Code'));
    //     $grid->column('staff_id', __('Requested by'))->display(function($staff_id){
    //         return Staff::find($staff_id)->name;
    //     });
        
    //         $grid->column('', 'Program')->display(function(){
    //             if ($this->program_id) {
    //                 return Program::find($this->program_id)->name ?? 'N/A';
    //             }
    //             if ($this->admin_program_id) {
    //                 return AdminProgram::find($this->admin_program_id)->name ?? 'N/A';
    //             }
    //             return 'N/A';
                
    //         });
        
    //     $grid->column('amount', __('Amount (UGX)'))->display(function ($value) {
    //         return number_format($value, 0, '.', ','); // Format with commas
    //     });
    //     $grid->column('status', __('Status'))->display(
    //         function ($status) {
    //             if ($status == 'pending') {
    //                 return "<span class='label label-warning'>pending</span>";
    //             } elseif ($status == 'approved') {
    //                 return "<span class='label label-success'>Authorized</span>";
    //             } elseif ($status == 'rejected') {
    //                 return "<span class='label label-danger'>Rejected</span>";
    //             } elseif ($status == 'amended') {
    //                 return "<span class='label label-info'>Amended</span>";
    //             }elseif ($status == 'accepted') {
    //                 return "<span class='label label-primary'>Approved</span>";
    //             }
    //         }
    //     );
        
    //     // $id = $grid->column('id');
    //     // $downloadLink = admin_url('/requisitions/download/'. $id);
    //     // $grid->column('id', __('Requisition Documents'))->display(function ($id)
    //     // {
    //     //     $requisition = Requisition::find($id);

    //     //     // if ($requisition && $requisition->status == 'approved') {
    //     //         $token = csrf_token();
    //     //         $downloadLink = admin_url('/requisitions/download/'. $id);
    //     //         return "<b>Download documents</b>";
    //     //     // } else
    //     //     // {          
    //     //     //     return '<b> No accountability</b>';
    //     //     // }
    //     // })
    //     // ->link(function ($value, $row) {
    //     //     // Generate the download link using the row's ID
    //     //     return admin_url('/requisitions/download/'. $row->id);
    //     // }, '', function () {
    //     //     // Add download attribute to force download instead of opening new tab
    //     //     return [
    //     //         'class' => 'btn btn-sm btn-primary',
    //     //         'download' => true  // This forces download
    //     //     ];
    //     // });

    //     $grid->column('id', __('Requisition Documents'))->display(function ($id)
    //     {
    //         $requisition = Requisition::find($id);

    //         if ($requisition && $requisition->status == 'approved') {
    //              $downloadLink = admin_url('/requisitions/download/'. $id);
    //              $token = csrf_token();
            
    //         return "
    //                 <form method='POST' action='{$downloadLink}' style='display: inline;'>
    //                     <input type='hidden' name='_token' value='{$token}'>
    //                     <button type='submit' class='btn btn-sm btn-primary'>
    //                         <b>Download documents</b>
    //                     </button>
    //                 </form>";
    //         }
    //         else
    //         {          
    //             return '<b> No accountability</b>';
    //         }
           
    //     });
        
        

    //     // or pass in a specified href
    //     // $grid->column('homepage')->link($href);
    //     $grid->column('created_at', __('Created at'))->display(function ($created_at) {
    //         //return human readable format
    //         return (Carbon::parse($created_at)->diffForHumans());
    //     });
         

    //     return $grid;
    // }

    protected function grid()
    {
        $grid = new Grid(new Requisition());
        $grid->disableBatchActions();

        $user = auth()->user();
        $staff_id = Staff::where('user_id', $user->id)->first()->id;
        
        // Define role priorities - finance/director wins over admin
        $isAdminOnly = $user->inRoles(['admin']);
        $isFinanceOrDirector = $user->inRoles(['finance', 'director']) && !$isAdminOnly;
        $isStaffOnly = $user->inRoles(['staff']);

        // Disable create button for finance and director (even if they also have admin)
        if ($isFinanceOrDirector) {
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
                if ($actions->row->status == 'approved') {
                    $actions->disableDelete();
                }

            });
        } else {
            // admin, staff, or any other role
            $grid->actions(function ($actions) {
                $staff_id = Staff::where('user_id', auth()->user()->id)->first()->id;
                Log::info('Checking actions for requisition ID: ' . $actions->row->id . ' with status: ' . $actions->row->status . ' and staff_id: ' . $actions->row->staff_id. ' and current user id: ' . $staff_id);
                
                if (($actions->row->staff_id != $staff_id) && in_array($actions->row->status, ['approved', 'amended', 'accepted', 'pending']) ) {
                    $actions->disableEdit();
                    $actions->disableDelete();
                }
                
            });
        }

        // Order by latest requisition
        $grid->model()->orderBy('created_at', 'desc');

        // Staff sees only their own requisitions; admin sees all
        if ($isStaffOnly) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
        }

        // Filter by program and activity
        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->equal('id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            $filter->equal('program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
            $filter->equal('activity_id', 'Activity')->select(Activity::all()->pluck('name', 'id'));
            $filter->equal('status', 'Status')->select([
                'pending'  => 'Pending',
                'approved' => 'Authorized',
                'rejected' => 'Rejected',
                'accepted' => 'Approved',
                'amended'  => 'Amended'
            ]);
        });

        $grid->column('code', __('Code'));
        $grid->column('staff_id', __('Requested by'))->display(function ($staff_id) {
            return Staff::find($staff_id)->name;
        });

        $grid->column('', 'Program')->display(function () {
            if ($this->program_id) {
                return Program::find($this->program_id)->name ?? 'N/A';
            }
            if ($this->admin_program_id) {
                return AdminProgram::find($this->admin_program_id)->name ?? 'N/A';
            }
            return 'N/A';
        });

        $grid->column('amount', __('Amount (UGX)'))->display(function ($value) {
            return number_format($value, 0, '.', ',');
        });

        $grid->column('status', __('Status'))->display(function ($status) {
            if ($status == 'pending') {
                return "<span class='label label-warning'>Pending</span>";
            } elseif ($status == 'approved') {
                return "<span class='label label-success'>Authorized</span>";
            } elseif ($status == 'rejected') {
                return "<span class='label label-danger'>Rejected</span>";
            } elseif ($status == 'amended') {
                return "<span class='label label-info'>Amended</span>";}
            elseif ($status == 'amend') {
                return "<span class='label label-info'>Amend</span>";
            } elseif ($status == 'accepted') {
                return "<span class='label label-primary'>Approved</span>";
            }
        });

        $grid->column('id', __('Requisition Documents'))->display(function ($id) {
            $requisition = Requisition::find($id);

            if ($requisition && $requisition->status == 'approved') {
                $downloadLink = admin_url('/requisitions/download/' . $id);
                $token = csrf_token();
                return "
                    <form method='POST' action='{$downloadLink}' style='display: inline;'>
                        <input type='hidden' name='_token' value='{$token}'>
                        <button type='submit' class='btn btn-sm btn-primary'>
                            <b>Download documents</b>
                        </button>
                    </form>";
            }

            return '<b>No accountability</b>';
        });

        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            return Carbon::parse($created_at)->diffForHumans();
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
        $show = new Show(Requisition::findOrFail($id));
        $requisition = Requisition::findOrFail($id);
        

        if($requisition->program?->type == 2){
            $activityid = $requisition->activity?->id;
            Log::info($requisition->program->adminActivities);
            // Sum of accountabilities for all requisitions under this activity
            $activity_budget = $requisition->adminoutcome?->budget;
            $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityid) {
            $query->where('activity_id', $activityid);
        })->sum('amount_used');
            //  $remaining =  0;
            Log::info($usedAmount);
            Log::info($activity_budget);

            $remaining = $activity_budget - $usedAmount;
        }else{
            $activityid = $requisition->activity->id;
            // Sum of accountabilities for all requisitions under this activity
            $activity_budget = $requisition->activity->budget;
            $usedAmount = Accountability::whereHas('requisition', function ($query) use ($activityid) {
            $query->where('activity_id', $activityid);
            })->sum('amount_used');

            Log::info($usedAmount);
            Log::info($activity_budget);

            $remaining = $activity_budget - $usedAmount;
        }

        Log::info($requisition->concept_note);

        return view('requisition_request', compact('requisition', 'remaining'));

    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
{
    $form = new Form(new Requisition());
    $user = auth()->user();

    if ($form->isCreating()) {
        $staff_id = Staff::where('user_id', $user->id)->first()->id;
    };

    $form->footer(function ($footer) {
                $footer->disableReset();
                $footer->disableViewCheck();
                $footer->disableEditingCheck();
                $footer->disableCreatingCheck();
            });

    $staff_id = Staff::where('user_id', $user->id)->first()->id;

    $form->saving(function (Form $form) {
        $requisition_items = request()->input('requisition_items');

        if (empty($form->requisition_items)) {
            admin_toastr('Please add requisition items', 'error');
            return back()->withInput();
        }
        Log::info('Saving requisition with items: ' . json_encode($requisition_items));
        
        // Access the underlying model to check current status
        $model = $form->model();
        if ($model->status == 'amend') {
            $model->status = 'amended';
        }

        Log::info('Requisition status after checking for amend: ' . $model->status);

        $total_amount = 0;
        $budget_lines = [];
        $duplicateCategoryFound = false;

        $user = auth()->user();

        if ($user->isRole('admin')) {
            foreach ($requisition_items as $item) {
                if (in_array($item['admin_budget_line_id'], $budget_lines)) {
                    $duplicateCategoryFound = true;
                    break;
                }
                $budget_lines[] = $item['admin_budget_line_id'];
                $total_amount += $item['quantity'] * $item['unit_price'];
            }

            if ($duplicateCategoryFound) {
                admin_toastr('You have selected the same budget line twice', 'error');
                return back()->withInput();
            }

            $form->amount = $total_amount;
        } else {
            if ($duplicateCategoryFound) {
                admin_toastr('You have selected the same budget line twice', 'error');
                return back()->withInput();
            }
        }
    });

    $form->saved(function (Form $form) {
        $total_amount = $form->amount;
        $id = $form->model()->id;
        admin_toastr('Requistion worth ' . $total_amount . ' has been successfully submitted');
        return redirect('/requisitions/' . $id);
    });

    $form->hidden('staff_id', __('Staff'))->default($staff_id);

    if ($user->isRole('admin')) {
        $form->text('code', __('RequisitionID'))->default('Admin-' . rand(1000, 9999))->readonly();
        $form->select('program_id', __('Program'))->options(Program::where('user_id', $user->id)->pluck('name', 'id'))->attribute('id', 'adminprogram_id')->required();
        $form->select('outcome_id', __('Outcome'))->options(function ($id) {
            $activity = AdminActivity::find($id);
            return $activity ? [$activity->id => $activity->name] : [];
        })->attribute('id', 'adminactivity_id')->required();

        $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
            $form->select('admin_budget_line_id', __('Output'))
                ->options(function ($id) {
                    $adminbudgetLine = AdminBudget_lines::find($id);
                    return $adminbudgetLine ? [$adminbudgetLine->id => $adminbudgetLine->name] : [];
                })
                ->attribute('id', 'admin_budget_line_id')
                ->required();
            $form->decimal('quantity', __('Quantity'))->required();
            $form->decimal('frequency', __('Frequency'))->required();
            $form->decimal('unit_price', __('Unit cost(UGX)'))->required();
            $form->text('unit_of_measure', __('Unit of measure'))->required();
            $form->decimal('total_price', __('Total amount'))->readonly()
                ->customFormat(function ($value) {
                    return !is_null($value) ? number_format($value, 0, '.', ',') : '';
                })
                ->attribute([
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                ]);
        });
    } else {
        $form->text('code', __('RequisitionID'))->default('REQ-' . rand(1000, 9999))->readonly();
        $form->select('program_id', __('Program'))->options(Program::where('user_id', $user->id)->pluck('name', 'id'))->attribute('id', 'program_id')->required();
        $form->select('outcome_id', __('Outcome'))->options(function ($id) {
            $outcome = Outcome::find($id);
            return $outcome ? [$outcome->id => $outcome->name] : [];
        })->attribute('id', 'outcome_id')->required();
        $form->select('output_id', __('Output'))->options(function ($id) {
            $output = Output::find($id);
            return $output ? [$output->id => $output->name] : [];
        })->attribute('id', 'output_id')->required();
        $form->select('activity_id', __('Activity'))->options(function ($id) {
            $activity = Activity::find($id);
            return $activity ? [$activity->id => $activity->name] : [];
        })->attribute('id', 'activity_id')->required();
        $form->text('', __('Activity budget(UGX)'))->attribute('id', 'activity_budget')->readonly();
        $form->text('', __('Remaining budget(UGX)'))->attribute('id', 'remaining_budget')->readonly();

        $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
            $form->select('budget_line_id', __('Budget Line'))
                ->options(function ($id) {
                    $budgetLine = BudgetLines::find($id);
                    return $budgetLine ? [$budgetLine->id => $budgetLine->name] : [];
                })
                ->attribute('id', 'budget_line_id')
                ->required()
                ->readOnly();
            $form->decimal('quantity', __('Quantity'))->required();
            $form->text('unit_of_measure', __('Unit of measure'))->required();
            $form->decimal('frequency', __('Frequency'))->required();
            $form->decimal('unit_price', __('Unit cost(UGX)'))
                ->attribute([
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                ])
                ->required();
            $form->decimal('total_price', __('Total amount'))->readonly()
                ->customFormat(function ($value) {
                    return !is_null($value) ? number_format($value, 0, '.', ',') : '';
                })
                ->attribute([
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                ]);
        });
    }

    $form->decimal('amount', __('Amount(UGX)'))->readonly();

    // With this:
    $form->html('<div id="existingConceptNoteWrapper"></div>');  

    $form->file('concept_note', __('Concept Note File'))->name(function ($file) {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        Log::info('Original file name: ' . $name);
        return \Illuminate\Support\Str::slug($name) . '-' . time() . '.' . $file->getClientOriginalExtension();
    })
        ->rules('mimes:pdf,doc,docx')
        ->help('If a concept note already exists for the selected activity, it will be displayed above and you do not need to upload a new one unless you want to replace it.')
        ->attribute(['id' => 'concept_note_upload']);

    $form->textarea('description', __('Description'));

    // $form->html('
    //     <script>
    //     $(document).ready(function() {
    //         $(".box-footer").find(".col-md-2").append(
    //             \'<div id="requisitionDraftBtnWrap" class="row" style="margin-top:8px; width:fit-content;">\'
    //             + \'<div class="col-md-2" style="padding-left:0; padding-right:16px;">\'
    //             + \'<button type="button" class="btn btn-info" id="saveDraftBtn">\'
    //             + \'<i class="fa fa-save"></i> Save Draft\'
    //             + \'</button>\'
    //             + \'</div>\'
    //             + \'<div class="col-md-2" style="padding-left:105px;">\'
    //             + \'<button type="button" class="btn btn-warning" id="fetchDraftBtn">\'
    //             + \'<i class="fa fa-download"></i> Fetch Draft\'
    //             + \'</button>\'
    //             + \'</div>\'
    //             + \'</div>\'
    //         );
    //     });
    //     </script>
    // ');

    $form->html('
    <script>
    $(document).ready(function() {
        $(".box-footer").find(".col-md-2").append(
            \'<div id="requisitionDraftBtnWrap" style="display:flex; gap:8px; margin-top:8px;">\'
            + \'<button type="button" class="btn btn-info" id="saveDraftBtn">\'
            + \'<i class="fa fa-save"></i> Save Draft\'
            + \'</button>\'
            + \'<button type="button" class="btn btn-warning" id="fetchDraftBtn">\'
            + \'<i class="fa fa-download"></i> Fetch Draft\'
            + \'</button>\'
            + \'</div>\'
        );
    });
    </script>
');

    
    // ─── EDIT MODE: pre-populate cascading dropdowns ──────────────────────────
    if ($form->isEditing()) {
        $model = Requisition::find(request()->route('requisition'));

        if ($user->isRole('admin')) {
            $programId = $model->program_id;
            $outcomeId = $model->outcome_id;

            Admin::script("
                $(document).ready(function () {
                    var program_id = '{$programId}';
                    var outcome_id = '{$outcomeId}';

                    $.get('/admin-activities/' + program_id, function (data) {
                        $('#adminactivity_id').empty().append('<option value=\"\">Select Activity</option>');
                        $.each(data, function (key, value) {
                            var selected = (key == outcome_id) ? 'selected' : '';
                            $('#adminactivity_id').append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                        });

                        $.get('/adminprogram-budgetlines/' + outcome_id, function (data) {
                            globalAdminBudgetLines = data;
                            $('[id^=admin_budget_line_id]').each(function () {
                                var \$sel = $(this);
                                var currentVal = \$sel.val();
                                \$sel.empty().append('<option value=\"\">Select Budget Line</option>');
                                $.each(globalAdminBudgetLines, function (key, value) {
                                    var selected = (key == currentVal) ? 'selected' : '';
                                    \$sel.append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                                });
                            });
                        });
                    });
                });
            ");
        } else {
            $programId  = $model->program_id;
            $outcomeId  = $model->outcome_id;
            $outputId   = $model->output_id;
            $activityId = $model->activity_id;

            Admin::script("
                $(document).ready(function () {
                    var program_id  = '{$programId}';
                    var outcome_id  = '{$outcomeId}';
                    var output_id   = '{$outputId}';
                    var activity_id = '{$activityId}';

                    $.get('/program-outcomes/' + program_id, function (data) {
                        $('#outcome_id').empty().append('<option value=\"\">Select Outcome</option>');
                        $.each(data, function (key, value) {
                            var selected = (key == outcome_id) ? 'selected' : '';
                            $('#outcome_id').append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                        });

                        $.get('/outcome-outputs/' + outcome_id, function (data) {
                            $('#output_id').empty().append('<option value=\"\">Select Output</option>');
                            $.each(data, function (key, value) {
                                var selected = (key == output_id) ? 'selected' : '';
                                $('#output_id').append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                            });

                            $.get('/output-activities/' + output_id, function (data) {
                                $('#activity_id').empty().append('<option value=\"\">Select Activity</option>');
                                $.each(data, function (key, value) {
                                    var selected = (key == activity_id) ? 'selected' : '';
                                    $('#activity_id').append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                                });

                                $.get('/budgetlines/' + activity_id, function (data) {
                                    globalBudgetLines = data[0];
                                    $('#activity_budget').val(Number(data[1]).toLocaleString('en-US'));
                                    $('#remaining_budget').val(Number(data[2]).toLocaleString('en-US'));

                                    if (data[3]) {
                                        $('#existingConceptNoteWrapper').html(
                                            '<div class=\"mb-3\"><label>Existing Concept Note:</label>' +
                                            '<a href=\"' + data[3] + '\" target=\"_blank\" class=\"btn btn-link\">View Concept Note</a></div>'
                                        );
                                    }

                                    $('[id^=budget_line_id]').each(function () {
                                        var \$sel     = $(this);
                                        var savedVal = \$sel.val();
                                        \$sel.empty().append('<option value=\"\">Select Budget Line</option>');
                                        $.each(globalBudgetLines, function (key, value) {
                                            var selected = (key == savedVal) ? 'selected' : '';
                                            \$sel.append('<option value=\"' + key + '\" ' + selected + '>' + value + '</option>');
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            ");
        }
    }
    // ─────────────────────────────────────────────────────────────────────────


    Admin::script('
        $(document).ajaxError(function(event, xhr, settings, error) {
            console.error("AJAX Error:", {
                status: xhr.status,
                response: xhr.responseText,
                error: error
            });
        });
    ');

    Admin::script('
        let globalBudgetLines = {};

        // ─── DRAFT FUNCTIONALITY ────────────────────────────────────────────────
        var DRAFT_KEY = "requisition_draft_" + (window.location.pathname);

        function collectFormData() {
            var draft = {
                code:        $("input[name=\'code\']").val(),
                program_id:  $("#program_id").val() || $("#adminprogram_id").val(),
                outcome_id:  $("#outcome_id").val() || $("#adminactivity_id").val(),
                output_id:   $("#output_id").val(),
                activity_id: $("#activity_id").val(),
                description: $("textarea[name=\'description\']").val(),
                amount:      $("input[name=\'amount\']").val(),
                items: []
            };

            $(".has-many-requisition_items-form").each(function () {
                var removedInput = $(this).find("input[name*=\'[_remove_]\']");
                if (removedInput.length && removedInput.val() === "1") return;

                var item = {
                    budget_line_id:      $(this).find("select[name*=\'budget_line_id\']").val(),
                    admin_budget_line_id: $(this).find("select[name*=\'admin_budget_line_id\']").val(),
                    quantity:            $(this).find("input[name*=\'quantity\']").val(),
                    frequency:           $(this).find("input[name*=\'frequency\']").val(),
                    unit_price:          $(this).find("input[name*=\'unit_price\']").val(),
                    unit_of_measure:     $(this).find("input[name*=\'unit_of_measure\']").val(),
                    total_price:         $(this).find("input[name*=\'total_price\']").val(),
                };
                draft.items.push(item);
            });

            return draft;
        }

        function saveDraft() {
            var draft = collectFormData();
            localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
            
            // Show a subtle save indicator
            var indicator = $("#draftSaveIndicator");
            if (!indicator.length) {
                $("body").append("<div id=\'draftSaveIndicator\' style=\'position:fixed;bottom:20px;right:20px;background:#333;color:#fff;padding:8px 16px;border-radius:4px;z-index:9999;font-size:13px;\'>Draft saved</div>");
                indicator = $("#draftSaveIndicator");
            }
            indicator.fadeIn(200).delay(1500).fadeOut(600);
        }

        function clearDraft() {
            localStorage.removeItem(DRAFT_KEY);
        }

        function hasDraft() {
            return localStorage.getItem(DRAFT_KEY) !== null;
        }

        function restoreDraft() {
            var raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) return;

            var draft = JSON.parse(raw);

            // Restore simple fields immediately
            if (draft.description) $("textarea[name=\'description\']").val(draft.description);

            // Restore program then chain the selects
            var programSelect = $("#program_id").length ? $("#program_id") : $("#adminprogram_id");
            var isAdmin       = $("#adminprogram_id").length > 0;

            if (draft.program_id) {
                programSelect.val(draft.program_id).trigger("change");

                if (isAdmin) {
                    // Admin chain: program -> activity (outcome) -> budget lines
                    setTimeout(function () {
                        $.get("/admin-activities/" + draft.program_id, function (data) {
                            $("#adminactivity_id").empty().append(\'<option value="">Select Activity</option>\');
                            $.each(data, function (key, value) {
                                $("#adminactivity_id").append(new Option(value, key));
                            });

                            if (draft.outcome_id) {
                                $("#adminactivity_id").val(draft.outcome_id).trigger("change");

                                setTimeout(function () {
                                    $.get("/adminprogram-budgetlines/" + draft.outcome_id, function (data) {
                                        globalAdminBudgetLines = data;
                                        restoreItems(draft.items, true);
                                    });
                                }, 400);
                            }
                        });
                    }, 400);

                } else {
                    // Regular chain: program -> outcome -> output -> activity -> budget lines
                    setTimeout(function () {
                        $.get("/program-outcomes/" + draft.program_id, function (data) {
                            $("#outcome_id").empty().append(\'<option value="">Select Outcome</option>\');
                            $.each(data, function (key, value) {
                                $("#outcome_id").append(new Option(value, key));
                            });

                            if (draft.outcome_id) {
                                $("#outcome_id").val(draft.outcome_id);

                                $.get("/outcome-outputs/" + draft.outcome_id, function (data) {
                                    $("#output_id").empty().append(\'<option value="">Select Output</option>\');
                                    $.each(data, function (key, value) {
                                        $("#output_id").append(new Option(value, key));
                                    });

                                    if (draft.output_id) {
                                        $("#output_id").val(draft.output_id);

                                        $.get("/output-activities/" + draft.output_id, function (data) {
                                            $("#activity_id").empty().append(\'<option value="">Select Activity</option>\');
                                            $.each(data, function (key, value) {
                                                $("#activity_id").append(new Option(value, key));
                                            });

                                            if (draft.activity_id) {
                                                $("#activity_id").val(draft.activity_id);

                                                $.get("/budgetlines/" + draft.activity_id, function (data) {
                                                    globalBudgetLines = data[0];
                                                    $("#activity_budget").val(Number(data[1]).toLocaleString("en-US"));
                                                    $("#remaining_budget").val(Number(data[2]).toLocaleString("en-US"));
                                                    restoreItems(draft.items, false);
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }, 400);
                }
            }
        }

        function restoreItems(items, isAdmin) {
            if (!items || items.length === 0) return;

            // Remove any existing blank rows first
            $(".has-many-requisition_items-form .remove").click();

            items.forEach(function (item, index) {
                // Click the "Add" button to create a new row
                var addBtn = $(".has-many-requisition_items .add");
                addBtn.click();

                setTimeout(function () {
                    var forms  = $(".has-many-requisition_items-form");
                    var formEl = forms.eq(index);

                    if (isAdmin) {
                        var $sel = formEl.find("select[name*=`admin_budget_line_id`]");
                        $sel.empty().append(\'<option value="">Select Budget Line</option>\');
                        $.each(globalAdminBudgetLines, function (key, value) {
                            $sel.append(new Option(value, key));
                        });
                        $sel.val(item.admin_budget_line_id);
                    } else {
                        var $sel = formEl.find("select[name*=\'budget_line_id\']");
                        $sel.empty().append(\'<option value="">Select Budget Line</option>\');
                        $.each(globalBudgetLines, function (key, value) {
                            $sel.append(new Option(value, key));
                        });
                        $sel.val(item.budget_line_id);
                    }

                    formEl.find("input[name*=\'quantity\']").val(item.quantity).trigger("input");
                    formEl.find("input[name*=\'frequency\']").val(item.frequency).trigger("input");
                    formEl.find("input[name*=\'unit_price\']").val(item.unit_price).trigger("input");
                    formEl.find("input[name*=\'unit_of_measure\']").val(item.unit_of_measure);
                    formEl.find("input[name*=\'total_price\']").val(item.total_price);

                }, 300 * (index + 1)); // stagger to allow DOM to render each row
            });
        }

        // Clear draft when form is successfully submitted
        $("form").on("submit", function () {
            clearDraft();
        });

        $(document).ready(function () {
            $("#saveDraftBtn").off("click").on("click", function (e) {
                e.preventDefault();
                saveDraft();
                if (typeof toastr !== "undefined") {
                    toastr.success("Draft saved successfully.", "Success");
                }
            });

            $("#fetchDraftBtn").off("click").on("click", function (e) {
                e.preventDefault();
                if (!hasDraft()) {
                    if (typeof toastr !== "undefined") {
                        toastr.warning("No saved draft found.", "Info");
                    } else {
                        alert("No saved draft found.");
                    }
                    return;
                }

                var restore = confirm("Load saved draft? This will replace current form values.");
                if (restore) {
                    restoreDraft();
                    if (typeof toastr !== "undefined") {
                        toastr.success("Draft loaded successfully.", "Success");
                    }
                }
            });
        });
        // ────────────────────────────────────────────────────────────────────────


        $("#program_id").change(function(){
            var program_id = $(this).val();
            $.get("/program-outcomes/"+program_id, function(data){
                $("#outcome_id").empty();
                $("#no-activities-message").remove();
                
                if($.isEmptyObject(data)) {
                    $("#outcome_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No outcomes available for this program</span>");
                } else {
                    $("#outcome_id").append(new Option(\'Select Activity \', \'\'));
                    $.each(data, function(key, value){
                        $("#outcome_id").append("<option value="+key+">"+value+"</option>");
                    });
                }
            });
        });

        $("#outcome_id").change(function(){
            var outcome_id = $(this).val();
            $.get("/outcome-outputs/"+outcome_id, function(data){
                $("#output_id").empty();
                $("#no-activities-message").remove();
                
                if($.isEmptyObject(data)) {
                    $("#output_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No outputs available for this outcome</span>");
                } else {
                    $("#output_id").append(new Option(\'Select Activity \', \'\'));
                    $.each(data, function(key, value){
                        $("#output_id").append("<option value="+key+">"+value+"</option>");
                    });
                }
            });
        });

        $("#output_id").change(function(){
            var output_id = $(this).val();
            $.get("/output-activities/"+output_id, function(data){
                $("#activity_id").empty();
                $("#no-activities-message").remove();
                
                if($.isEmptyObject(data)) {
                    $("#activity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this output</span>");
                } else {
                    $("#activity_id").append(new Option(\'Select Activity \', \'\'));
                    $.each(data, function(key, value){
                        $("#activity_id").append("<option value="+key+">"+value+"</option>");
                    });
                }
            });
        });

        $("#activity_id").change(function () {
            var activity_id = $(this).val();
            if (!activity_id) {
                alert("Please select an activity");
                return;
            }

            $.get("/budgetlines/" + activity_id)
                .done(function (data) {
                    globalBudgetLines = data[0];
                    var activity_budget  = Number(data[1]).toLocaleString(`en-US`);
                    var remaining_budget = Number(data[2]).toLocaleString(`en-US`);

                    $("#activity_budget").val(activity_budget);
                    $("#remaining_budget").val(remaining_budget);

                    if ($.isEmptyObject(globalBudgetLines)) {
                        alert("No budget lines available for the selected activity");
                        return;
                    }

                    $("[id^=budget_line_id]").each(function () {
                        let $select = $(this);
                        $select.empty().append(`<option value="">Select Budget Line</option>`);
                        $.each(globalBudgetLines, function (key, value) {
                            $select.append(new Option(value, key));
                        });
                    });

                    var conceptNoteField = $(\'[name="concept_note"]\').closest(\'.form-group\');
                    if (data[3]) {
                        $("#existingConceptNoteWrapper").html(`
                            <div class="mb-3">
                                <label>Existing Concept Note:</label>
                                <a href="${data[3]}" target="_blank" class="btn btn-link">View Concept Note</a>
                            </div>
                        `);
                    } else {
                        $("#existingConceptNoteWrapper").empty();
                        conceptNoteField.show();
                        $(`input[name=\'setOff_date\'][value=\'2\']`).prop(`checked`, true);
                    }
                });
        });


        const targetNode = document.querySelector("#has-many-requisition_items .has-many-requisition_items-forms");

        function sanitize(val) {
            return parseFloat((val || ``).toString().replace(/,/g, ``).trim()) || 0;
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            const forms = document.querySelectorAll(".has-many-requisition_items-form");

            forms.forEach(function (form) {
                const removedInput = form.querySelector("input[name*=\'[_remove_]\']");
                if (removedInput && removedInput.value === "1") return;

                const totalInput = form.querySelector("input[name*=\'[total_price]\']");
                if (totalInput) {
                    let value = totalInput.getAttribute("data-raw") || totalInput.value;
                    grandTotal += sanitize(value);
                }
            });

            const amountField = document.querySelector("input[name=\'amount\']");
            if (amountField) {
                amountField.value = grandTotal.toLocaleString(\'en-UG\');
                amountField.setAttribute("data-raw", grandTotal);
            }

            return grandTotal;
        }

        function setupRecalculation(formNode) {
            const unitPriceInput  = formNode.querySelector("input[name*=\'unit_price\']");
            const quantityInput   = formNode.querySelector("input[name*=\'quantity\']");
            const frequencyInput  = formNode.querySelector("input[name*=\'frequency\']");
            const totalPriceInput = formNode.querySelector("input[name*=\'total_price\']");

            function recalculateTotal() {
                if (!unitPriceInput || !quantityInput || !frequencyInput || !totalPriceInput) {
                    console.warn("Missing input elements for calculation");
                    return;
                }
                const unit  = sanitize(unitPriceInput.value);
                const qty   = sanitize(quantityInput.value);
                const freq  = sanitize(frequencyInput.value);
                const total = unit * qty * freq;

                totalPriceInput.value = total.toLocaleString(\'en-UG\');
                totalPriceInput.setAttribute("data-raw", total);
                calculateGrandTotal();
            }

            function handleInputChange(inputElement) {
                inputElement.value = inputElement.value.replace(/[^\\d.]/g, ``);
                recalculateTotal();
            }

            if (unitPriceInput) {
                $(unitPriceInput).on(`input change keyup blur paste`, function() { handleInputChange(this); });
            }
            if (quantityInput) {
                $(quantityInput).on(`input change keyup blur paste`, function() { handleInputChange(this); });
            }
            if (frequencyInput) {
                $(frequencyInput).on(`input change keyup blur paste`, function() { handleInputChange(this); });
            }
        }

        $(document).ready(function() {
            $(".has-many-requisition_items-form").each(function() {
                setupRecalculation(this);
            });
            calculateGrandTotal();
        });

        const requisitionObserver = new MutationObserver(function (mutationsList) {
            mutationsList.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === Node.ELEMENT_NODE && $(node).hasClass("has-many-requisition_items-form")) {
                        let $select = $(node).find("select[name*=\'budget_line_id\']");
                        if ($select.length) {
                            $select.empty().append(`<option value="">Select Budget Line</option>`);
                            $.each(globalBudgetLines, function (key, value) {
                                $select.append(new Option(value, key));
                            });
                        }
                        setupRecalculation(node);
                    }
                });
            });
        });

        function observeLogicalRemovals() {
            let previousCount = 0;
            setInterval(function () {
                const removedInputs = document.querySelectorAll("input[name*=\'[_remove_]\'][value=\'1\']");
                const currentCount  = removedInputs.length;
                if (currentCount !== previousCount) {
                    previousCount = currentCount;
                    calculateGrandTotal();
                }
            }, 300);
        }

        if (targetNode) {
            requisitionObserver.observe(targetNode, { childList: true, subtree: true });
            observeLogicalRemovals();
        } else {
            console.warn("Target node #has-many-requisition_items not found.");
        }
    ');

    Admin::script('
        let globalAdminBudgetLines = {};

        $("#adminprogram_id").change(function(){
            var program_id = $(this).val();
            $.get("/admin-activities/"+program_id, function(data){
                $("#adminactivity_id").empty();
                $("#no-activities-message").remove();
                
                if($.isEmptyObject(data)) {
                    $("#adminactivity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No budgetlines available for this activity</span>");
                } else {
                    $("#adminactivity_id").append(new Option(\'Select Activity \', \'\'));
                    $.each(data, function(key, value){
                        $("#adminactivity_id").append("<option value="+key+">"+value+"</option>");
                    });
                }
            });
        });

        $("#adminactivity_id").change(function () {
            var activity_id = $(this).val();
            if (!activity_id) {
                alert("Please select an outcome");
                return;
            }

            $.get("/adminprogram-budgetlines/" + activity_id)
                .done(function (data) {
                    globalAdminBudgetLines = data;

                    if ($.isEmptyObject(globalAdminBudgetLines)) {
                        alert("No outputs available for the selected outcome");
                        return;
                    }

                    $("[id^=admin_budget_line_id]").each(function () {
                        let $select = $(this);
                        $select.empty().append(\'<option value="">Select Budget Line</option>\');
                        $.each(globalAdminBudgetLines, function (key, value) {
                            $select.append(new Option(value, key));
                        });
                    });
                });
        });

        const adminobserver = new MutationObserver(function (mutationsList) {
            mutationsList.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if ($(node).hasClass("has-many-requisition_items-form")) {
                        let $select = $(node).find("[id^=admin_budget_line_id]");
                        $select.empty().append(\'<option value="">Select Budget Line</option>\');
                        $.each(globalAdminBudgetLines, function (key, value) {
                            $select.append(new Option(value, key));
                        });
                    }
                });
            });
        });

        if (targetNode) {
            adminobserver.observe(targetNode, { childList: true });
        }
    ');

    return $form;
}

    // function to fetch budget lines under a chosen activity
    public function getActivitiesbudgetlines($id)
    {
        $activityConcept = Requisition::where('activity_id', $id)->first();// gets a single column directly

        Log::info($activityConcept);

        $activity_budget = Activity::where('id', $id)->value('budget');
        
        $budgetlines = BudgetLines::where('activity_id', $id)->pluck('name', 'id'); // Returns {id: name}
        
        // Sum of accountabilities for all requisitions under this activity
        $usedAmount = Accountability::whereHas('requisition', function ($query) use ($id) {
            $query->where('activity_id', $id);
        })->sum('amount_used');

        
        $remaining = $activity_budget - $usedAmount;

        return [$budgetlines, $activity_budget, $remaining, $activityConcept?->concept_note 
            ? asset('storage/' . $activityConcept->concept_note) 
            : null,];
    }

    // function to fetch activities under a program
    public function getAdminActivities($id)
    {

        // $program = AdminProgram::find($id);
        $activities = AdminActivity::where('admin_program_id', $id) // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities


        return $activities;
    }


    // function to fetch budget lines under a chosen activity
    public function getAdminbudgetlines($id)
    {
        // $program = AdminProgram::find($id);
        $budgetlines = AdminBudget_lines::where('admin_activity_id', $id) // Get all outcomes for the program
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $budgetlines;
    }
    
}
