<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequisitionNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $requisition, $action, $user, $by;

    public function __construct($requisition, $action, $user, $by)
    {
        $this->requisition = $requisition;
        $this->action = $action;
        $this->user = $user;
        $this->by = $by;
    }

    public function build()
    {
        return $this->subject('Requisition ' . ucfirst($this->action))
                    ->view('emails.requisition_notification');
    }

    
}
