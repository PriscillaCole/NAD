<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBudget_lines extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_cost',
        'quantity',
        'frequency',
        'total_cost'
        
    ];

    public function adminPrograms()
    {
        return $this->belongsTo(AdminProgram::class);
    }

    
}
