<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'category_id',
        'item',
        'quantity',
        'unit_price',
        'unit_of_measure',
        'total_price',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
