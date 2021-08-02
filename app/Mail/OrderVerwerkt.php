<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderVerwerkt extends Mailable
{
    use Queueable, SerializesModels;

    public $orderID;
    public $producten;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderID, $producten)
    {
        $this->orderID = $orderID;
        $this->producten = $producten;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('madebyfelisa@gmail.com')
                    ->markdown('bestellingVerwerkt')
                    ->attachFromStorage('Terugstuur formulier.pdf')
                    ->with(['orderID' => $this->orderID, 'producten' => $this->producten]);
    }
}
