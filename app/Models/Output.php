<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'outcome_id',
        'budget',
    ];
    public function outcome()
    {
        return $this->belongsTo(Outcome::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
