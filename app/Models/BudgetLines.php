<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetLines extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'name',
        'unitcost',
        'quantity',
        'frequency',
        'budget',
        'dev_Vs_Org',
        'units'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
