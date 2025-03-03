<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ContigencyBudget extends Model
{
    use HasFactory;

    //relationship with requisition
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    
}
