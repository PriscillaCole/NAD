<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ContingencyBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget',
        'program_id',
        
        
    ];

    //relationship with requisition
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    
}
