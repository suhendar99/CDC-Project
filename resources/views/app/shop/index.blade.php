@php
	$shop = true;
	$cart = true;
	$nomore = true;
	// dd($barang);
	// $card = [1,1,1,1,1,1,1];
  // $category = array(
  // 	['icon'=>'grass','nama'=>'Pertanian'],
  // 	['icon'=>'grass','nama'=>'Perkebunan'],
  // 	['icon'=>'set_meal','nama'=>'Perikanan'],
  // 	['icon'=>'flutter_dash','nama'=>'Peternakan'],
  // 	['icon'=>'bento','nama'=>'Makanan Kaleng'],
  // 	['icon'=>'kitchen','nama'=>'Makanan Beku'],
  // 	['icon'=>'free_breakfast','nama'=>'Minuman'],
  // 	['icon'=>'rice_bowl','nama'=>'Makanan Instan'],
  // );
	$banner = array(
		['path'=>'images/Banner1.png'],
		['path'=>'images/Banner2.png'],
		['path'=>'images/Banner3.png'],
		['path'=>'images/Banner4.png'],
	);
@endphp
@push('style')
<style type="text/css">
	.img-banner{
		height: 350px;
		object-fit: cover;
	}
</style>
@endpush
@extends('layouts.dashboard.header')

@section('content')
<div class="row">
	<div class="col-md-12 mb-4">
		<div id="carouselExampleIndicators" class="carousel slide shadow" data-ride="carousel">
		  <ol class="carousel-indicators">
		  	@foreach($banner as $key => $b)
		    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="{{($key == 0 ) ? 'active' : false}}"></li>
		    @endforeach
		  </ol>
		  <div class="carousel-inner">
		  	@foreach($banner as $key => $b)
		    <div class="carousel-item {{($key == 0 ) ? 'active' : false}}">
		      <img class="d-block w-100 img-banner" src="{{asset($b['path'])}}" alt="{{$key+1}} slide">
		    </div>
		    @endforeach
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>
<div class="row mt-2 mb-4">
	<div class="col-md-2 col-4">
		<button type="button" id="filter" class="btn bg-my-primary btn-sm btn-block valign-center justify-content-center px-2"><i class="material-icons p-0">filter_alt</i> Filter</button>
	</div>
	<div class="col-md-10 col-8">
		<form action="{{route('home.search.barang')}}" method="get" style="width: 100%;">
            <input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Barang ...">
        </form>
	</div>
</div>
@if (Auth::user()->pelanggan_id != null)
<div class="row" id="product-list">
	@forelse($barang as $b)
	<div class="col-md-3 col-4">
		{{-- <a href="{{route('shop.detail',$b->id)}}"> --}}
			<div class="card item-card">
				@if(count($b->barang->foto) < 1 || $b->barang->foto == null)
				<img src="{!! asset('/images/image-not-found.jpg') !!}">
				@else
				{{-- {{dd($b)}} --}}
				<img src="{{asset($b->barang->foto[0]->foto)}}">
				@endif
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<span class="badge badge-pill badge-danger bg-my-warning">Terlaris</span>
							<span class="badge badge-pill badge-primary bg-my-primary">{{$b->barang->kategori->nama}}</span>
							<span class="badge badge-pill badge-primary bg-my-danger">130Km</span>
						</div>
						<div class="col-12">
							<span class="product-name">{{$b->barang->nama_barang}} (
                                @if ($b->jumlah == 0)
                                    Habis
                                @else
                                    {{$b->jumlah}} {{$b->satuan}}
                                @endif
                            )</span>
						</div>
						<div class="col-12">
							<span class="product-name">Dari {{$b->gudang->nama}} <br /> Desa {{$b->gudang->desa->nama}}</span>
						</div>
						<div class="col-12">
							<span class="product-price">Rp. {{ number_format($b->harga_barang,0,',','.')}},- Per-{{ $b->satuan }}</span>
						</div>
                        {{-- <div class="float-right" style="position: absolute; right: 1rem; bottom: 3rem;">
                            <div class="dropdown">
                                <a href="#" title="Menu" class="dropdown-toggle p-2" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropmenu">
									@if ($b->jumlah != 0)
                                    <a href="{{route('shop.pesanan',$b->id)}}" class="dropdown-item">Pesan</a>
                                    <a class="dropdown-item" href="#" onclick="keranjang({{ $b->id }})">+ Keranjang</a>
                        			@endif
                                    <a href="https://api.whatsapp.com/send?phone=+62{{ intval($b->gudang->user->pengurusGudang->telepon) }}" target="_blank" class="dropdown-item" >Chat</a>
                                </div>
                            </div>
                        </div> --}}
					</div>
                    <div class="row mt-3">
                        <div class="col-12">
                        	<a href="{{route('shop.pesanan',$b->id)}}" class="btn btn-sm btn-success btn-block">Pesan</a>
                        </div>
                        {{-- <div class="col">
                        	<a href="https://api.whatsapp.com/send?phone=+62{{ intval($b->pelanggan->telepon) }}" target="_blank" class="btn btn-sm btn-success" >Chat</a>
                        </div> --}}
					</div>
					{{-- <button type="button" class="btn btn-primary btn-sm mx-1">Keranjang</button>
					<button type="button" class="btn btn-warning btn-sm mx-1">Beli</button> --}}
				</div>
			</div>
		{{-- </a> --}}
	</div>
	@empty
	<div class="col-md-12 d-flex justify-content-center">
		<center>
			<span class="oops"></span>
			<p class="not-found">Maaf, Barang {{$else}} tidak ditemukan. Mohon Cari Kembali</p>
		</center>
	</div>
	@endforelse
