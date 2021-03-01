<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GudangBulky;

class OrderingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kode;
    public $pemesan;
    public $barang;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($kode, $pemesan, $barang)
    {
        $this->kode = $kode;
        $this->pemesan = $pemesan;
        $this->barang = $barang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('app.mail.send_ordering');
    }
}
