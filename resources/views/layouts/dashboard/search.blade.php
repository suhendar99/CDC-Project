{{-- Before Use This Component, Declare 'valign-center' class in this parent element --}}
@if(!isset($admin))
<i class="material-icons md-24 icon-search">search</i>
<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Barang ...">
@else
<i class="material-icons md-24 icon-search">search</i>
<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Pengguna ...">
@endif