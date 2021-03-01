<?php

namespace App\Exports;

use App\Models\StorageKeluarPemasok;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;

class ExportLaporanPenjualanPemasok implements FromView,ShouldAutoSize
{
    use Exportable;

    public $awal;
    public $akhir;
    public $bulan;
    public $month;
    public $hii;

    function __construct($data){
        $this->data = $data;
        $this->path = 'app.laporan.pemasok.penjualan.';
    }
    public function view(): View
    {
        $data = $this->data;
        return view($this->path.'excel', compact('data'));

    }
}
