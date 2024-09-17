<?php

namespace App\Models;

use App\Mail\LeaveRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\Mail;
use App\Models\Staff;
use Encore\Admin\Facades\Admin;

class Notification extends Model
{
    use HasFactory;

    
    protected $fillable = 
    [
        'receiver_id',
        'role_id',
        'message',
        'form_link',
        'link',
        'model',
        'model_id',
    ];

    //relationship between notification and user
    public function receiver()
    {
        return $this->belongsTo(Administrator::class, 'receiver_id');
    }


    //function to get notification and send it to the front end
    public static function get_notifications($user)
    {
        if ($user == null) 
        {
            return [];
        }

        $done_ids = [];
        $notifications = Notification::where('receiver_id', $user->id)
            ->orderBy('id', 'desc')
            ->get()
            ->unique('id')
            ->values();

        foreach ($notifications as $notification) 
        {
            $done_ids[] = $notification->id;
        }

        foreach ($user->roles as $role) 
        {
            $roleNotifications = Notification::where('role_id', $role->id)
                ->orderBy('id', 'desc')
                ->get()
                ->unique('id')
                ->values();

            foreach ($roleNotifications as $notification) {
                if (in_array($notification->id, $done_ids)) {
                    continue;
                }
                $done_ids[] = $notification->id;
                $notifications->push($notification);
            }
        }

        return $notifications;
    }
        
    //function to send notifications after creation
    public static function send_notification($model, $model_name, $entity)
    {
        $user = Staff::find($model->staff_id);
        $name = $user ? $user->name : null;
       
        // Check if $entity is a string
        if (is_string($entity)) {
                $notification = new Notification();
                $notification->role_id = 5;
                $notification->message = "New {$entity} has been submitted by" . $name .' ';
                $notification->link = admin_url("auth/login");
                $notification->form_link = admin_url("{$entity}/{$model->id}");
                $notification->model = $model_name;
                $notification->model_id = $model->id;
                $notification->save();
            
                self::sendMail($notification);
            }
    }
    
    

    //function to send notifications after an update
    public static function update_notification($model, $model_name, $entity)
    {
        $notifications = Notification::where('model', $model_name)
            ->where('model_id', $model->id)
            ->get();
        
        foreach ($notifications as $notification) 
        {
            $notification->delete();
        }

        //get the role name of the logged in user 
        $logged_in_user = Admin::user();    
        $role = Administrator::find($logged_in_user->id)->roles->first()->name;
        $user = Staff::find($model->staff_id);
        $name = $user ? $user->name : null;
    
        $notificationData = [
            'approved' => [
                'message' => "Requisition by {$name} has been approved by {$role}.",
                'form_link' => "http://127.0.0.1:8000/requisitions/{$model->id}",
            ],
            'rejected' => [
                'message' => "Requisition by {$name} has been rejected by {$role}.",
                'form_link' => "http://127.0.0.1:8000/requisitions/{$model->id}",
            ],

            'halted' => [
                'message' => "Requisition by {$name} has been halted by {$role}.",
                'form_link' => "http://127.0.0.1:8000/requisitions/{$model->id}",
            ],

            'amended' => [
                'message' => "Requisition by {$name} has been amended by {$role}.",
                'form_link' => "http://127.0.0.1:8000/requisitions/{$model->id}",
            ],
        ];
        //check the admin_user_roles table to get the user_id whose role_id is 5
        $another_receiver_id = AdminRoleUser::where('role_id', 6)->first()->user_id;
    
        $user = Staff::find($model->staff_id);
        $receiver_ids = [$user->user_id, $another_receiver_id]; // Add another receiver ID here
        error_log(json_encode($receiver_ids));

        foreach ($notificationData as $status => $data) {
            if ($model->status == $status) {
                
                foreach ($receiver_ids as $receiver_id) {  // Loop through each receiver ID
                    $receiver = Administrator::find($receiver_id);
                    if ($receiver) { // Ensure the receiver exists
                        error_log('we are here now');
                        $message = str_replace('{name}', $receiver->name, $data['message']);
        
                        $notification_user = new Notification();
                        $notification_user->receiver_id = $receiver_id;
                        $notification_user->message = $message;
                        $notification_user->link = admin_url("auth/login");
                        $notification_user->form_link = $data['form_link'];
                        $notification_user->model = $model_name;
                        $notification_user->model_id = $model->id;
                        $notification_user->save();
        
                        self::sendMail($notification_user);
                    }
                }
            }
        }
        
    }
    
        
    //get notification receipients by either role or id
    public static function get_users_by_role($role_id)
    {
        $admin= Administrator::whereHas('roles', function ($query) use ($role_id) {
            $query->where('admin_role_users.role_id', $role_id);
        })->get();

        return $admin;
    }

    public static function get_users_by_id($receiver_id)
    {
        $users= Administrator::with('notifications')
            ->where('id', $receiver_id)
            ->get();

            return $users;
    }
        
    //send an email notification
    public static function sendMail($notification)
    {
        if ($notification->receiver_id != null) {
            $receivers = self::get_users_by_id($notification->receiver_id);
        } else {
            $receivers = self::get_users_by_role($notification->role_id);
        }

        if ($receivers->isEmpty()) {
            return "No receivers found."; // Return an error message
        }

        $emails = $receivers->pluck('email')->toArray();

        try {
            Mail::to($emails)->send(new LeaveRequestStatus($notification->message, $notification->link));
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error or send another notification)
            return "Email sending failed: " . $e->getMessage();
        }

        return "Email sent successfully.";
    }
       
}
