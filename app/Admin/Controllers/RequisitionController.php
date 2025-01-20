<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\AdminActivity;
use App\Models\AdminBudget_lines;
use App\Models\AdminProgram;
use App\Models\BudgetLines;
use App\Models\Comments;
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
    protected function grid()
    {
        
        $grid = new Grid(new Requisition());
        $grid->disableBatchActions();

        $user = auth()->user();
        // disable create button for finance and CD
        if ($user->inRoles(['finance', 'director'])){
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
        }
        
            $grid->actions(function ($actions) {
                if ($actions->row->status == 'approved') {
                    $actions->disableEdit();
                }
            });
        

        // order by latest requisition
        $grid->model()->orderBy('created_at', 'desc');

        //show staff only requisitions made by them if they are not admin
        if ($user->inRoles(['staff', 'admin'])) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
        }
        
        // show the CD only accepted requisitions
        if ($user->inRoles(['director'])) {
            $grid->model()->where('status', 'accepted');
        }

         //filter by program and activity
         $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            $filter->equal('program_id', 'Program')->select(Program::all()->pluck('name', 'id'));
            $filter->equal('activity_id', 'Activity')->select(Activity::all()->pluck('name', 'id'));
            //status filter
            $filter->equal('status', 'Status')->select([
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'accepted' => 'Accepted',
                'amended' => 'Amended'
            ]);
        });
       
        $grid->column('code', __('Code'));
        $grid->column('staff_id', __('Requested by'))->display(function($staff_id){
            return Staff::find($staff_id)->name;
        });
        $grid->column('program_id', 'Program')->display(function($program_id){
            return Program::find($program_id)->name;
        });
        $grid->column('amount', __('Amount'));
        $grid->column('status', __('Status'))->display(
            function ($status) {
                if ($status == 'pending') {
                    return "<span class='label label-warning'>pending</span>";
                } elseif ($status == 'approved') {
                    return "<span class='label label-success'>approved</span>";
                } elseif ($status == 'rejected') {
                    return "<span class='label label-danger'>rejected</span>";
                } elseif ($status == 'amended') {
                    return "<span class='label label-info'>amended</span>";
                }elseif ($status == 'accepted') {
                    return "<span class='label label-primary'>accepted</span>";
                }
            }
        );
        $grid->column('id', __('Inspection Report'))->display(function ($id)
        {
            $requisition = Requisition::find($id);
        
            if ($requisition && $requisition->status == 'approved') {
                $token = csrf_token();
                $downloadLink = admin_url('/requisitions/download/'. $id);
                return "<b><a href='{$downloadLink}' 
                          onclick='event.preventDefault(); 
                                  let form = document.createElement(\"form\"); 
                                  form.method = \"POST\";
                                  form.action = \"{$downloadLink}\";
                                  form.target = \"_blank\";
                                  let tokenInput = document.createElement(\"input\");
                                  tokenInput.type = \"hidden\";
                                  tokenInput.name = \"_token\";
                                  tokenInput.value = \"{$token}\";
                                  form.appendChild(tokenInput);
                                  document.body.appendChild(form);
                                  form.submit();
                                  document.body.removeChild(form);'>
                          Download Reports</a></b>";
            } else
            {          
                return '<b> No accountability</b>';
            }
        });
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
        $show = new Show(Requisition::findOrFail($id));
        $requisition = Requisition::findOrFail($id);

        return view('requisition_request', compact('requisition'));

    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Requisition());
        //get the logged in users's staff id
        $user = auth()->user();
        if ($form->isCreating()) {
            // Check if the user has any pending accountabilities
            $user = auth()->user();
            $staff_id = Staff::where('user_id', $user->id)->first()->id;

            $pendingRequisition = Requisition::where('staff_id', $staff_id)
                ->where('status', 'approved')
                ->whereDoesntHave('accountability') // Check if there's no accountability
                ->first();

            if ($pendingRequisition) {
                // Prevent new requisition creation
                $error = new MessageBag([
                    'title'   => 'Warning',
                    'message' => 'You cannot create a new requisition until you submit accountability for your  requisition '.$pendingRequisition->code,
                ]);

                return back()->with(compact('error'));
            }
        };
        
        $staff_id = Staff::where('user_id', $user->id)->first()->id;
        
            //when saving the form, calculate the total amount of the requisition items and save it in the amount field
            $form->saving(function (Form $form) {
                \Log::info('Saving form requisition_items:', $form->requisition_items);
                $requisition_items = request()->input('requisition_items');
                // dd($requisition_items);
        
                // Check that the requisition items are not empty
                if (empty($form->requisition_items)) {
                    admin_toastr('Please add requisition items', 'error');
                    return back()->withInput();
                }
            
                $total_amount = 0;
                $budget_lines = [];
                $duplicateCategoryFound = false;
                
                $user = auth()->user();

                if($user->isRole('admin')){
                    foreach ($requisition_items as $item) {
                        // dd($requisition_items);
                        // Check if the category_id is already in the $categories array
                        if (in_array($item['admin_budget_line_id'], $budget_lines)) {
                            $duplicateCategoryFound = true;
                            break; // Exit the loop early if a duplicate is found
                        }
                        
                        // Add the category_id to the $categories array
                        $budget_lines[] = $item['admin_budget_line_id'];

                        // Calculate the total amount of the requisition
                        $total_amount += $item['quantity'] * $item['unit_price']; // Fixed unit_price to unit_cost to match the form field
                    }
                
                    // If a duplicate category was found, show an error message and return back with input
                    if ($duplicateCategoryFound) {
                        admin_toastr('You have selected the same budget line twice', 'error');
                        return back()->withInput();
                    }
                }
                else{
                    foreach ($requisition_items as $item) {
                        // Check if the category_id is already in the $categories array
                        if (in_array($item['budget_line_id'], $budget_lines)) {
                            $duplicateCategoryFound = true;
                            break; // Exit the loop early if a duplicate is found
                        }
                        
                        // Add the category_id to the $categories array
                        $budget_lines[] = $item['budget_line_id'];
                        
                        // Calculate the total amount of the requisition
                        $total_amount += $item['quantity'] * $item['unit_price']; // Fixed unit_price to unit_cost to match the form field
                    }
                
                    // If a duplicate category was found, show an error message and return back with input
                    if ($duplicateCategoryFound) {
                        admin_toastr('You have selected the same budget line twice', 'error');
                        return back()->withInput();
                    }
                }
            
                // Set the total amount after validation
                $form->amount = $total_amount;
            
            });
        

            //when the form is saved , redirect to the show view with a success message that has the total amount of the requisition
            $form->saved(function (Form $form) {
                //get the total amount of the requisition
                $total_amount = $form->amount;
                $id = $form->model()->id;
                admin_toastr('Requistion worth '. $total_amount. ' has been successfully submitted');
                return redirect('/requisitions/'.$id);
            
            });
            
            $form->hidden('staff_id', __('Staff'))->default( $staff_id );
        
            if($user->isRole('admin')){
                $form->text('code', __('RequisitionID'))->default('Admin-'.rand(1000, 9999))->readonly();
                // dd($user->id);
                $form->select('admin_program_id', __('Program'))->options(AdminProgram::where('user_id', $staff_id)->pluck('name', 'id'))->attribute('id', 'adminprogram_id')->required();
                $form->select('activity', __('Activity'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = AdminActivity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'adminactivity_id')->required();
            
                $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                    $form->select('admin_budget_line_id', __('Budget Line'))
                    ->options(function ($id) {
                        // Preload the selected budget line for editing
                        $adminbudgetLine = AdminBudget_lines::find($id);
                        return $adminbudgetLine ? [$adminbudgetLine->id => $adminbudgetLine->name] : [];
                    })
                    ->attribute('id', 'admin_budget_line_id')
                    ->required();
                    $form->decimal('quantity', __('Quantity'))->required();
                    $form->text('unit_of_measure', __('Unit of measure'))->required();
                    $form->decimal('unit_price', __('Unit cost'))->required();
                
                });
            }else{
                $form->text('code', __('RequisitionID'))->default('REQ-'.rand(1000, 9999))->readonly();
                $form->select('program_id', __('Program'))->options(Program::where('user_id', $staff_id)->pluck('name', 'id'))->attribute('id', 'program_id')->required();
            
                $form->select('activity_id', __('Activity'))->options(function ($id) {
                    // Preload the selected activity for editing
                    $activity = Activity::find($id);
                    return $activity ? [$activity->id => $activity->name] : [];
                    })->attribute('id', 'activity_id')->required();
        
        
                    //add requisition items
                    $form->hasMany('requisition_items', 'Requisition items', function (Form\NestedForm $form) {
                        $form->select('budget_line_id', __('Budget Line'))
                        ->options(function ($id) {
                            // Preload the selected budget line for editing
                            $budgetLine = BudgetLines::find($id);
                            return $budgetLine ? [$budgetLine->id => $budgetLine->name] : [];
                        })
                        ->attribute('id', 'budget_line_id')
                        ->required()
                        ->readOnly();
                        $form->decimal('quantity', __('Quantity'))->required();
                        $form->text('unit_of_measure', __('Unit of measure'))->required();
                        $form->decimal('unit_price', __('Unit cost'))->required();
                    
                    });
            }
            $form->file('concept_note', __('Concept note'))->required();
            $form->textarea('description', __('Description'));
            $form->hidden('amount', __('Amount'));
            
        Admin::script
        ('
            $("form").on("submit", function(e) {
                console.log("Form submitted", $(this).serialize());
            });
            
            $(document).ajaxError(function(event, xhr, settings, error) {
                console.error("AJAX Error:", {
                    status: xhr.status,
                    response: xhr.responseText,
                    error: error
                });
            });
        ');

        //script to show activity based on program selected
        Admin::script('
            $("#program_id").change(function(){
                var program_id = $(this).val();
                $.get("/program-activities/"+program_id, function(data){
                    $("#activity_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#activity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
                    } else {
                        // Add a default option
                        $("#activity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#activity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
           
            $("#activity_id").change(function() {
                var activity_id = $(this).val();
                if (!activity_id) {
                    alert("Please select an activity");
                    return;
                }

                 $.get("/budgetlines/" + activity_id)
                    .done(function(data) {
                    if ($.isEmptyObject(data)) {
                        alert("No budget lines available for the selected activity");
                        return;
                    }

                    // Clear existing requisition items
                    $("#has-many-requisition_items").find(".has-many-requisition_items-forms").empty();

                    // Dynamically add requisition items for each budget line
                    $.each(data, function(key, value) {
                        $(".add").click(); // Simulate clicking the "Add" button to add a new requisition item
                        
                        // Wait for the new form to be added, then populate its fields
                        setTimeout(function() {
                            var lastForm = $("#has-many-requisition_items").find(".has-many-requisition_items-forms").children().last();
                            var budgetLineField = $("[id^=budget_line_id]");
                            
                                budgetLineField.append(new Option(value, key, true, true)); // Add and select the option
                                budgetLineField.trigger("change"); // Trigger change for any dependencies
                            
                            // Optionally, set other default values here (e.g., quantity, unit_of_measure)
                        }, 100); // Add a small delay to ensure the form is rendered
                    });
                });
            });

        ');

        Admin::script('
            $("#adminprogram_id").change(function(){
                var program_id = $(this).val();
                $.get("/admin-activities/"+program_id, function(data){
                    $("#adminactivity_id").empty();
                    $("#no-activities-message").remove();
                    
                    if($.isEmptyObject(data)) {
                        $("#adminactivity_id").after("<span id=\'no-activities-message\' style=\'color: red;\'>No activities available for this program</span>");
                    } else {
                        // Add a default option
                        $("#adminactivity_id").append(new Option(\'Select Activity \', \'\'));
                                
                        $.each(data, function(key, value){
                            $("#adminactivity_id").append("<option value="+key+">"+value+"</option>");
                        });
                    }
                });
            });
           
            $("#adminactivity_id").change(function() {
                var activity_id = $(this).val();
                if (!activity_id) {
                    alert("Please select an activity");
                    return;
                }

                 $.get("/adminprogram-budgetlines/" + activity_id)
                    .done(function(data) {
                    if ($.isEmptyObject(data)) {
                        alert("No budget lines available for the selected activity");
                        return;
                    }

                    // Clear existing requisition items
                    $("#has-many-requisition_items").find(".has-many-requisition_items-forms").empty();

                    // Dynamically add requisition items for each budget line
                    $.each(data, function(key, value) {
                        $(".add").click(); // Simulate clicking the "Add" button to add a new requisition item
                        
                        // Wait for the new form to be added, then populate its fields
                        setTimeout(function() {
                            var lastForm = $("#has-many-requisition_items").find(".has-many-requisition_items-forms").children().last();
                            var budgetLineField = $("[id^=admin_budget_line_id]");
                            
                                budgetLineField.append(new Option(value, key, true, true)); // Add and select the option
                                budgetLineField.trigger("change"); // Trigger change for any dependencies
                            
                            // Optionally, set other default values here (e.g., quantity, unit_of_measure)
                        }, 100); // Add a small delay to ensure the form is rendered
                    });
                });
            });
            
        ');
        
        return $form;
    }

    // function to fetch activities under a program
    public function getProgramActivities($id)
    {
        // $user = auth()->user()->id;
        // dd($user);

        $program = Program::find($id);
        $activities = $program->outcomes // Get all outcomes for the program
            ->flatMap(function ($outcome) {
                return $outcome->outputs; // Get all outputs for each outcome
            })
            ->flatMap(function ($output) {
                return $output->activities; // Get all activities for each output
            })
            ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities

        return $activities;
    }

    // function to fetch budget lines under a chosen activity
    public function getActivitiesbudgetlines($id)
    {
        // $activities = Activity::find($id);
        // $budgetlines = $activities->budget_lines // Get all outcomes for the program
        //     ->pluck('name', 'id'); // Extract 'name' and 'id' from the activities
        $budgetlines = BudgetLines::where('activity_id', $id)->pluck('name', 'id'); // Returns {id: name}
        

        return $budgetlines;
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

    public function downloadDocuments($id)
    {
        // $route = Route::current(); 
        // dd($route->middleware());
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
        $requisition = Requisition::with('requisition_items.requisitionItemReceipts')->findOrFail($id);
        
        // Create a temporary directory
        $tempDir = storage_path('app/temp/' . uniqid());
        mkdir($tempDir, 0755, true);
        $zipPath = null;
        
        try {
            // dd(auth()->check()); 
            // Generate and save requisition form PDF
            $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition]);
            $requisitionPath = $tempDir . '/requisition_form.pdf';
            $requisitionPdf->save($requisitionPath);
            
            // Generate and save accountability form PDF
            $accountabilityPdf = PDF::loadView('pdfs.accountability-form', ['requisition' => $requisition]);
            $accountabilityPath = $tempDir . '/accountability_form.pdf';
            $accountabilityPdf->save($accountabilityPath);
            
            $code= $requisition->code;
            // Create ZIP archive
            $zipFileName = 'requisition_' . $code . '_documents.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);
            
            $zip = new ZipArchive();
            $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            
            // Add requisition form to ZIP
            $zip->addFile($requisitionPath, 'requisition_form.pdf');
            
            // Add accountability form to ZIP
            $zip->addFile($accountabilityPath, 'accountability_form.pdf');
            
            Log::info('path:',$zipPath );
            
            // Add all attached receipts to ZIP
            foreach ($requisition->requisition_items->requisitionItemReceipts as $receipt) {
                // $receiptPath = asset('storage/files/'.$receipt->receipt_file);
                $receiptPath = public_path('files/' . $receipt->receipt_file);

                Log::info('path:',$receiptPath );

                if (file_exists($receiptPath)) {
                    $zip->addFile($receiptPath, 'receipts/' . basename($receipt->receipt_file));
                }
            }
            
            // $zip->close();
            
            // Download ZIP file
            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ];
            
            // Clean up temporary files after sending the response
            $response = response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);
            
            // Clean up the temp directory
            File::deleteDirectory($tempDir);
            
            return $response;
            
        } catch (\Exception $e) {
            // Clean up on error
            File::deleteDirectory($tempDir);
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            
            throw $e;
        }
    }

//     public function downloadDocuments($id)
// {
//     if (!auth()->check()) {
//         abort(403, 'Unauthorized');
//     }

//     $requisition = Requisition::with('requisition_items.requisitionItemReceipts')->findOrFail($id);

//     // Create a temporary directory
//     $tempDir = storage_path('app/temp/' . uniqid());
//     if (!file_exists($tempDir)) {
//         mkdir($tempDir, 0755, true);
//     }

//     $zipPath = null;

//     try {
//         // Generate and save requisition form PDF
//         $requisitionPdf = PDF::loadView('requisition_request', ['requisition' => $requisition]);
//         $requisitionPath = $tempDir . '/requisition_form.pdf';
//         $requisitionPdf->save($requisitionPath);

//         // Generate and save accountability form PDF
//         $accountabilityPdf = PDF::loadView('pdfs.accountability-form', ['requisition' => $requisition]);
//         $accountabilityPath = $tempDir . '/accountability_form.pdf';
//         $accountabilityPdf->save($accountabilityPath);

//         $code = $requisition->code;
//         $zipFileName = 'requisition_' . $code . '_documents.zip';
//         $zipPath = storage_path('app/temp/' . $zipFileName);

//         $zip = new ZipArchive();
//         if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
//             throw new \Exception('Failed to create ZIP file');
//         }

//         // Add requisition form to ZIP
//         $zip->addFile($requisitionPath, 'requisition_form.pdf');

//         // Add accountability form to ZIP
//         $zip->addFile($accountabilityPath, 'accountability_form.pdf');

//         // Add all attached receipts to ZIP
//         foreach ($requisition->requisition_items as $item) {
//             foreach ($item->requisitionItemReceipts as $receipt) {
//                 $receiptPath = public_path('files/' . $receipt->receipt_file);
//                 Log::info('Checking receipt path:', ['path' => $receiptPath]);

//                 if (file_exists($receiptPath)) {
//                     $zip->addFile($receiptPath, 'receipts/' . basename($receipt->receipt_file));
//                 } else {
//                     Log::warning("File does not exist: $receiptPath");
//                 }
//             }
//         }

//         $zip->close();

//         // Download ZIP file
//         $headers = [
//             'Content-Type' => 'application/zip',
//             'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
//         ];

//         // Clean up temporary files after sending the response
//         $response = response()->download($zipPath, $zipFileName, $headers)->deleteFileAfterSend(true);

//         // Clean up the temp directory
//         File::deleteDirectory($tempDir);

//         return $response;

//     } catch (\Exception $e) {
//         // Log error
//         Log::error('Download error: ' . $e->getMessage());

//         // Clean up on error
//         File::deleteDirectory($tempDir);
//         if (file_exists($zipPath)) {
//             unlink($zipPath);
//         }

//         throw $e;
//     }
// }


    
}
