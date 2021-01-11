@php

    if(!isset(Auth::user()->pelanggan_id) && !isset(Auth::user()->karyawan_id) && !isset(Auth::user()->bank_id) && !isset(Auth::user()->pemasok_id) && !isset(Auth::user()->pengurus_gudang_id)) {
        $admin = true;
    } elseif (isset(Auth::user()->karyawan_id)) {
        $karyawan = true;
    } elseif (isset(Auth::user()->bank_id)) {
        $bank = true;
    } elseif (isset(Auth::user()->pemasok_id)) {
        $pemasok = true;
    } elseif (isset(Auth::user()->pelanggan_id)) {
        $pelanggan = true;
    } elseif (isset(Auth::user()->pengurus_gudang_id)) {
        $pengurusGudang = true;
    }

        

    $set = App\Models\PengaturanAplikasi::find(1);
    
@endphp