</div>
@elseif(Auth::user()->pembeli_id != null)
<div class="row" id="product-list">
	@forelse($barang as $b)
	<div class="col-md-3 col-4">
		{{-- <a href="{{route('shop.detail',$b->id)}}"> --}}
			<div class="card item-card">
				@if(count($b->storageOut->barang->foto) < 1 || $b->storageOut->barang->foto == null)
				<img src="{!! asset('/images/image-not-found.jpg') !!}">
				@else
				{{-- {{dd($b)}} --}}
				<img src="{{asset($b->storageOut->barang->foto[0]->foto)}}">
				@endif
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<span class="badge badge-pill badge-danger bg-my-warning">Terlaris</span>
							<span class="badge badge-pill badge-primary bg-my-primary">{{$b->storageOut->barang->kategori->nama}}</span>
							<span class="badge badge-pill badge-primary bg-my-danger">130Km</span>
						</div>
						<div class="col-12">
							<span class="product-name">{{$b->storageOut->barang->nama_barang}} (
                                @if ($b->jumlah == 0)
                                    Habis
                                @else
                                    {{$b->jumlah}} {{$b->satuan}}
                                @endif
                            )</span>
						</div>
						<div class="col-12">
							<span class="product-name">Dari {{$b->pelanggan->nama}} <br /> Desa {{$b->pelanggan->desa->nama}}</span>
						</div>
						<div class="col-12">
							<span class="product-price">Rp. {{ number_format($b->harga_barang,0,',','.')}},- Per-{{ $b->satuan }}</span>
						</div>
                        {{-- <div class="float-right" style="position: absolute; right: 1rem; bottom: 3rem;">
                            <div class="dropdown">
                                <a href="#" title="Menu" class="dropdown-toggle p-2" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropmenu">
                        			@if ($b->jumlah != 0)
                                    <a href="{{route('shop.pesanan',$b->id)}}" class="dropdown-item">Pesan</a> --}}
                                    {{-- <a class="dropdown-item" href="#" onclick="keranjang({{ $b->id }})">+ Keranjang</a> --}}
                        			{{-- @endif
                                    <a href="https://api.whatsapp.com/send?phone=+62{{ intval($b->pelanggan->telepon) }}" target="_blank" class="dropdown-item" >Chat</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col">
                        	<a href="{{route('shop.pesanan',$b->id)}}" class="btn btn-sm btn-success">Pesan</a>
                        </div>
                        <div class="col">
                        	<a href="https://api.whatsapp.com/send?phone=+62{{ intval($b->pelanggan->telepon) }}" target="_blank" class="btn btn-sm btn-success" >Chat</a>
                        </div>
					</div>
					{{-- <button type="button" class="btn btn-primary btn-sm mx-1">Keranjang</button>
					<button type="button" class="btn btn-warning btn-sm mx-1">Beli</button> --}}
				</div>
			</div>
		{{-- </a> --}}
	</div>
	@empty
	<div class="col-md-12 d-flex justify-content-center">
		<center>
			<span class="oops"></span>
			<p class="not-found">Maaf, Barang {{$else}} tidak ditemukan. Mohon Cari Kembali</p>
		</center>
	</div>
	@endforelse
</div>
@else
<div class="row" id="product-list">
	@forelse($barang as $b)
	<div class="col-md-3 col-4">
			<div class="card item-card">
				@if(count($b->barang->foto) < 1 || $b->barang->foto == null)
				<img src="{!! asset('/images/image-not-found.jpg') !!}">
				@else
				<img src="{{asset($b->barang->foto[0]->foto)}}">
				@endif
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<span class="badge badge-pill badge-danger bg-my-warning">Terlaris</span>
							<span class="badge badge-pill badge-primary bg-my-primary">{{$b->barang->kategori->nama}}</span>
							<span class="badge badge-pill badge-primary bg-my-danger">130Km</span>
						</div>
						<div class="col-12">
							<span class="product-name">{{$b->barang->nama_barang}} ({{$b->jumlah}} {{$b->satuan}})</span>
						</div>
						<div class="col-12">
							<span class="product-name">Dari {{$b->bulky->nama}} <br /> Desa {{$b->bulky->desa->nama}}</span>
						</div>
						<div class="col-12">
							<span class="product-price">Rp. {{ number_format($b->harga_barang,0,',','.')}}, Per-{{ $b->satuan }}</span>
						</div>{{-- 
                        <div class="float-right" style="position: absolute; right: 1rem; bottom: 3rem;">
                            <div class="dropdown">
                                <a href="#" title="Menu" class="dropdown-toggle p-2" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropmenu">
                                    <a href="{{route('shop.pesanan',$b->id)}}" class="dropdown-item">Pesan</a>
                                </div>
                            </div>
                        </div> --}}
					</div>
                    <div class="row mt-3">
                        <div class="col-12">
                        	<a href="{{route('shop.pesanan',$b->id)}}" class="btn btn-sm btn-success btn-block">Pesan</a>
                        </div>
                        {{-- <div class="col">
                        	<a href="https://api.whatsapp.com/send?phone=+62{{ intval($b->pelanggan->telepon) }}" target="_blank" class="btn btn-sm btn-success" >Chat</a>
                        </div> --}}
					</div>
				</div>
			</div>
	</div>
	@empty
	<div class="col-md-12 d-flex justify-content-center">
		<center>
			<span class="oops"></span>
			<p class="not-found">Maaf, Barang {{$else}} tidak ditemukan. Mohon Cari Kembali</p>
		</center>
	</div>
	@endforelse
</div>
@endif
@if(count($barang) >= 1)
	@if(!isset($nomore))
	<div class="row my-4">
		<div class="col-md-12 col-sm-6 d-flex justify-content-center">
			<button type="button" class="btn btn-outline-primary">Lebih Banyak</button>
		</div>
	</div>
	@endif
@endif
@endsection
