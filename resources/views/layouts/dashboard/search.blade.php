{{-- Before Use This Component, Declare 'valign-center' class in this parent element --}}
@if(!isset($admin))
<form action="{{route('search.barang')}}" method="post">
	@csrf
	<i class="material-icons md-24 icon-search">search</i>
	
	@if(isset($shop))
	<input type="hidden" name="page" value="shop">
	@elseif(isset($dashboard))
	<input type="hidden" name="page" value="dashboard">
	@else
	<input type="hidden" name="page" value="any">
	@endif

	<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Barang ...">
</form>
@else
<i class="material-icons md-24 icon-search">search</i>
<input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Pengguna ...">
@endif