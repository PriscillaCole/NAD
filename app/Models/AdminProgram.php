<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'budget',
        // 'user_id',
        
    ];

    public function adminActivities()
    {
        return $this->hasMany(AdminActivity::class);
    }


    public function user()
    {
    
        return $this->belongsTo(User::class);
    }
    
}
