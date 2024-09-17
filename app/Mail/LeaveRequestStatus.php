<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestStatus extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $link)
    {
        $this->message = $message;
        $this->link = $link;
    }

    /**
     * Build the message.
     */

    public function build()
    {
        return $this->markdown('emails.leave_request_notifications')
                    ->with([
                        'message' => $this->message,
                        'link' => $this->link,
                    ]);
    }
}
