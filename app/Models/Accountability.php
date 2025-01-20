<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Accountability extends Model
{
    use HasFactory;
    
    //on creating a new accountability, convert receipt files to json
    protected $fillable = [
        'requisition_id', 
        'narrative_report', 
        'returned_amount', 
        'amount_to_be_returned', 
        'status', 
        'receipt_files', 
        'remarks', 
        'signature', 
        'amount_used'];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // An accountability has many receipts (through items)
    public function requisitionItemReceipts()
    {
         return $this->hasMany(RequisitionItemReceipt::class);
    }


    // boot function to send emails 
    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($model) {
    //         $receiver = Notification::get_users_by_role(8);
    //         Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver );


    //         // $request = request(); // Get the current request object
    //         // $payment_proof = $model->payment_proof->store('payment_proof');
    //         // $invoice = $model->Invoice->store('payment_proof');

    //         // Check if the request has receipt files and requisition item IDs
    //         // if ($request->has('receipt_files') && $request->has('requisition_item_ids')) {
    //         //     foreach ($request->receipt_files as $itemId => $files) {
    //         //         foreach ($files as $file) {
                        
    //         //             $path = $file->store('receipts');
    //         //              // Store each file
    //         //             RequisitionItemReceipt::create([
    //         //                 'requisition_item_id' => $itemId, // Associate with the correct item
    //         //                 'accountability_id' => $model->id, // Use created accountability ID
    //         //                 'receipt_file' => $path,
    //         //                 'Invoice'=> $invoice,
    //         //                 'payment_proof'=>$payment_proof,
    //         //                 'amount' => 0, // Add amount logic if necessary
                            
    //         //             ]);
    //         //         }
    //         //     }
    //         // }
        

    //     });


    //     static::updated(function ($model) {
    //         $hasPaymentProof = $model->requisitionItemReceipts()
    //         ->whereNotNull('payment_proof')
    //         ->exists();
    
    //         if ($hasPaymentProof) {
    //             $receiver = $model->user_id;
    //             Notification::Notify_Admin($model, 'Payment Proof', request()->segment(count(request()->segments())), $receiver );

    //         }

    //         if ($model->status === 'closed') {
    //             // Fetch the Requisition along with its Activity in a single query
    //             $requisition = Requisition::with('activity')->find($model->requisition_id);
            
    //             if ($requisition) {
    //                 $activity = $requisition->activity;
                    
    //                 if ($activity) {
    //                     // Calculate the total amount used and amount to be returned
    //                     $total_amount_used = $model->amount_used;
            
    //                     // Save the updated budget
    //                     $budget = new Budget();
    //                     $budget->requisition_id = $model->requisition_id;
    //                     $budget->total_amount_used = $total_amount_used;
    //                     $budget->save();
    //                 } else {
    //                     // Handle case where activity is not found
    //                     Log::warning('Activity not found for Requisition ID: ' . $model->requisition_id);
    //                 }
    //             } else {
    //                 // Handle case where requisition is not found
    //                 Log::warning('Requisition not found for ID: ' . $model->requisition_id);
    //             }
    //         }
            
        
    //     });

    
    // }

    public static function boot()
{
    parent::boot();

    // When a new accountability is created
    static::created(function ($model) {
        $receiver = Notification::get_users_by_role(8);
        Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver);
    });

}

    public function receiptFiles()
    {
        return $this->hasMany(AccountabilityReceipt::class, 'accountability_id');
    }

    
}
