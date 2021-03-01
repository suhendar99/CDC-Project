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

    function __construct($awal,$akhir,$bulan,$month,$hii){
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->bulan = $bulan;
        $this->month = $month;
        $this->hii = $hii;
        $this->path = 'app.laporan.pemasok.penjualan.';
    }
    public function view(): View
    {
        if ($this->bulan != null && $this->month) {
            $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok->id)->with('user','pemasok','barang')->whereRaw('MONTH(waktu) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok->id)->whereBetween('waktu',[$this->awal, $this->akhir])->get();
        }
        return view($this->path.'excel', compact('data'));

    }
}
