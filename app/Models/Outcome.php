<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program_id',
        'budget',
    ];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
