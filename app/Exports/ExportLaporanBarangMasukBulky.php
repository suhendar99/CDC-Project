<?php

namespace App\Exports;

use App\Models\StorageMasukBulky;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLaporanBarangMasukBulky implements FromView,ShouldAutoSize
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
        $this->path = 'app.laporan.gudang-bulky.barang-masuk.';
    }
    public function view(): View
    {
        if ($this->bulan != null && $this->month) {
            $data = StorageMasukBulky::with('user','bulky','barang')->whereRaw('MONTH(waktu) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = StorageMasukBulky::with('user','bulky','barang')->whereBetween('waktu',[$this->awal.' 00:00:00', $this->akhir.' 23:59:59'])->get();
        }
        return view($this->path.'excel', compact('data'));

    }
}
