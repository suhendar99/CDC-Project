<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayLaterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nomor_pemesanan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nomor_pemesanan)
    {
        $this->nomor_pemesanan = $nomor_pemesanan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('app.mail.send_hutang');
    }
}
