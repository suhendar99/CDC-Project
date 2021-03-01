<?php

namespace App\Exports;

use App\Models\StorageMasukBulky;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;

class ExportLaporanBarangMasukBulky implements FromView,ShouldAutoSize
{
    use Exportable;

    public $data;

    function __construct($data){
        $this->data = $data;
        $this->path = 'app.laporan.gudang-bulky.barang-masuk.';
    }
    public function view(): View
    {
        $data = $this->data;
        return view($this->path.'excel', compact('data'));

    }
}
