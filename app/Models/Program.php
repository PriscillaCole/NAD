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
        'third_budget',
        'second_budget',
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

    public function contingencyBudgets()
    {
        return $this->hasMany(ContingencyBudget::class);
    }

    // boot function to send emails 
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Notification::send_notification($model, 'Program', request()->segment(count(request()->segments())));
        });


        static::updated(function ($model) {
            //send email to the country director
            error_log($model->status);
            Notification::update_notification($model, 'Requisition', request()->segment(count(request()->segments())));
        });

      
    }
    
}
