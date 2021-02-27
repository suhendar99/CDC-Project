<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;

class ExportLaporanStokPemasok implements FromView,ShouldAutoSize
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
        $this->path = 'app.laporan.pemasok.stok.';
    }
    public function view(): View
    {
        if ($this->bulan != null && $this->month) {
            $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->with('pemasok')->whereRaw('MONTH(created_at) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->whereBetween('created_at',[$this->awal, $this->akhir])->get();
        }
        return view($this->path.'excel', compact('data'));

    }
}
