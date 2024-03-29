<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $ticketId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticketId, $name)
    {
        $this->ticketId = $ticketId;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.feedbackNotification', ['ticketId' => $this->ticketId, 'name' => $this->name]);
    }
}
