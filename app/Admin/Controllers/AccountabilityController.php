<?php

namespace App\Admin\Controllers;

use App\Models\Accountability;
use App\Models\BudgetLines;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\RequisitionItemReceipt;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AccountabilityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Accountability';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Accountability());
        $grid->disableBatchActions();

        $user = auth()->user();
        // Define role priorities - finance/director wins over admin
        $isAdminOnly = $user->inRoles(['admin']);
        $isFinanceOrDirector = $user->inRoles(['finance', 'director']) && !$isAdminOnly;
        $isStaffOnly = $user->inRoles(['staff']);

        if ($isStaffOnly) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
            
        }else{
            
            $grid->model()->whereNot('status', Null);
        }
        // disable create button for finance and CD
        if ($isFinanceOrDirector){
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableDelete();
            });
        }else{
            $grid->actions(function ($actions) {
                if($actions->row->status == 'closed'){
                    $actions->disableEdit();
                    $actions->disableDelete();
                }
                if($actions->row->status == 'halted' || $actions->row->status == 'pending' ){
                    $actions->disableDelete();
                }
                
            });
        }
        

        //filter by program and activity
        $grid->filter(function($filter){
            $filter->disableIdFilter();

            $filter->equal('requisition_id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            //status filter
            $filter->equal('status', 'Status')->select([
                'pending' => 'Pending',
                'closed' => 'Closed',
                'halted' => 'Halted'
            ]);
        });

      
        $grid->column('requisition_id', __('Requisition'))->display(function($requisition_id){
            return Requisition::find($requisition_id)->code;
        });
        
        $grid->column('', __('Amount dispensed'))->display(function(){
            $amount = Requisition::find($this->requisition_id)->amount;
            return  number_format($amount, 0, '.', ',');
        });
        $grid->column('amount_used', __('Amount used'))->display(function($amount){
            return  number_format($amount, 0, '.', ',');
        });;
        $grid->column('status', __('Status'))->display(
            function ($status) {
                if ($status == null) {
                    return "<span class='label label-info'>Not Submitted</span>";
                } elseif ($status == 'closed') {
                    return "<span class='label label-success'>closed</span>";
                } elseif ($status == 'halted') {
                    return "<span class='label label-danger'>halted</span>";
                } elseif ($status == 'pending') {
                    return "<span class='label label-warning'>pending</span>";
                } 
            }
        );
        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            //return human readable format
            return (Carbon::parse($created_at)->diffForHumans());
        });;
       

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

        $show = new Show(Accountability::findOrFail($id));
        $accountability = Accountability::findOrFail($id);

        //dd($accountability->receiptFiles);

        return view('accountability_report', compact('accountability'));
      
       
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Accountability());
    
        $user = Admin::user();
        $staff_id = Staff::where('user_id', $user->id)->first()->id;
    
        // if($form->isCreating()){ 
            
            $pendingRequisition = Requisition::where('staff_id', $staff_id)
                ->where('status', 'approved')
                ->whereDoesntHave('accountability') // Check if there's no accountability
                ->first();
            $accountability = request()->route('accountability'); // Check if editing
            $existingRequisition = null;
            
            if ($accountability) {
                $accountability = Accountability::find($accountability);
                $existingRequisition = $accountability->requisition_id ?? null;
            }

            if($form->isCreating()){
                $form->select('requisition_id', __('Requisition ID'))
                ->options(Requisition::where('staff_id', $staff_id)
                ->where('status', 'approved')
                ->whereDoesntHave('accountability')->pluck('code', 'id'))
                ->default($existingRequisition)
                ->attribute('id', 'requisitionId')
                ->required();

                $form->text('', __('Amount dispensed'))
                ->attribute('id', 'amount_dispensed')
                ->readonly();

                $form->hidden('staff_id')->default($staff_id);

                $form->hasMany('requisitionItemReceipts', 'Requisition items', function (Form\NestedForm $form)use ($existingRequisition)  {
                    $form->select('requisition_item_id', __('Requisition item'))
                    ->options([])
                    ->attribute('id', 'requisition_item_id')
                    ->required();
                    // ->attribute('disabled', 'disabled');;
                    
                    
                    $form->multipleFile('Invoice', __('Invoice'))
                    ->help('upload files of pdf,doc,png,jpg,jpeg formats ')
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    ->removable()
                    ->required();
    
                    // $form->file('payment_proof', __('Proof of Payment'))
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    // ->removable();
                    // $form->file('receipt_file', __('Receipt'))
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    // ->removable();
                    
                    $form->text('amount', 'Invoice Amount');
                });
                $form->decimal('amount_used', __('Total amount used(UGX)'))->readonly();
                $form->decimal('returned_amount', __('Amount returned to finance(UGX)'))
                    ->attribute('id', 'returned_amount')
                    ->readonly();

                $form->decimal('amount_to_be_returned', __('Amount returned to staff'))
                    ->attribute('id', 'amount_to_be_returned')
                    ->readonly();
                // Log::info('Received form data', $form()->all());
            

            }else{
                $form->display('requisition_id', __('Requisition ID'))
                ->with(function ($requisition_id) {
                    return Requisition::find($requisition_id)->code;
                });

                $form->text('', __('Amount dispensed(UGX)'))
                ->default(function() use ($form) {
                    $amount = $form->model()->requisition->amount;
                    
                    // return number_format($amount);
                    return $amount;
                })->readonly()
                ->attribute('id', 'amount_dispensed');

                Log::info('form->amount_dispensed');

                // $existingRequisition= $form->model()->requisition->id;
                $form->hasMany('requisitionItemReceipts', 'Requisition items', function (Form\NestedForm $form)use ($existingRequisition)  {
                        $requisition = Requisition::findOrfail($existingRequisition);
                        $user = auth()->user();
                        $staff_id = Staff::where('user_id', $user->id)->first()->id;

                        $form->display('requisition_item_id', __('Requisition item'))
                        ->with(function ($value) {
                            if ($value) {
                                $requisitionItem = RequisitionItem::find($value);
                                return $requisitionItem ? ($requisitionItem->adminbudgetline->name ?? $requisitionItem->budgetline->name) : 'N/As';
                            }
                
                            return 'N/A';
                        });
                        
                        if($user->isRole('admin')){
                           
                            $form->multipleFile('Invoice', __('Invoice'))
                            ->help('upload fies of jpg, jpeg, png formats ')
                            // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable()
                            ->readonly();
                            
                            $form->multipleFile('payment_proof', __('Proof of Payment'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
                            if($staff_id == $requisition->staff->id){
                                $form->multipleFile('receipt_file', __('Receipt'))
                                ->help('upload fies of jpg,jpeg,png formats ')
                                // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                                ->removable();
                            }

                            $form->text('amount', 'Invoice Amount')->required();
                            $form->text('transfer_charges', 'Transfer chargers')
                            ->help('Input the tranfer charge amount if any.');
                        }
                        else /*($staff_id == $requisition->staff->id)*/{
                            
                            $form->multipleFile('Invoice', __('Invoice'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
            
                            $form->multipleFile('payment_proof', __('Proof of Payment'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            // ->removable()
                            ->default('No proof of payment yet')
                            ->readonly();
                            
                            $form->multipleFile('receipt_file', __('Receipt'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
                            
                            $form->text('amount', 'Amount Spent');
                        }
                    
                })
                ->disableDelete()  // disables the "Remove" (trash icon) button
                ->disableCreate();

                $form->hidden('staff_id')->default($staff_id);
                
                $form->decimal('amount_used', __('Total amount used(UGX)'))->readonly()
                // ->default(function($returned_amount)use ($form) {
                //     $amount = $form->model()->amount_used;

                //     return number_format($amount);
                // })
                ->attribute(['id'=>'amount_used',
                    'name'=>'amount_used',
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                 ]);
                // }
                // Log::info(['$form=>amount', $form->amount_used]);
    
                $form->decimal('returned_amount', __('Amount returned to finance(UGX)'))
                    ->value(function($returned_amount) {
                        
                        return number_format($returned_amount);
                    })
                    ->attribute('id', 'returned_amount')
                    ->readonly();
            
                $form->decimal('amount_to_be_returned', __('Amount returned to staff'))
                    // ->default(function($amount_to_be_returned)use ($form) {
                    //     $amount = $form->model()->amount_to_be_returned;

                    //     return number_format($amount);
                    // })
                    ->attribute(['id'=>'amount_to_be_returned',
                        'name'=>'amount_to_be_returned',
                        'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                    ])
                    ->readonly();
            
                // File fields for proof of funds and narrative report

                // if($user->isRole('finance')) {
                    $form->file('proof_of_funds_to_be_returned', __('Receipt for funds returned to staff'));
                // }else{
                    $form->file('proof_of_funds_returned', __('Receipt for funds returned to finance'))
                    ->help('upload files of pdf,doc,png,jpg,jpeg formats ');
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120');
                    
                // }
                if($user->isRole('staff')) {
                    $form->file('narrative_report', __('Narrative Report'))
                    ->help('upload files of pdf,doc formats ')
                    ->rules('file|mimes:pdf|max:5120')
                    ->required();
                }
            }

            $form->multipleFile('attachments', __('Additional Accountabilities'))
                ->help('upload fies of jpg,jpeg,png formats ')
                // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                ->removable();
                
            $form->footer(function ($footer) {
                $footer->disableReset();
                $footer->disableViewCheck();
                $footer->disableEditingCheck();
                $footer->disableCreatingCheck();
            });

            // $form->html('
            //     <script>
            //     $(document).ready(function() {
            //         $(".box-footer").find(".col-md-2").append(
            //             \'<div id="accountabilityDraftBtnWrap" class="row" style="margin-top:8px; width:fit-content;">\'
            //             + \'<div class="col-md-2" style="padding-left:0; padding-right:100px;">\'
            //             + \'<button type="button" class="btn btn-info" id="saveAccountabilityDraftBtn">\'
            //             + \'<i class="fa fa-save"></i> Save Draft\'
            //             + \'</button>\'
            //             + \'</div>\'
            //             + \'<div class="col-md-2" style="padding-left:105px;">\'
            //             + \'<button type="button" class="btn btn-warning" id="fetchAccountabilityDraftBtn">\'
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
            \'<div id="accountabilityDraftBtnWrap" style="display:flex; gap:8px; margin-top:8px;">\'
            + \'<button type="button" class="btn btn-info" id="saveAccountabilityDraftBtn">\'
            + \'<i class="fa fa-save"></i> Save Draft\'
            + \'</button>\'
            + \'<button type="button" class="btn btn-warning" id="fetchAccountabilityDraftBtn">\'
            + \'<i class="fa fa-download"></i> Fetch Draft\'
            + \'</button>\'
            + \'</div>\'
        );
    });
    </script>
');
            

            $form->saving(function (Form $form) {
                Log::info('Form saving started', ['data' => request()->all()]);
                // Log::info('Received form data', $form()->all());

                $normalizeAmount = static function ($value) {
                    return (float) str_replace(',', '', (string) $value);
                };

                $form->amount_used = $normalizeAmount($form->amount_used);

                if ($form->requisition_id) {
                    $requisition = Requisition::find($form->requisition_id);
                    $amountDispensed = $requisition ? (float) $requisition->amount : 0;

                    $form->returned_amount = $amountDispensed > $form->amount_used
                        ? $amountDispensed - $form->amount_used
                        : 0;

                    $form->amount_to_be_returned = $form->amount_used > $amountDispensed
                        ? $form->amount_used - $amountDispensed
                        : 0;
                }
            
                $token = request()->input('_token');
            
                // Check if the token is already used
                if (Cache::has("form_token_{$token}")) {
                    Log::warning('Duplicate form submission detected', ['token' => $token]);
                    return back()->withErrors(['error' => 'Form already submitted']);
                }
            
                // Store token to prevent duplicates
                Cache::put("form_token_{$token}", true, now()->addMinutes(5));
            });

        // $form->saving(function (Form $form) {
        //     // Generate a unique token for this submission
        //     $token = request()->input('_token');

        //     // $form->model()->amount_used = str_replace(',', '', $form->amount_used); // Remove commas before saving
        //     // $form->model()->amount_to_be_returned = str_replace(',', '', $form->amount_to_be_returned); // Remove commas before saving
        //     // // $form->model()->amount_used = str_replace(',', '', $form->amount_used); // Remove commas before saving
            
        //     // Check if this token has been used
        //     if (Cache::has("form_token_{$token}")) {
        //         return response()->json(['error' => 'Form already submitted'], 422);
        //     }
            
        //     // Store token in cache briefly to prevent duplicate submissions
        //     Cache::put("form_token_{$token}", true, now()->addMinutes(5));
            
        //     Log::info('Form saving', [
        //         'model' => $form->model()->toArray(),
        //         'token' => $token
        //     ]);
        // });
        
        $form->saved(function (Form $form) {
            // Clear the token after successful save
            $token = request()->input('_token');
            Cache::forget("form_token_{$token}");
        });

        Admin::script('
        var amount = "";
        var DRAFT_KEY = "accountability_draft_" + window.location.pathname;

        function sanitizeMoney(value) {
            return parseFloat((value || "").toString().replace(/,/g, "").trim()) || 0;
        }

        function collectAccountabilityDraft() {
            var draft = {
                requisition_id: $("#requisitionId").val() || "",
                amount_dispensed: $("#amount_dispensed").val() || "",
                amount_used: $("#amount_used").val() || "",
                returned_amount: $("#returned_amount").val() || "",
                amount_to_be_returned: $("#amount_to_be_returned").val() || "",
                items: []
            };

            $(".has-many-requisitionItemReceipts-form").each(function () {
                var removedInput = $(this).find("input[name*=\'[_remove_]\']");
                if (removedInput.length && removedInput.val() === "1") {
                    return;
                }

                draft.items.push({
                    requisition_item_id: $(this).find("select[name*=\'[requisition_item_id]\']").val() || "",
                    amount: $(this).find("input[name*=\'[amount]\']").val() || "",
                    transfer_charges: $(this).find("input[name*=\'[transfer_charges]\']").val() || ""
                });
            });

            return draft;
        }

        function saveAccountabilityDraft() {
            var draft = collectAccountabilityDraft();
            localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
        }

        function hasAccountabilityDraft() {
            return localStorage.getItem(DRAFT_KEY) !== null;
        }

        function clearAccountabilityDraft() {
            localStorage.removeItem(DRAFT_KEY);
        }

        function restoreAccountabilityDraft() {
            var raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) {
                return;
            }

            var draft = JSON.parse(raw);
            var requisitionId = draft.requisition_id || "";

            function applyValuesToRows(items) {
                if (!items || !items.length) {
                    return;
                }

                setTimeout(function () {
                    var forms = $(".has-many-requisitionItemReceipts-form");
                    items.forEach(function (item, index) {
                        var row = forms.eq(index);
                        if (!row.length) {
                            return;
                        }

                        if (item.requisition_item_id) {
                            var select = row.find("select[name*=\'[requisition_item_id]\']");
                            var hasOption = select.find("option").filter(function () {
                                return $(this).val() == item.requisition_item_id;
                            }).length > 0;

                            if (select.length && !hasOption) {
                                select.append(new Option(item.requisition_item_id, item.requisition_item_id, true, true));
                            }
                            select.val(item.requisition_item_id).trigger("change");
                        }

                        row.find("input[name*=\'[amount]\']").val(item.amount || "").trigger("input");
                        row.find("input[name*=\'[transfer_charges]\']").val(item.transfer_charges || "").trigger("input");
                    });

                    if (draft.amount_used) {
                        $("#amount_used").val(draft.amount_used).trigger("input");
                    }
                    if (draft.returned_amount) {
                        $("#returned_amount").val(draft.returned_amount);
                    }
                    if (draft.amount_to_be_returned) {
                        $("#amount_to_be_returned").val(draft.amount_to_be_returned);
                    }

                    updateReturnAmounts();
                }, 700);
            }

            if (requisitionId && $("#requisitionId").length) {
                $("#requisitionId").val(requisitionId).trigger("change");

                if (draft.items && draft.items.length) {
                    var desiredRows = draft.items.length;
                    var currentRows = $(".has-many-requisitionItemReceipts-form").length;
                    for (var i = currentRows; i < desiredRows; i++) {
                        $(".add").click();
                    }
                }

                applyValuesToRows(draft.items || []);
            } else {
                if (draft.amount_dispensed) {
                    $("#amount_dispensed").val(draft.amount_dispensed);
                }
                if (draft.amount_used) {
                    $("#amount_used").val(draft.amount_used).trigger("input");
                }
                if (draft.returned_amount) {
                    $("#returned_amount").val(draft.returned_amount);
                }
                if (draft.amount_to_be_returned) {
                    $("#amount_to_be_returned").val(draft.amount_to_be_returned);
                }
                applyValuesToRows(draft.items || []);
            }
        }

        function updateReturnAmounts() {
            var amountUsed = sanitizeMoney($("#amount_used").val());
            var amountDispensed = sanitizeMoney($("#amount_dispensed").val());

            var returnedAmount = amountDispensed > amountUsed ? (amountDispensed - amountUsed) : 0;
            var amountToBeReturned = amountUsed > amountDispensed ? (amountUsed - amountDispensed) : 0;

            $("#returned_amount").val(returnedAmount.toFixed(2));
            $("#amount_to_be_returned").val(amountToBeReturned.toFixed(2));
        }

        $(document).ready(function() {
            $("#saveAccountabilityDraftBtn").off("click").on("click", function (e) {
                e.preventDefault();
                saveAccountabilityDraft();
                if (typeof toastr !== "undefined") {
                    toastr.success("Draft saved successfully.", "Success");
                }
            });

            $("#fetchAccountabilityDraftBtn").off("click").on("click", function (e) {
                e.preventDefault();
                if (!hasAccountabilityDraft()) {
                    if (typeof toastr !== "undefined") {
                        toastr.warning("No saved draft found.", "Info");
                    }
                    return;
                }

                var restore = confirm("Load saved draft? This will replace current form values.");
                if (restore) {
                    restoreAccountabilityDraft();
                    if (typeof toastr !== "undefined") {
                        toastr.success("Draft loaded successfully.", "Success");
                    }
                }
            });

            $("#requisitionId").change(function() {
                var requisition_id = $(this).val();
                if (requisition_id) {
                    $.ajax({
                        url: "/requisition/" + requisition_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if (data.total_amount) {
                                var amount = $("#amount_dispensed").val(data.total_amount);
                                $("#amount_used").val("");
                                $("#returned_amount").val("");
                                $("#amount_to_be_returned").val("");
                                
                                // Clear existing requisition items
                                $("#has-many-requisitionItemReceipts .has-many-requisitionItemReceipts-forms").empty();
        
                                // Check if there are items
                                if (data.items && Object.keys(data.items).length > 0) {
                                    // First, create all necessary forms
                                    for (var i = 0; i < Object.keys(data.items).length; i++) {
                                        $(".add").click();
                                    }
        
                                    // Wait for forms to be created
                                    setTimeout(function() {
                                        var forms = $("#has-many-requisitionItemReceipts .has-many-requisitionItemReceipts-forms").children();
                                        
                                        // Add options to each form
                                        Object.entries(data.items).forEach(function([key, value], index) {
                                            var currentForm = $(forms[index]);
                                            var requisitionItemField = currentForm.find("[id^=requisition_item_id]");
                                            
                                            // Clear existing options
                                            requisitionItemField.empty();
                                            
                                            // Add new option
                                            requisitionItemField.append(new Option(value.budget_line, key, true, true));
                                            requisitionItemField.trigger("change");

                                            bindListenersToReceipts(); // very important!
                                            recalculateTotalUsed(); // initialize total
                                            
                                        });
                                        // ✅ Disable Add button
                                        $("#has-many-requisitionItemReceipts .add").prop("disabled", true).addClass("disabled");

                                        // ✅ Disable all Remove buttons
                                        $("#has-many-requisitionItemReceipts .remove").prop("disabled", true).addClass("disabled");

                                    }, 500); // Increased timeout to ensure forms are ready
                                }
                            }
                        }
                    });
                }
            });

            function bindListenersToReceipts() {
                $(".has-many-requisitionItemReceipts-form").each(function () {
                    const $form = $(this);
                    $form.find("input[name*=\'[amount]\'], input[name*=\'[transfer_charges]\']")
                        .off("input") // avoid duplicate bindings
                        .on("input", function () {
                            recalculateTotalUsed();
                        });
                });
            }

            function recalculateTotalUsed() {
                let totalUsed = 0;

                // Loop through each requisition item form
                $(".has-many-requisitionItemReceipts-form").each(function () {
                    let amountUsed = sanitizeMoney($(this).find("input[name*=\'[amount]\']").val());
                    let transferCharges = sanitizeMoney($(this).find("input[name*=\'[transfer_charges]\']").val());
                    console.log("transferCharges= ", transferCharges);
                    console.log("amountUsed= ", amountUsed);
                    totalUsed += (amountUsed + transferCharges);
                    console.log("total amount= ", totalUsed);
                });

                // Set the total in the #amount_used field
                $("#amount_used").val(totalUsed.toFixed(2)).trigger("input");
            }

        
            $(".has-many-requisitionItemReceipts-form").each(function() {
                bindListenersToReceipts(); // very important!
                recalculateTotalUsed(); // initialize total
                
            });


            $("#amount_used").on("input", function() {
                updateReturnAmounts();
            });

            updateReturnAmounts();

           
        });
        ');
    
            
        return $form;
    }

    
    public function getRequisitionItems($id)
    {
        $requisition = Requisition::with('requisition_items.budgetline', 'requisition_items.adminbudgetline')->find($id);

        if ($requisition) {
            // Map requisition items to include budget line names from either budgetline or adminbudgetline
            $items = $requisition->requisition_items->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        'id' => $item->id,
                        'budget_line' => $item->budgetline 
                            ? $item->budgetline->name 
                            : ($item->adminbudgetline ? $item->adminbudgetline->name : 'N/A') // Check adminbudgetline if budgetline is null
                    ]
                ];
            });

            Log::info('Items:', $items->toArray());

            return response()->json([
                'total_amount' => $requisition->amount,
                'items' => $items->toArray()
            ]);
        }

        return response()->json(['error' => 'Requisition not found'], 404);
    }

    public function status(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'accountability' => 'required|integer',
            'remarks' => 'string'
        ]);
        Log::info($validated);
        // $user = auth()->user()->id;
        $userId = Admin::user()->id;

        $accountability = Accountability::findOrFail($validated['accountability']);

        $accountability->update([
            'status'=>$validated['status'],
            'remarks' => $validated['remarks']?? null,
            'signature' => $userId
        ]);

        return response()->json(['success' => true]);
    }


}
