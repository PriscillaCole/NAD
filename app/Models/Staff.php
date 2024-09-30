<?php

namespace App\Models;

use Encore\Admin\Grid\Filter\Where;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'user_id',
        'staff_number',
        'nin_number',
        'name',
        'date_of_birth',
        'home_district',
        'title',
        'contract_start',
        'contract_end',
        'project',
        'region',
        'duty_station',
        'line_manager',
        'telephone',
        'email',
        'bank',
        'bank_account',
        'tin',
        'nssf',
        'marital_status',
        'next_of_kin',
        'contact_of_kin',
        'relationship',
        'profile_picture',
    ];


    //relationship between staff and requisitions
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }

    public function accountabilities()
    {
        return $this->hasMany(Accountability::class);
    }


    //on create and update, set the staff_id to be the same as the id
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
           
        });
        
        static::creating(function ($model) {
              // Check if the user exists by email or staff_id
              $existing_user = User::where('email', $model->email)->first();

              if (!$existing_user) {
                  // User does not exist, create a new user
                  $new_user = new User();
                  $new_user->username = $model->staff_number ?? $model->name;
                  $new_user->email = $model->email !== 'No email' && $model->email !== null ? $model->email : ($model->name . '@gmail.com');
                  $new_user->name = $model->name;
                  $new_user->avatar = $model->profile_picture ? $model->profile_picture : 'images/default_image.png';
                  $new_user->password = Hash::make($model->staff_number) ?? Hash::make($model->name);
                  $new_user->staff_id = $model->id;
          
                  $new_user->save();

                     // Check if the user already has the role assigned
                    $existing_role = AdminRoleUser::where('user_id', $new_user->id)
                    ->where('role_id', 3)  // Staff role ID
                    ->first();

                    if (!$existing_role) {
                        // Role is not yet assigned, so assign the new role
                        $new_role = new AdminRoleUser();
                        $new_role->role_id = 3; // Staff role ID
                        $new_role->user_id = $new_user->id;
                        $new_role->save();
                        } else {
                        // The user already has the role, handle accordingly (optional)
                        Log::info('User already has the staff role with user_id: ' . $new_user->id);
                        }
                        
                        $model->user_id = $new_user->id;
                } else {
                // User not found, handle accordingly (optional)
                Log::error('User not found with username: ' . $model->staff_number . ' or name: ' . $model->name);
                }

             

                
        });
    }
}
