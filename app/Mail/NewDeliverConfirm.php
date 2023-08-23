<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDeliverConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $password = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password)
    {
      return  $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $password = '';
        return $this->view('backend.mail.new_deliver_mail',compact('password'))->subject("New Delivery User");
    }
}
