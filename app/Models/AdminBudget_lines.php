<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBudget_lines extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_cost'
        
    ];

    public function adminActivity()
    {
        return $this->belongsTo(AdminProgram::class);
    }

    
}
