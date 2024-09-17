<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountabilityReceipt extends Model
{
    use HasFactory;

    protected $fillable = ['accountability_id', 'receipt_path'];

    public function accountability()
    {
        return $this->belongsTo(Accountability::class, 'accountability_id');
    }


}
