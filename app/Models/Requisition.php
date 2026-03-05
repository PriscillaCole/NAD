<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'activity_id',
        'program_id',
        'outcome_id',
        'output_id',
        'concept_note',
        'staff_id',
        'description',
        'setOff_date',
        'return_date',
        'amount',
        'status comment',
        ''
        
    ];
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
    //relationship between requisitions and activities
    public function outcome()
    {
        return $this->belongsTo(Outcome::class);
    }
    public function adminoutcome()
    {
        return $this->belongsTo(AdminActivity::class, 'outcome_id');
    }
    //relationship between requisitions and activities
    public function output()
    {
        return $this->belongsTo(Output::class);
    }

    // A requisition can have many accountabilities
    public function accountability()
    {
        return $this->hasOne(Accountability::class);
    }
    // Relationship between requisitions and admin_ programs
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Relationship between requisitions and admin_ programs
    public function admin_program()
    {
        return $this->belongsTo(AdminProgram::class, 'admin_program_id');
    }

  
    // boot function to send emails 
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // Notification::send_notification($model, 'Requisition', request()->segment(count(request()->segments())));
        });


        static::updated(function ($model) {
            //send email to the country director
            error_log($model->status);
            Notification::update_notification($model, 'Requisition', request()->segment(count(request()->segments())));
        });

      
    }

    
}
