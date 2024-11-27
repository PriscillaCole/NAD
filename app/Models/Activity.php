<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'budget',
        'output_id',
    ];

    public function output()
    {
        return $this->belongsTo(Output::class);
    }

    
    public function budgetLines()
    {
        return $this->hasMany(BudgetLines::class);
    }
}
