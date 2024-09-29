<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItemReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_item_id',
        'accountability_id',
        'receipt_file',
        'amount',
        'date',
    ];


    // A receipt belongs to a requisition item
    public function requisitionItem()
    {
        return $this->belongsTo(RequisitionItem::class);
    }

    // A receipt belongs to an accountability
    public function accountability()
    {
        return $this->belongsTo(Accountability::class);
    }
}
