<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountabilityNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $accountability, $action, $user, $by;

    public function __construct($accountability, $action, $user, $by)
    {
        $this->accountability = $accountability;
        $this->action = $action;
        $this->user = $user;
        $this->by = $by;
    }

    public function build()
    {
        return $this->subject('Accountability ' . ucfirst($this->action))
                    ->view('emails.accountability_email');
    }

    
}
