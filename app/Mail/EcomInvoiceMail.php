<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EcomInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name = '';
    public $email = '';
    public $invoice_number = '';
    public $order = '';

    public function __construct($name, $email ,$invoice_number, $order)
    {
        $this->name = $name;
        $this->email = $email;
        $this->invoice_number = $invoice_number;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = '';
        $email = '';
        $invoice_number = '';
        $order = '';

//        $invoice_path = $this->invoice_number . '.pdf';
        return $this->view('frontend.checkout.ecom_attachment',compact('name','order', 'email', 'invoice_number'))->subject('Invoice Mail'); //TODO
//        ->attach(public_path('invoices/' . $invoice_path));
    }
}
