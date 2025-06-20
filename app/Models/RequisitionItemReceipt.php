<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItemReceipt extends Model
{
    use HasFactory;
    protected $casts = [
    'receipt_file' => 'array',
    'payment_proof' => 'array',
    'Invoice' => 'array',
    ];

    protected $fillable = [
        'requisition_item_id',
        'accountability_id',
        'receipt_file',
        'payment_proof',
        'Invoice',
        'amount',
        'transfer_charges'
        
    ];


    // A receipt belongs to a requisition item
    public function requisitionItem()
    {
        return $this->belongsTo(RequisitionItem::class, 'requisition_item_id');
    }

    // A receipt belongs to an accountability
    public function accountability()
    {
        return $this->belongsTo(Accountability::class);
    }
}
