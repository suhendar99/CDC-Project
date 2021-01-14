{{-- Before Use This Component, Declare 'valign-center' class in this parent element --}}
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
@endphp
{{-- @if(!isset($admin)) --}}
<form action="{{route('search.barang')}}" method="post" style="width: 100%;">
	@csrf
	<i class="material-icons md-24 icon-search">search</i>
	
	@if(isset($shop))
	<input type="hidden" name="page" value="shop">
	@elseif(isset($dashboard))
	{{-- {{dd($dashboard)}} --}}
	<input type="hidden" name="page" value="dashboard">
	@elseif(isset($pengurusGudang))
	<input type="hidden" name="page" value="pengurus">
	@elseif(isset($pemasok))
	{{-- {{dd($pemasok)}} --}}
	<input type="hidden" name="page" value="pemasok">
	@else
	{{-- {{dd($pemasok)}} --}}
	<input type="hidden" name="page" value="any">
	@endif

	<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Barang ...">
</form>
{{-- @else
<i class="material-icons md-24 icon-search">search</i>
<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Pengguna ...">
@endif --}}