<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Accountability extends Model
{
    use HasFactory;

    protected $casts = [
    'receipt_file' => 'array',
    'payment_proof' => 'array',
    'Invoice' => 'array',
    'attachments' => 'array',
    ];

    
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
        'amount_used',
        'attachments'
    ];

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


       

    
    // }

    public static function boot()
    {
        parent::boot();

        // When a new accountability is created
        // static::created(function ($model) {
        //     $receiver = Notification::get_users_by_role(8);
        //     Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver);
        // });

        static::updated(function ($model) {
            if ($model->status === 'pending') {
                Log::info('pending.........');
                $receiver = Notification::get_users_by_role(5);
                Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver);
            }

            if ($model->status === 'closed') {
                Log::info('closed.........');
                Notification::update_notification($model, 'Accountability', request()->segment(count(request()->segments())));
                // Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver);
            }
            if ($model->status === 'halted') {
                Log::info('halted.........');
                //$receiver = Notification::get_users_by_role(5);
                Notification::update_notification($model, 'Accountability', request()->segment(count(request()->segments())));
                
                // Notification::Notify_Admin($model, 'Accountability', request()->segment(count(request()->segments())), $receiver);
            }
                
        });

        

    }

    public function receiptFiles()
    {
        return $this->hasMany(AccountabilityReceipt::class, 'accountability_id');
    }

    
}
