<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'comment',
        'requisition_id',
        'commented_by'
    ];

    //relationship between comments and requisitions
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    //relationship between comments and staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'commented_by');
    }
}
