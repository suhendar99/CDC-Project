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
    public $bulan;
    public $month;
    public $hii;

    function __construct($awal,$akhir,$bulan,$month,$hii){
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->bulan = $bulan;
        $this->month = $month;
        $this->hii = $hii;
        $this->path = 'app.laporan.pengurus-gudang.barang-keluar.';
    }
    public function view(): View
    {
        if ($this->bulan != null && $this->month) {
            $data = StorageOut::with('user','gudang','barang')->whereRaw('MONTH(waktu) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = StorageOut::whereBetween('waktu',[$this->awal, $this->akhir])->get();
        }
        return view($this->path.'excel', compact('data'));

    }
}
