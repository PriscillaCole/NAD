<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Requisition extends Model
{
    use HasFactory;

    //relationship between requisitions and staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    //relationship between requisitions and comments
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    //relationship between requisitions and requisition_items
    public function requisition_items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    //relationship between requisitions and activities
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

      // A requisition can have many accountabilities
      public function accountabilities()
      {
          return $this->hasMany(Accountability::class);
      }

  


    //boot function to send emails 
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Notification::send_notification($model, 'Requisition', request()->segment(count(request()->segments())));
        });


        static::updated(function ($model) {
            //send email to the country director
            error_log($model->status);
            Notification::update_notification($model, 'Requisition', request()->segment(count(request()->segments())));
        });

      
    }

    
}
