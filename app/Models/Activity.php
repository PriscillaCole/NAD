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
        'program_id'
    ];

    public function output()
    {
        return $this->belongsTo(Output::class);
    }
    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    
    public function budget_lines()
    {
        return $this->hasMany(BudgetLines::class);
    }
    public function contingencies()
    {
        return $this->hasMany(ContingencyBudget::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }

}
