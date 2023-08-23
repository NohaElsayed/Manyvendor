<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVendorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $password_generate = '';

    public function __construct($password_generate)
    {
        return $this->password_generate =  $password_generate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $password_generate = '';
        return $this->view('backend.mail.new_vendor_mail',compact('password_generate'));
    }
}
