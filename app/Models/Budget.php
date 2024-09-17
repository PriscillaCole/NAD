<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Budget extends Model
{
    use HasFactory;

    //relationship with requisition
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    
}
