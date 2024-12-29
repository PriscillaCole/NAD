<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget',
        'description',
        'user_id',
        
    ];

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }


    public function user()
    {
    
        return $this->belongsTo(User::class);
    }
    
}
