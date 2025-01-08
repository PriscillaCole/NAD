<?php

namespace App\Admin\Controllers;

use App\Models\Accountability;
use App\Models\Requisition;
use App\Models\RequisitionItemReceipt;
use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;

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

        //filter by program and activity
        $grid->filter(function($filter){
            $filter->disableIdFilter();

            $filter->equal('requisition_id', 'Requisition ID')->select(Requisition::all()->pluck('code', 'id'));
            //status filter
            $filter->equal('status', 'Status')->select([
                'pending' => 'Pending',
                'closed' => 'Closed',
                'rejected' => 'Rejected'
            ]);
        });

      
        $grid->column('requisition_id', __('Requisition id'))->display(function($requisition_id){
            return Requisition::find($requisition_id)->code;
        });
        
        $grid->column('', __('Amount dispensed'))->display(function(){
            return Requisition::find($this->requisition_id)->amount;
        });
        $grid->column('amount_used', __('Amount used'));
        $grid->column('status', __('Status'))->display(
            function ($status) {
                if ($status == null) {
                    return "<span class='label label-warning'>pending</span>";
                } elseif ($status == 'closed') {
                    return "<span class='label label-success'>closed</span>";
                } elseif ($status == 'rejected') {
                    return "<span class='label label-danger'>rejected</span>";
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
    // protected function form()
    // {
    //     $form = new Form(new Accountability());
    
    //     $user = Admin::user();
    //     $staff_id = Staff::where('user_id', $user->id)->first()->id;
    
    //     if($form->isCreating()){ 
    //         // Select Requisition that was approved
    //         $form->select('requisition_id', __('Requisition ID'))
    //             ->options(Requisition::where('staff_id', $staff_id)->where('status', 'approved')->pluck('code', 'id'))
    //             ->attribute('id', 'requisition_id');
                
    //         // Display Amount Dispensed (read-only)
    //         $form->text('', __('Amount dispensed'))
    //             ->attribute('id', 'amount_dispensed')
    //             ->readonly();
    
    //         // Requisition items and receipts (This section will be dynamically populated via JavaScript)
    //         $form->html('<div id="requisition-items"></div>'); // Placeholder for requisition items and receipt fields

    //         $form->multipleFile('receiptFiles', __('Any other relevant receipts'))->pathColumn('receipt_path')->removable();

    //         $form->decimal('amount_used', __('Total amount used'))
    //         ->attribute('id', 'amount_used');
    //     }
    
    //     $form->decimal('returned_amount', __('Amount returned to finance'))
    //         ->attribute('id', 'returned_amount')
    //         ->readonly();
    
    //     $form->decimal('amount_to_be_returned', __('Amount returned to staff'))
    //         ->attribute('id', 'amount_to_be_returned')
    //         ->readonly();
    
    //     // File fields for proof of funds and narrative report
       

    //     if($user->isRole('finance')) {
    //     $form->file('proof_of_funds_to_be_returned', __('Receipt for funds returned to staff'));
    //     }else{
    //         $form->file('proof_of_funds_returned', __('Receipt for funds returned to finance'));
    //         $form->hidden('staff_id')->default($staff_id);
    //     }

    //     $form->file('narrative_report', __('Narrative Report'));
    
    //     if($form->isEditing()) {
    //         if($user->isRole('finance')) {
    //             $form->textarea('remarks', __('Additional remarks'))->required();
    //             $form->radioButton('status', __('Status'))->options(['closed' => 'Closed', 'rejected' => 'Rejected', 'halted' => 'Halted'])->required();
    //             $form->file('signature', __('Signature'))->required();
    //             $form->hidden('staff_id')->default($staff_id);
    //         }
    //     }
    
    //     // JavaScript for handling AJAX calls and dynamic form updates
    //     Admin::script('
    //         $(document).ready(function() {
    //             // Fetch amount dispensed and requisition items when requisition_id changes
    //             $("#requisition_id").change(function() {
    //                 var requisition_id = $(this).val();
    //                 if (requisition_id) {
    //                     $.ajax({
    //                         url: "/requisition/" + requisition_id ,
    //                         type: "GET",
    //                         dataType: "json",
    //                         success: function(data) {
    //                             console.log("AJAX Response:", data); // Debugging output
    //                             if (data.total_amount) {
    //                                 $("#amount_dispensed").val(data.total_amount);
    //                                 $("#amount_used").val("");
    //                                 $("#returned_amount").val("");
    //                                 $("#amount_to_be_returned").val("");
    
    //                                 // Populate the requisition items section with inputs for each item
    //                                 var itemsHtml = "";
    //                                 data.items.forEach(function(item, index) {
    //                                     itemsHtml += "<div class=\'item-section\'>" +
    //                                         "<h5>Item: " + item.item + " (Quantity: " + item.quantity + ", Unit Price: " + item.unit_price + ")</h5>" +
    //                                         "<input type=\'hidden\' name=\'requisition_item_ids[]\' value=\'" + item.id + "\' />" +
    //                                         "<label>Upload Invoice for this item  (you can upload multiple):</label>" +
    //                                         "<input type=\'file\' name=\'receipt_files[" + item.id + "][]\' class=\'form-control\' multiple />" +
    //                                         // "<label>Upload proof of payment   (you can upload multiple):</label>" +
    //                                         // "<input type=\'file\' name=\'receipt_files[" + item.id + "][]\' class=\'form-control\' multiple />" +
    //                                         // "<label>Upload Receipt for this item  (you can upload multiple):</label>" +
    //                                         // "<input type=\'file\' name=\'receipt_files[" + item.id + "][]\' class=\'form-control\' multiple />" +
                                            
    //                                         "</div><hr>";
    //                                 });
    //                                 $("#requisition-items").html(itemsHtml); // Insert items into the form
    //                             } else {
    //                                 console.log("Total amount not found in response.");
    //                             }
    //                         },
    //                         error: function(jqXHR, textStatus, errorThrown) {
    //                             console.error("AJAX Error:", textStatus, errorThrown); // Debugging output
    //                         }
    //                     });
    //                 }
    //             });
    
    //             // Calculate returned amount and amount to be returned on amount_used change
    //             $("#amount_used").on("input", function() {
    //                 var amount_used = parseFloat($(this).val()) || 0;
    //                 var amount_dispensed = parseFloat($("#amount_dispensed").val()) || 0;
    
    //                 var returned_amount = amount_dispensed > amount_used ? (amount_dispensed - amount_used) : 0;
    //                 var amount_to_be_returned = amount_used > amount_dispensed ? (amount_used - amount_dispensed) : 0;
    
    //                 $("#returned_amount").val(returned_amount.toFixed(2));
    //                 $("#amount_to_be_returned").val(amount_to_be_returned.toFixed(2));
    //             });
    //         });
    //     ');
    
    //     return $form;
    // }

//     protected function form()
// {
//     $form = new Form(new Accountability());

//     $user = Admin::user();
//     $staff_id = Staff::where('user_id', $user->id)->first()->id;

    
//         // Select Requisition that was approved
//         $form->select('requisition_id', __('Requisition ID'))
//             ->options(Requisition::where('staff_id', $staff_id)->where('status', 'approved')->pluck('code', 'id'))
//             ->attribute('id', 'requisition_id');
            
//         $form->text('', __('Amount dispensed'))
//             ->attribute('id', 'amount_dispensed')
//             ->readonly();

//         if($form->isCreating()){ 
//         // $form->hasMany('requisitionItemReceipts', 'Requisition items Receipts', function (Form\NestedForm $form) {
//         //     $form->multipleFile('', __('Receipts'));

//         // });

//         // $form->multipleFile('', __('Receipts'));
//         $form->divider('Requisition items Receipts');

//         // Requisition items section
//         $form->html('<div id="requisition-items"></div>');

//         // Change this to handle multiple files properly
//         $form->multipleFile('additional_receipts', __('Any other relevant receipts'))
//             ->pathColumn('receipt_path')
//             ->removable()
//             ->options(['maxFileSize' => 5]); // Optional: add file size limit

//         $form->decimal('amount_used', __('Total amount used'))
//             ->attribute('id', 'amount_used');
//     }
//     // $form->display('requisition_id', __('Requisition ID'))
//     //         ->options(Requisition::where('staff_id', $staff_id)->pluck('code', 'id'))
//     //         ->attribute('id', 'requisition_id');
         

//     $form->decimal('returned_amount', __('Amount returned to finance'))
//         ->attribute('id', 'returned_amount')
//         ->readonly();

//     $form->decimal('amount_to_be_returned', __('Amount returned to staff'))
//         ->attribute('id', 'amount_to_be_returned')
//         ->readonly();

//     if($user->isRole('finance')) {
//         $form->file('proof_of_funds_to_be_returned', __('Receipt for funds returned to staff'));
//     } else {
//         $form->file('proof_of_funds_returned', __('Receipt for funds returned to finance'));
//         $form->hidden('staff_id')->default($staff_id);
//     }

//     $form->file('narrative_report', __('Narrative Report'));

//     if($form->isEditing()) {
//         if($user->isRole('finance')) {
//             $form->textarea('remarks', __('Additional remarks'))->required();
//             $form->radioButton('status', __('Status'))
//                  ->options(['closed' => 'Closed', 'rejected' => 'Rejected', 'halted' => 'Halted'])
//                  ->required();
//             $form->file('signature', __('Signature'))->required();
//             $form->hidden('staff_id')->default($staff_id);
//         }
//     }

//     // Modified JavaScript for handling file uploads
//     Admin::script('
//         $(document).ready(function() {
//             $("#requisition_id").change(function() {
//                 var requisition_id = $(this).val();
//                 if (requisition_id) {
//                     $.ajax({
//                         url: "/requisition/" + requisition_id,
//                         type: "GET",
//                         dataType: "json",
//                         success: function(data) {
//                             if (data.total_amount) {
//                                 $("#amount_dispensed").val(data.total_amount);
//                                 $("#amount_used").val("");
//                                 $("#returned_amount").val("");
//                                 $("#amount_to_be_returned").val("");

//                                 // Modified file input structure
//                                 var itemsHtml = "";
//                                 data.items.forEach(function(item, index) {
//                                     itemsHtml += `
//                                         <div class="item-section">
//                                             <h5>Item: ${item.item} (Quantity: ${item.quantity}, Unit Price: ${item.unit_price})</h5>
//                                             <input type="hidden" name="item_ids[]" value="${item.id}" />
//                                             <div class="form-group">
//                                                 <label>Upload Invoice for this item:</label>
//                                                 <input type="file" 
//                                                        name="item_receipts_${item.id}[]" 
//                                                        class="form-control" 
//                                                        multiple 
//                                                        accept=".pdf,.jpg,.jpeg,.png" />
//                                             </div>
//                                             <div class="form-group">
//                                                 <label>Proof of payment:</label>
//                                                 <input type="file" 
//                                                        name="item_receipts_${item.id}[]" 
//                                                        class="form-control" 
//                                                        multiple 
//                                                        accept=".pdf,.jpg,.jpeg,.png" />
//                                             </div>
//                                             <div class="form-group">
//                                                 <label>Receipt:</label>
//                                                 <input type="file" 
//                                                        name="item_receipts_${item.id}[]" 
//                                                        class="form-control" 
//                                                        multiple 
//                                                        accept=".pdf,.jpg,.jpeg,.png" />
//                                             </div>
//                                         </div>
//                                         <hr>
//                                     `;
//                                 });
//                                 $("#requisition-items").html(itemsHtml);
//                             }
//                         },
//                         error: function(jqXHR, textStatus, errorThrown) {
//                             console.error("AJAX Error:", textStatus, errorThrown);
//                         }
//                     });
//                 }
//             });

//             $("#amount_used").on("input", function() {
//                 var amount_used = parseFloat($(this).val()) || 0;
//                 var amount_dispensed = parseFloat($("#amount_dispensed").val()) || 0;

//                 var returned_amount = amount_dispensed > amount_used ? (amount_dispensed - amount_used) : 0;
//                 var amount_to_be_returned = amount_used > amount_dispensed ? (amount_used - amount_dispensed) : 0;

//                 $("#returned_amount").val(returned_amount.toFixed(2));
//                 $("#amount_to_be_returned").val(amount_to_be_returned.toFixed(2));
//             });
//         });
//     ');

//     return $form;
// }

protected function form()
{
    $form = new Form(new Accountability());

    $user = Admin::user();
    $staff_id = Staff::where('user_id', $user->id)->first()->id;

    $form->select('requisition_id', __('Requisition ID'))
        ->options(Requisition::where('staff_id', $staff_id)->where('status', 'approved')->pluck('code', 'id'))
        ->attribute('id', 'requisition_id');
        
    $form->text('', __('Amount dispensed'))
        ->attribute('id', 'amount_dispensed')
        ->readonly();

    if($form->isCreating()){ 
        $form->divider('Requisition items Receipts');

        // We'll use this div to dynamically inject our nested forms
        $form->html('<div id="dynamic-nested-forms"></div>');

        $form->decimal('amount_used', __('Total amount used'))
            ->attribute('id', 'amount_used');
    }

    // Rest of your form code...

    Admin::script('
        $(document).ready(function() {
            $("#requisition_id").change(function() {
                var requisition_id = $(this).val();
                if (requisition_id) {
                    $.ajax({
                        url: "/requisition/" + requisition_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if (data.total_amount) {
                                $("#amount_dispensed").val(data.total_amount);
                                $("#amount_used").val("");
                                $("#returned_amount").val("");
                                $("#amount_to_be_returned").val("");

                                // Generate nested forms for each item
                                var formsHtml = "";
                                data.items.forEach(function(item, index) {
                                    formsHtml += `
                                        <div class="fields-group">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Item Receipts for: ${item.item}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Requisition Item</label>
                                                        <input type="text" 
                                                            class="form-control" 
                                                            readonly 
                                                            value="${item.item} (Quantity: ${item.quantity}, Unit Price: ${item.unit_price})"
                                                        />
                                                        <input type="hidden" 
                                                            name="requisitionItemReceipts[${index}][requisition_item_id]" 
                                                            value="${item.id}"
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Invoice</label>
                                                        <input type="file" 
                                                            name="requisitionItemReceipts[${index}][invoice_file]" 
                                                            class="form-control"
                                                            accept=".pdf,.jpg,.jpeg,.png" 
                                                        />
                                                        <input type="hidden" 
                                                            name="requisitionItemReceipts[${index}][invoice_type]" 
                                                            value="invoice"
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Proof of Payment</label>
                                                        <input type="file" 
                                                            name="requisitionItemReceipts[${index}][payment_file]" 
                                                            class="form-control"
                                                            accept=".pdf,.jpg,.jpeg,.png" 
                                                        />
                                                        <input type="hidden" 
                                                            name="requisitionItemReceipts[${index}][payment_type]" 
                                                            value="payment_proof"
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Receipt</label>
                                                        <input type="file" 
                                                            name="requisitionItemReceipts[${index}][receipt_file]" 
                                                            class="form-control"
                                                            accept=".pdf,.jpg,.jpeg,.png" 
                                                        />
                                                        <input type="hidden" 
                                                            name="requisitionItemReceipts[${index}][receipt_type]" 
                                                            value="receipt"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                                $("#dynamic-nested-forms").html(formsHtml);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", textStatus, errorThrown);
                        }
                    });
                }
            });

            // Your existing amount calculation code...
        });
    ');

    // Handle the file uploads on form saving
    $form->saving(function (Form $form) {
        if (request()->has('requisitionItemReceipts')) {
            $receipts = request()->requisitionItemReceipts;
            
            foreach ($receipts as $index => $receiptGroup) {
                $requisition_item_id = $receiptGroup['requisition_item_id'];
                
                // Handle invoice
                if (isset($receiptGroup['invoice_file'])) {
                    $path = $receiptGroup['invoice_file']->store('receipts', 'admin');
                    RequisitionItemReceipt::create([
                        'accountability_id' => $form->model()->id,
                        'requisition_item_id' => $requisition_item_id,
                        'file_path' => $path,
                        'receipt_type' => 'invoice'
                    ]);
                }
                
                // Handle payment proof
                if (isset($receiptGroup['payment_file'])) {
                    $path = $receiptGroup['payment_file']->store('receipts', 'admin');
                    RequisitionItemReceipt::create([
                        'accountability_id' => $form->model()->id,
                        'requisition_item_id' => $requisition_item_id,
                        'file_path' => $path,
                        'receipt_type' => 'payment_proof'
                    ]);
                }
                
                // Handle receipt
                if (isset($receiptGroup['receipt_file'])) {
                    $path = $receiptGroup['receipt_file']->store('receipts', 'admin');
                    RequisitionItemReceipt::create([
                        'accountability_id' => $form->model()->id,
                        'requisition_item_id' => $requisition_item_id,
                        'file_path' => $path,
                        'receipt_type' => 'receipt'
                    ]);
                }
            }
        }
    });

    return $form;
}
    
    public function getRequisitionItems($id)
    {
        $requisition = Requisition::with('requisition_items')->find($id);
    
        if ($requisition) {
            return response()->json([
                'total_amount' => $requisition->amount,
                'items' => $requisition->requisition_items // Return the requisition items
            ]);
        }
        return response()->json(['error' => 'Requisition not found'], 404);
    }

}
