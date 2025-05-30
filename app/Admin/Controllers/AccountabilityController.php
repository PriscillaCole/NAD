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
        if ($user->isRole('staff')) {
            $staff_id = Staff::where('user_id', $user->id)->first()->id;
            $grid->model()->where('staff_id', $staff_id);
        }
        // disable create button for finance and CD
        if ($user->inRoles(['finance', 'director'])){
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableDelete();
            });
        }
        
        // $grid->actions(function ($actions) {
        //     if ($actions->row->status == 'closed') {
        //         $actions->disableEdit();
        //     }
        // });

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
                    return "<span class='label label-warning'>pending</span>";
                } elseif ($status == 'closed') {
                    return "<span class='label label-success'>closed</span>";
                } elseif ($status == 'halted') {
                    return "<span class='label label-danger'>halted</span>";
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
                ->attribute('id', 'requisitionId');

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
                    
                    
                    $form->file('Invoice', __('Invoice'))
                    ->help('upload fies of jpg,jpeg,png formats ')
                    ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    ->removable()
                    ->required();
    
                    // $form->file('payment_proof', __('Proof of Payment'))
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    // ->removable();
                    // $form->file('receipt_file', __('Receipt'))
                    // ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                    // ->removable();
                    
                    $form->text('amount', 'Amount');
                });
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
                })
                ->attribute('id', 'amount_dispensed');

                Log::info('form->amount_dispensed');

                // $existingRequisition= $form->model()->requisition->id;
                $form->hasMany('requisitionItemReceipts', 'Requisition items', function (Form\NestedForm $form)use ($existingRequisition)  {
                        $requisition = Requisition::findOrfail($existingRequisition);
                        $user = auth()->user();
                        $staff_id = Staff::where('user_id', $user->id)->first()->id;

                        $form->display('requisition_item_id', __('Budgets Line'))
                        ->with(function ($value) {
                            if ($value) {
                                $requisitionItem = RequisitionItem::find($value);
                                return $requisitionItem ? ($requisitionItem->adminbudgetline->name ?? $requisitionItem->budgetline->name) : 'N/As';
                            }
                
                            return 'N/A';
                        });
                        
                        if($staff_id != $requisition->staff->id){
                           
                            $form->file('Invoice', __('Invoice'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable()
                            ->readonly();
                            $form->text('amount', 'Amount');
            
                            $form->file('payment_proof', __('Proof of Payment'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
                        }
                        if ($staff_id == $requisition->staff->id){
                            
                            $form->file('Invoice', __('Invoice'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
            
                            $form->display('payment_proof', __('Proof of Payment'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            // ->removable()
                            ->default('No proof of payment yet')
                            ->readonly();
                            $form->file('receipt_file', __('Receipt'))
                            ->help('upload fies of jpg,jpeg,png formats ')
                            ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120') // 5MB max
                            ->removable();
                            
                            $form->text('amount', 'Amount');
                        }
                    
                })
                ->disableDelete()  // disables the "Remove" (trash icon) button
                ->disableCreate();

                $form->hidden('staff_id')->default($staff_id);
                
                $form->decimal('amount_used', __('Total amount used(UGX)'))
                ->default(function($returned_amount)use ($form) {
                    $amount = $form->model()->amount_used;

                    return number_format($amount);
                })
                ->attribute(['id'=>'amount_used',
                    'name'=>'amount_used',
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                 ]);
                // }
                Log::info(['$form=>amount', $form->amount_used]);
    
                $form->decimal('returned_amount', __('Amount returned to finance(UGX)'))
                    ->value(function($returned_amount) {
                        
                        return number_format($returned_amount);
                    })
                    ->attribute('id', 'returned_amount')
                    ->readonly();
            
                $form->decimal('amount_to_be_returned', __('Amount returned to staff'))
                    ->default(function($amount_to_be_returned)use ($form) {
                        $amount = $form->model()->amount_to_be_returned;

                        return number_format($amount);
                    })
                    ->attribute(['id'=>'amount_to_be_returned',
                        'name'=>'amount_to_be_returned',
                        'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');"
                    ])
                    ->readonly();
            
                // File fields for proof of funds and narrative report

                if($user->isRole('finance')) {
                    $form->file('proof_of_funds_to_be_returned', __('Receipt for funds returned to staff'));
                    }else{
                        $form->file('proof_of_funds_returned', __('Receipt for funds returned to finance'))
                        ->help('upload files of jpg,jpeg,png formats ')
                        ->rules('file|mimes:pdf,jpg,jpeg,png|max:5120');
                        
                    }
            
                    $form->file('narrative_report', __('Narrative Report'))
                    ->help('upload files of pdf,doc formats ')
                    ->rules('file|mimes:pdf|max:5120');
            }

            $form->saving(function (Form $form) {
                Log::info('Form saving started', ['data' => request()->all()]);
                // Log::info('Received form data', $form()->all());
            
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
        $(document).ready(function() {
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
                                        });
                                    }, 500); // Increased timeout to ensure forms are ready
                                }
                            }
                        }
                    });
                }
            });
        
            

            $("#amount_used").on("input", function() {
                var amount_used = $(this).val();
                var amount_dispensed = parseFloat($("#amount_dispensed").val()) || 0;
                // var amount_dispensed = {{ $form->requisition->amount ?? 0 }};

                console.log(amount_dispensed);
        
                var returned_amount = amount_dispensed > amount_used ? (amount_dispensed - amount_used) : 0;
                var amount_to_be_returned = amount_used > amount_dispensed ? (amount_used - amount_dispensed) : 0;
        
                $("#returned_amount").val(returned_amount.toFixed(2));
                $("#amount_to_be_returned").val(amount_to_be_returned.toFixed(2));
            });

           
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
            'remark' => 'string'
        ]);

        $accountability = Accountability::findOrFail($validated['accountability']);

        $accountability->update([
            'status'=>$validated['status'],
            'remarks' => $validated['remark']?? null
        ]);

        return response()->json(['success' => true]);
    }


}
