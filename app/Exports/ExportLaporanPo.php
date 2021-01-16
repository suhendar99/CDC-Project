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

    function __construct($awal,$akhir,$date,$item){
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->date = $date;
        $this->item = $item;
        $this->path = 'app.laporan.pengurus-gudang.po.';
    }
    public function view(): View
    {
        $data = Po::whereBetween('created_at',[$this->awal, $this->akhir])->get();
        return view($this->path.'excel', compact('data'));
    }
}
