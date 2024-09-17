<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Accountability extends Model
{
    use HasFactory;
    
    //on creating a new accountability, convert receipt files to json
    protected $fillable = ['requisition_id', 'narrative_report', 'returned_amount', 'amount_to_be_returned', 'status', 'receipt_files', 'remarks', 'signature', 'amount_used'];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }


        //boot function to send emails 
        public static function boot()
        {
            parent::boot();
    
            static::created(function ($model) {
                Notification::send_notification($model, 'Accountability', request()->segment(count(request()->segments())));
            });
    
    
            static::updated(function ($model) {
              
            });
    
          
        }

    public function receiptFiles()
    {
        return $this->hasMany(AccountabilityReceipt::class, 'accountability_id');
    }
}
