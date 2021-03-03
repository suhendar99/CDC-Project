<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengembalianBarangMail extends Mailable
{
    use Queueable, SerializesModels;

    public $no_kwitansi;
    public $nama_barang;
    public $jumlah;
    public $satuan;
    public $penjual;
    public $pembeli;
    public $waktu;
    public $keterangan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($no_kwitansi, $nama_barang, $jumlah, $satuan, $penjual, $pembeli, $waktu, $keterangan)
    {
        $this->no_kwitansi = $no_kwitansi;
        $this->nama_barang = $nama_barang;
        $this->jumlah = $jumlah;
        $this->satuan = $satuan;
        $this->penjual = $penjual;
        $this->pembeli = $pembeli;
        $this->waktu = $waktu;
        $this->keterangan = $keterangan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('app.mail.send_pengembalian_barang');
    }
}
