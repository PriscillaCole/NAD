<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItemInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_item_id',
        'accountability_id',
        'Invoice',
        'amount',
        'date',
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
