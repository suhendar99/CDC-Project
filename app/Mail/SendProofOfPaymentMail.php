<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendProofOfPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $waktu;
    public $type;
    public $pesanan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $type, $waktu, $pesanan)
    {
        $this->data = $data;
        $this->type = $type;
        $this->waktu = $waktu;
        $this->pesanan = $pesanan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mime = explode("/", $this->type);
        return $this->view('app.mail.send_payment')
        ->attach(public_path($this->data), [
            'as' => "bukti-pembayaran.".$mime[1],
            'mime' => $this->type
        ]);
    }
}
