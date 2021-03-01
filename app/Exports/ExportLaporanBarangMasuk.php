<?php

namespace App\Exports;

use App\Models\StorageIn;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;

class ExportLaporanBarangMasuk implements FromView,ShouldAutoSize
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
        $this->path = 'app.laporan.pengurus-gudang.barang-masuk.';
    }
    public function view(): View
    {
        $gudang_saya = [];
        foreach(Auth::user()->pengurusGudang->gudang as $gudang){
            $gudang_saya[] = $gudang->id;
        }
        if ($this->bulan != null && $this->month) {
            $data = StorageIn::whereIn('gudang_id',$gudang_saya)->with('user','gudang','barangBulky')->whereRaw('MONTH(waktu) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = StorageIn::whereIn('gudang_id',$gudang_saya)->whereBetween('waktu',[$this->awal, $this->akhir])->get();
        }
        return view($this->path.'excel', compact('data'));

    }
}
