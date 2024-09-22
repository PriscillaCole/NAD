<?php

namespace App\Admin\Controllers;

use App\Models\Accountability;
use App\Models\Requisition;
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
    protected function form()
    {
        $form = new Form(new Accountability());

        $user = Admin::user();
        $staff_id = Staff::where('user_id', $user->id)->first()->id;

        if($form->isCreating()){ $form->select('requisition_id', __('Requisition ID'))->options(Requisition::where('staff_id', $staff_id)->pluck('code', 'id'))->attribute('id', 'requisition_id');
            $form->text('', __('Amount dispensed'))->attribute('id', 'amount_dispensed')->readonly();
            $form->decimal('amount_used', __('Total amount used'))->attribute('id', 'amount_used');
            
        }

       
        $form->decimal('returned_amount', __('Amount returned to finance'))->attribute('id', 'returned_amount')->readonly();
            $form->decimal('amount_to_be_returned', __('Amount returned to staff'))->attribute('id', 'amount_to_be_returned')->readonly();
            $form->file('proof_of_funds_returned', __('Receipt for funds returned to finance'));
            $form->file('proof_of_funds_to_be_returned', __('Receipt for funds returned to staff'));
            $form->multipleFile('receiptFiles', __('Receipts for used amount'))->pathColumn('receipt_path')->removable();
            $form->file('narrative_report', __('Narrative Report')); 
        
        if($form->isEditing()){
            if($user->isRole('finance')){
                $form->textarea('remarks', __('Additional remarks'))->required();
                $form->radioButton('status', __('Status'))->options(['closed' => 'Closed', 'rejected' => 'Rejected','halted' => 'Halted'])->required();
                $form->file('signature', __('Signature'))->required();
                $form->hidden('staff_id')->default($staff_id);
            }
        }
       
        
        // JavaScript for auto-populating fields and calculations
        Admin::script('
            $(document).ready(function() {
                // Fetch amount dispensed when requisition_id changes
                $("#requisition_id").change(function() {
                    var requisition_id = $(this).val();
                    if (requisition_id) {
                        $.ajax({
                            url: "/requisition/" + requisition_id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                console.log("AJAX Response:", data); // Debugging output
                                if (data.total_amount) {
                                    $("#amount_dispensed").val(data.total_amount);
                                    $("#amount_used").val("");
                                    $("#returned_amount").val("");
                                    $("#amount_to_be_returned").val("");
                                } else {
                                    console.log("Total amount not found in response.");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown); // Debugging output
                            }
                        });
                    }
                });
        
                // Calculate returned amount and amount to be returned on amount_used change
                $("#amount_used").on("input", function() {
                    var amount_used = parseFloat($(this).val()) || 0;
                    var amount_dispensed = parseFloat($("#amount_dispensed").val()) || 0;
        
                    var returned_amount = amount_dispensed > amount_used ? (amount_dispensed - amount_used) : 0;
                    var amount_to_be_returned = amount_used > amount_dispensed ? (amount_used - amount_dispensed) : 0;
        
                    $("#returned_amount").val(returned_amount.toFixed(2));
                    $("#amount_to_be_returned").val(amount_to_be_returned.toFixed(2));
                });
            });
        ');
        
        

        return $form;
    }

    public function Requisition($id)
{
    $requisition = Requisition::find($id);

    
    if ($requisition) {
        return response()->json([
            'total_amount' => $requisition->amount
        ]);
    }
    return response()->json(['error' => 'Requisition not found'], 404);
}

}
