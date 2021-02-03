@if (Auth::user()->pelanggan_id != null || Auth::user()->pembeli_id != null)
@if (Auth::user() == true)
<div id="cart-button" class=" active">
	<div class="card bg-my-warning pointer rad-mod" onclick="showCart()">
		<div class="card-body">
			<center>
				<i class="material-icons md-36">shopping_cart</i><br>
				<div class="card d-flex justify-content-center py-1 px-2">
					<span class=" text-dark"> <span id="itemCount">{{$barangKeranjang->count()}}</span> Item </span>
				</div>
			</center>
		</div>
	</div>
</div>
<div id="cart-card">
	<div class="card cart-card rad-mod">
		<div class="card-header d-flex justify-content-between valign-center bg-my-warning">
			<span class=" card-title"> Keranjang Saya</span><span class="close pointer" onclick="hideCart()"><i class=" material-icons md-12">close</i></span>
		</div>
		<div class="card-body">
            @forelse ($barangKeranjang as $key => $value)
            <div class="cart-list">
                <div class="form-check">
                    <input class="form-check-input position-static" type="checkbox" value="{{$value->id}}" id="checkId" value="option1" aria-label="...">
                </div>
				<div class="row">
					@foreach ($value->keranjangItem as $key => $value)
                        <div class="col-6">
                            @if(count($value->barang->foto) < 1 || $value->barang->foto == null)
                            <img src="{!! asset('/images/image-not-found.jpg') !!}" style="height: 100px;">
                            @else
                            {{-- {{dd($value)}} --}}
                            <img src="{{asset($value->barang->foto[0]->foto)}}">
                            @endif
                        </div>
                    <div class="col-6">
                        <span class="product-name">{{$value->barang->nama_barang}}, {{$value->jumlah_barang}} {{$value->satuan}}</span>
						<span class="product-price">Rp. {{ number_format($value->harga,0,',','.')}}</span>
						<div id="qty" class=" valign-center mt-1">
                            <i class=" material-icons pointer px-1 py-0" onclick=" decreaseOne()">remove_circle_outline</i>
							{{-- <div class=" qty-count"> 1</div> --}}
							<input type="text" name="qty" value="1" min="1" class="form-control" width="100">
							<i class=" material-icons pointer px-1 py-0" onclick=" increaseOne()">add_circle_outline</i>
						</div>
					</div>
                    @endforeach
				</div>
				<hr>
			</div>
            <div id="cart-footer">
                <div class=" w-100">
                    <form action="#" name="postPemesanan" name="keranjang" method="post">
                        @csrf
                        {{-- <input type="hidden" name="penerima_po" id="penerima" value="{{$data->storageIn->gudang->pemilik}}">
                        <input type="hidden" name="nama_pemesan" id="pemesan" value="{{Auth::user()->pelanggan->nama}}">
                        <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pelanggan_id}}">
                        <input type="hidden" name="pengurus_gudang_id" value="{{$data->storageIn->gudang->user->pengurus_gudang_id}}">
                        <input type="hidden" name="harga" id="harga" value="{{$data->storageIn->storage->harga_barang}}">
                        <input type="hidden" name="nama_barang" value="{{$data->storageIn->barang->nama_barang}}">
                        <input type="hidden" name="satuan" value="{{$data->storageIn->satuan}}">
                        <input type="hidden" name="barangKode" value="{{$data->storageIn->barang->kode_barang}}"> --}}
                        <button type="button" class="btn btn-sm bg-my-warning btn-block">Checkout</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="row">
                <center><div class="text-danger">Tidak ada barang di keranjang</div></center>
            </div>
            @endforelse
		</div>
	</div>
</div>
@else
<div id="cart-button" class=" active">
	<div class="card bg-my-warning pointer rad-mod" onclick="showCart()">
		<div class="card-body">
			<center>
				<i class="material-icons md-36">shopping_cart</i><br>
				<div class="card d-flex justify-content-center py-1 px-2">
					<span class=" text-dark"> <span id="itemCount">0</span> Item </span>
				</div>
			</center>
		</div>
	</div>
</div>
<div id="cart-card">
	<div class="card cart-card rad-mod">
		<div class="card-header d-flex justify-content-between valign-center bg-my-warning">
			<span class=" card-title"> Keranjang Saya</span><span class="close pointer" onclick="hideCart()"><i class=" material-icons md-12">close</i></span>
		</div>
		<div class="card-body d-flex justify-content-between valign-center">
			<div class="cart-list">
				<div class="row">
					<center><div class="text-danger">Mohon Login terlebih dahulu untuk mengetahui keranjang</div></center>
				</div>
				<hr>
			</div>
			<div id="cart-footer">
				{{-- <div class=" w-100">
					<a href="#" class=" btn btn-warning bg-my-warning btn-block">
						Checkout
					</a>
				</div> --}}
			</div>
		</div>
	</div>
</div>
@endif
@endif
@push('script')
    <script>
        const value = document.querySelector("#checkId");
        console.log(value[0]);
        if (value.checked) {
            var id = $("input[type='checkbox']").val();
            console.log(id);
        }
    </script>
@endpush
