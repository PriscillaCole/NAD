<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget'
        
    ];

    public function adminPrograms()
    {
        return $this->belongsTo(Program::class);
    }
     public function adminBudgetLines()
     {
        return $this->hasMany(AdminBudget_lines::class);
     }

    
}
