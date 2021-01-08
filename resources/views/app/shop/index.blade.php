@php
	$shop = true;
	$card = [1,1,1,1,1,1,1];
	$else = 'Jeruk';
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
@endphp

@extends('layouts.dashboard.header')

@section('content')
<div id="navbar">
	<nav class="navbar navbar-light bg-light shadow px-4 w-100 fixed">
		<button type="button" id="categoryCollapse" class="btn btn-sm btn-transparent mr-auto">
        <i class="material-icons md-24 text-my-primary">dehaze</i>
    </button>
		<a class="navbar-brand pl-2" href="#">
	    <img src="{{asset('images/logo-cdc.png')}}" width="50" class="d-inline-block align-top" alt=""> 
	    <b class="text-24 text-my-primary">Shop</b>
	  </a>
	  <a class="ml-auto pr-2" href="{{route('login')}}">Login</a>
	</nav>
</div>
<div class="container-fluid">
	<div class="wrapper">
		<div id="category">
			<div class="row">
				@forelse($category as $c)
				<div class="col-6 pl-2 pr-2 pb-4">
					<div class="card" style="height: auto;">
						<div class="card-body d-flex justify-content-center">
							<center> 
									<i class="material-icons md-48">{{$c['icon']}}</i><br>
									<span>{{$c['nama']}}</span>
							</center>
						</div>
					</div>
				</div>
				@empty
				<div class="col-12 pl-2 pr-2 pb-4">
					<p class="not-found text-center">Tidak Ada Kategori</p>
				</div>
				@endforelse
			</div>
		</div>
		<div id="content">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 mb-4">
							<div id="carouselExampleIndicators" class="carousel slide shadow" data-ride="carousel">
							  <ol class="carousel-indicators">
							    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
							    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
							  </ol>
							  <div class="carousel-inner">
							    <div class="carousel-item active">
							      <img class="d-block w-100" src="https://shop.redq.now.sh/_next/static/images/grocery-banner-img-one-f61643072d29ecf1481c657015b69ea3.jpg" alt="First slide">
								  {{-- <div class="carousel-caption d-none d-md-block bg-my-success">
								    <h5>First slide</h5>
								    <p>First slide subtitle</p>
								  </div> --}}
							    </div>
							    <div class="carousel-item">
							      <img class="d-block w-100" src="https://shop.redq.now.sh/_next/static/images/grocery-banner-img-two-02f262ef03102cd4eaeea8ef517e4a16.jpg" alt="Second slide">
								  {{-- <div class="carousel-caption d-none d-md-block bg-my-success">
								    <h5>Second slide</h5>
								    <p>Second slide subtitle</p>
								  </div> --}}
							    </div>
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
					{{-- <div class="row">
				    <div class="col-md-12 valign-center">
				      <i class="material-icons md-36 text-my-danger mr-1">local_fire_department</i><span style="font-size: 18px"> Sembako Populer</span>
				    </div>
				    <div class="col-12">
				        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
				            <div class="MultiCarousel-inner">
				                @foreach($data as $d)
				                <div class="item px-1">
				                    <div class="card shadow">
				                        <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_176acb1444e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_176acb1444e%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.1171875%22%20y%3D%2296.3%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
				                        <div class="card-body text-left">
				                            <span class="carousel-card-title">Beras Super {{$d}}</span><br>
				                            <span class="carousel-card-subtitle">Tersedia {{$d}} Ton</span><br>
				                        </div>
				                    </div>
				                </div>
				                @endforeach
				            </div>
				            <button class="btn leftLst"><</button>
				            <button class="btn rightLst">></button>
				        </div>
				    </div>
					</div> --}}
					<div class="row" id="product-list">
						@forelse($card as $c)
						<div class="col-md-3 col-4">
							<div class="card item-card">
								<img src="https://cf.shopee.co.id/file/08744f5b0e1ab3e2d537df5bbf5b2bb4">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<span class="badge badge-pill badge-danger bg-my-danger">Terlaris</span>
											<span class="badge badge-pill badge-primary bg-my-primary">Perkebunan</span>
										</div>
										<div class="col-12">
											<span class="product-name">Beras Super, 1Kg ashdh asadgh asdhgj hsgd gaasd dhgahsdghs dhgaasdgjhaghdjhsdhdshgdhj</span>
										</div>
										<div class="col-12">
											<span class="product-price">Rp. 200.000</span>
										</div>
									</div>
									{{-- <button type="button" class="btn btn-primary btn-sm mx-1">Keranjang</button>
									<button type="button" class="btn btn-warning btn-sm mx-1">Beli</button> --}}
								</div>
							</div>
						</div>
						@empty
						<div class="col-md-12 d-flex justify-content-center">
							<center>
								<span class="oops">Oops!</span>
								<p class="not-found">Maaf, {{$else}} tidak ada. Mohon Cari Kembali</p>
							</center>
						</div>
						@endforelse
					</div>
					<div class="row my-4">
						<div class="col-md-12 col-sm-6 d-flex justify-content-center">
							<button type="button" class="btn btn-outline-primary">Lebih Banyak</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
