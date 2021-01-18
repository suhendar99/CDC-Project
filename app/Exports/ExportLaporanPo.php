<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLaporanPo implements FromView,ShouldAutoSize
{
    use Exportable;

    public $awal;
    public $akhir;
    public $date;
    public $item;
    public $bulan;
    public $month;
    public $hii;

    function __construct($awal,$akhir,$date,$item,$bulan,$month,$hii){
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->date = $date;
        $this->item = $item;
        $this->bulan = $bulan;
        $this->month = $month;
        $this->hii = $hii;
        $this->path = 'app.laporan.pengurus-gudang.po.';
    }
    public function view(): View
    {
        if ($this->bulan != null && $this->month) {
            $data = Po::with('po_item','gudang','piutang')->whereRaw('MONTH(created_at) = '.$this->hii)->get();
        } elseif ($this->awal != null && $this->akhir != null) {
            $data = Po::whereBetween('created_at',[$this->awal, $this->akhir])->get();
        }
        return view($this->path.'excel', compact('data'));
    }
}
