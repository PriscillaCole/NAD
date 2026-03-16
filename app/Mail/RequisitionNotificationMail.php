<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RequisitionNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $requisition, $action, $user, $by, $comment;

    public function __construct($requisition, $action, $user, $by, $comment = null)
    {
        $this->requisition = $requisition;
        $this->action = $action;
        $this->user = $user;
        $this->by = $by;
        $this->comment = $comment;
    }

    public function build()
    {
         Log::info('RequisitionNotificationMail build method called with action: ' . $this->action);
         Log::info('RequisitionNotificationMail build method called with user: ' . $this->user);
         Log::info('RequisitionNotificationMail build method called with by: ' . $this->by);
         Log::info('RequisitionNotificationMail build method called with comment: ' . $this->comment);
        return $this->subject('Requisition ' . ucfirst($this->action))
                    ->view('emails.requisition_notification');
    }

    
}
