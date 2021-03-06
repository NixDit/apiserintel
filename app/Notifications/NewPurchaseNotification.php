<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Kutia\Larafirebase\Services\Larafirebase;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use Illuminate\Notifications\Messages\MailMessage;


class NewPurchaseNotification extends Notification
{
    use Queueable;
    
    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $data )
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    /**
     * Get the firebase representation of the notification.
     */
    public function toFirebase($notifiable)
    {

        $tokens = $notifiable->devices()->pluck('token')->toArray();
        $total = number_format((float)$this->data->total, 2, '.', '');
        $types = ['Prepago', 'Pagado', 'Postpago'];
        $selectedType = $types[ $this->data->type -1 ];

        return ( new Larafirebase )
        ->fromRaw([
            'registration_ids' => $tokens,
            'data' => [
                'type' => 'sale',
                'sale_id' => $this->data->id,
            ],
            'notification' => [
                'title' => 'Nueva venta',
                'body' => "Una venta ha sido realizada al cliente {$this->data->customer->clientInformation->business_name} por el vendedor {$this->data->seller->fullName()} con un total de \${$total} con el tipo de venta: {$selectedType}"
            ]
        ])->send();
    }
    
}
