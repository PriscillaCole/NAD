<?php

namespace App\Models;

use App\Mail\AccountabilityNotificationMail;
use App\Mail\LeaveRequestStatus;
use App\Mail\RequisitionNotificationMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\Mail;
use App\Models\Staff;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $fillable = 
    [
        'receiver_id',
        'role_id',
        'message',
        'form_link',
        'link',
        'model',
        'model_id',
        'deleted_at'
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
        
    //function to send notifications after creation
    public static function send_notification($model, $model_name, $entity)
    {
        if($model_name == 'Program'){
            
            $user = Staff::where('user_id', $model->user_id)->first();
            $name = $user ? $user->name : null;
            Log::info($user);
            // $receiver = Notification::get_users_by_id(5);
            
            // Log::info('Requisition ID: ' . $model);
        
            // Check if $entity is a string
            if (is_string($entity)) {
                // foreach ($receiver as $user) {
                    $notification = new Notification();
                    $notification->role_id = null;
                    $notification->receiver_id = $user->user_id;
                    $notification->message = "New {$model_name} has been assigned to " . $name .' ';
                    $notification->link = admin_url("auth/login"); //budgets/62/edit
                    $notification->form_link = admin_url("budgets/{$model->id}/edit");
                    $notification->model = $model_name;
                    $notification->model_id = $model->id;
                    $notification->save();
                
                    self::sendMail($notification);
                // }
            }
            
        } else{
            Log::info($model_name);

            $user = Staff::find($model->staff_id);
            $name = $user ? $user->name : null;
            $receiver = Notification::get_users_by_role(5);
            
            
            // Log::info('Requisition ID: ' . $model);
        
            // Check if $entity is a string
            if (is_string($entity)) {
                foreach ($receiver as $user) {
                    $notification = new Notification();
                    $notification->role_id = 5;
                    $notification->receiver_id = $user->id;
                    $notification->message = "New {$model_name} has been submitted by" . $name .' ';
                    $notification->link = admin_url("auth/login");
                    $notification->form_link = admin_url("{$entity}/{$model->id}");
                    $notification->model = $model_name;
                    $notification->model_id = $model->id;
                    $notification->save();
                
                    self::sendMail($notification);
                }
            }
            if($model_name == 'Requisition'){
                
                $action = 'created';
                Log::info('Requisition created: ');    
                Mail::to($user->email)->send(new RequisitionNotificationMail($model, $action, $user, $name));
            }
        }
    }

    public static function Notify_Admin($model, $model_name, $entity, $receiver)
    {
        $user = Staff::find($model->staff_id);
        $name = $user ? $user->name : null;
        // $receiver = Notification::get_users_by_role(8);
        
        
        // Log::info('Requisition ID: ' . $model);
       
        // Check if $entity is a string
        if (is_string($entity)) {
            foreach ($receiver as $user) {
                $notification = new Notification();
                $notification->role_id = 5;
                $notification->receiver_id = $user->id;
                $notification->message = "New {$entity} has been submitted by" . $name .' ';
                $notification->link = admin_url("auth/login");
                $notification->form_link = admin_url("{$entity}/{$model->id}");
                $notification->model = $model_name;
                $notification->model_id = $model->id;
                $notification->save();
            
                self::sendMail($notification);
            }
            if($model_name == 'Accountability'){
                Log::info($user->email);
                $action = 'submitted';
                Mail::to($user->email)->send(new AccountabilityNotificationMail($model, $action, $user, $name));
            }
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
         Log::info('amend........' . $name);
    
        $notificationData = [
            'approved' => [
                'message' => "Requisition by {$name} has been approved by {$role}.",
                'form_link' => env('APP_URL') . "/requisitions/{$model->id}",
            ],
            'accepted' => [
                'message' => "Requisition by {$name} has been approved by {$role}.",
                'form_link' => env('APP_URL') . "/requisitions/{$model->id}",
            ],
            'rejected' => [
                'message' => "Requisition by {$name} has been rejected by {$role}.",
                'form_link' => env('APP_URL') . "/requisitions/{$model->id}",
            ],

            'halted' => [
                'message' => "Requisition by {$name} has been halted by {$role}.",
                'form_link' => env('APP_URL') . "/requisitions/{$model->id}",
            ],
            'amend' => [
                'message' => "Requisition by {$name} has a query from {$role}.",
                'form_link' => env('APP_URL') . "/accountabilities/{$model->id}",
            ],

            'amended' => [
                'message' => "Requisition by {$name} has been amended by {$role}.",
                'form_link' => env('APP_URL') . "/requisitions/{$model->id}",
            ],
            'closed' => [
                'message' => "Accountability by {$name} has been closed by {$role}.",
                'form_link' => env('APP_URL') . "/accountabilities/{$model->id}",
            ],
        ];
        $user = Staff::find($model->staff_id);

        foreach ($notificationData as $status => $data) {
            if ($model->status == $status) {
                $receiver_ids = [$user->user_id];

                if ($status === 'amended') {
                    $finance_receiver_ids = self::get_users_by_role(5)
                        ->pluck('id')
                        ->toArray();

                    $amend_comment = Comments::where('requisition_id', $model->id)
                        ->where('status', 'amend')
                        ->oldest('id')
                        ->first();

                    $amend_requester_id = null;
                    if ($amend_comment) {
                        $amend_requester = Staff::find($amend_comment->commented_by);
                        $amend_requester_id = $amend_requester ? $amend_requester->user_id : null;
                    }

                    $receiver_ids = array_values(array_unique(array_filter(array_merge(
                        $finance_receiver_ids,
                        [$amend_requester_id]
                    ))));
                } else {
                    //check the admin_user_roles table to get the user_id whose role_id is 6
                    $another_receiver_id = AdminRoleUser::where('role_id', 6)->first()->user_id;
                    $receiver_ids[] = $another_receiver_id;
                    $receiver_ids = array_values(array_unique(array_filter($receiver_ids)));
                }

                error_log(json_encode($receiver_ids));
                
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
                    //hildahnantabo@gmail.com
                if($model_name == 'Requisition'){
                    Log::info($user);
                    // Pull the latest reviewer comment for this requisition/status from comments table.
                    $comment = Comments::where('requisition_id', $model->id)
                        ->where('status', $model->status)
                        ->latest('id')
                        ->value('comment');

                    if (empty($comment)) {
                        $comment = Comments::where('requisition_id', $model->id)
                            ->latest('id')
                            ->value('comment') ?: 'No comments';
                    }

                    if ($status === 'amended') {
                        $mail_receivers = Administrator::whereIn('id', $receiver_ids)->get();

                        foreach ($mail_receivers as $mail_receiver) {
                            if (!empty($mail_receiver->email)) {
                                Mail::to($mail_receiver->email)->send(new RequisitionNotificationMail($model, $status, $mail_receiver, $role, $comment));
                            }
                        }
                    } else {
                        Mail::to($user->email)->send(new RequisitionNotificationMail($model, $status, $user, $role, $comment));
                    }
                }
                if($model_name == 'Accountability'){
                    Log::info($user);
                    Mail::to($user->email)->send(new AccountabilityNotificationMail($model, $status, $user, $role));
                }
            }
        }
        
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
            Log::info('Sending email to: ' . implode(', ', $emails));
            // Mail::to($emails)->send(new LeaveRequestStatus($notification->message, $notification->link));
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error or send another notification)
            Log::error('Email sending failed: ' . $e->getMessage());
            return "Email sending failed: " . $e->getMessage();
        }

        return "Email sent successfully.";
    }

    public static function deleteNotification($notification)
    {
        return self::find($notification)->delete();
        
    }
       
}
