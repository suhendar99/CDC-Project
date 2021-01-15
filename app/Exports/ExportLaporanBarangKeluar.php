<?php

namespace App\Exports;

use App\Models\StorageOut;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLaporanBarangKeluar implements FromView,ShouldAutoSize
{
    use Exportable;

    public $awal;
    public $akhir;

    function __construct($awal,$akhir){
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->path = 'app.laporan.pengurus-gudang.barang-keluar.';
    }
    public function view(): View
    {
        $data = StorageOut::whereBetween('waktu',[$this->awal, $this->akhir])->get();
        return view($this->path.'excel', compact('data'));

    }
}
