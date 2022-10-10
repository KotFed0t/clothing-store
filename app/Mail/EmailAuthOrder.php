<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAuthOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $code;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $order)
    {
        $this->code = $code;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.emailAuthOrder', ['code' => $this->code, 'order' => $this->order]);
    }
}
