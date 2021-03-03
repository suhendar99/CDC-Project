<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportPiutangRetail implements FromView,ShouldAutoSize
{
    use Exportable;

    public $data;

    function __construct($data){
        $this->data = $data;
        $this->path = 'app.data-master.piutang-bulky.masuk-retail.';
        $this->pathAuthRetail = 'app.data-master.piutangOut.';
    }
    public function view(): View
    {
        $data = $this->data;
        if (Auth::user()->pengurus_gudang_id != null) {
            return view($this->path.'excel', compact('data'));
        } elseif (Auth::user()->pengurus_gudang_bulky_id != null) {
            return view($this->pathAuthRetail.'excel', compact('data'));
        }
    }
}
