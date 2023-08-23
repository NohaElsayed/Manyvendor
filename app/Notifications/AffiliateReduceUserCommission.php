<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AffiliateReduceUserCommission extends Notification
{
    use Queueable;

    private $order_amount;
    private $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_amount, $amount)
    {
        $this->order_amount = $order_amount;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Affiliate Commission Deducted')
                ->line('Your commission of a product has been deducted from your balance. The probable reason could be cancellation of that order.')
                ->line('Product Price: '.$this->order_amount.', Your Commission was: '. $this->amount)
                ->action(env('APP_NAME'), env('APP_URL'))
                ->line('Thank you for your service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
