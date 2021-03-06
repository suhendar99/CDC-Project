<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
	@if (isset($preview))
		<link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
	@endif
</head>
<body>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: normal;
		  font-weight: normal;
		  src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
		}
		body {
			font-family: Open Sans, sans-serif !important;
		}
		.table{
			width: 100%;
			background: transparent;
			padding: 0.75rem;
		    vertical-align: center;
			border: 0 !important;
		    font-family: 'Poppins', sans-serif;
			border-collapse: collapse;
		}

		.table th, .table td {
		    border-top: 0;
		    vertical-align: middle;
		}

		.text-center{
			text-align: center;
		}

		.text-left{
			text-align: left;
		}

		.text-right{
			text-align: right;
		}

		.float-right{
			float: right !important;
		}

		.float-left{
			float: left !important;
		}

		.valign-top{
			vertical-align: top !important;
		}

		.logo{
			width: 200px;
			height: 100px;
			object-fit: scale-down;
		}

		.logo-text{
			font-size: 36px;
			font-weight: 700;
		}

		.d-flex{
			display: flex;
		}

		.justify-content-center{
			justify-content: center;
		}

		.valign-center{
			align-items: center;
		}

		.head td{
			background-color: #2e3e4e !important;
			color: #fff;
			font-weight: 500;
			padding: .5rem 0;
		}

		.table-po tr td{
			background-color: #f1f1f1;
			border: 2px solid #fff;
			padding: .6rem 0;
			font-size: 12px;
		}

		#body{
			margin-top: 2rem;
		}

		.border-bottom{
			border-bottom: 2px solid #000 !important;
		}

		.w-20{
			width: 20%;
		}

		.w-30{
			width: 30%;
		}

		.w-40{
			width: 70%;
		}

		.bg-white td{
			background: #fff !important;
		}

		/*MARGIN STYLE*/
		.mt-2{ margin-top: 1rem; }

		.mt-1{ margin-top: .5rem; }

		.mr-2{ margin-right: 1rem; }

		.mr-1{ margin-right: .5rem; }

		.ml-2{ margin-left: 1rem; }
		.ml-1{ margin-left: .5rem; }

		.mb-2{ margin-bottom: 1rem; }
		.mb-1{ margin-bottom: .5rem; }

		/*END MARGIN STYLE*/

		/*PADDING STYLE*/

		.pt-2{ padding-top: 1rem; }
		.pt-1{ padding-top: .5rem; }

		.pr-2{ padding-right: 1rem; }
		.pr-1{ padding-right: .5rem; }

		.pl-2{ padding-left: 1rem; }
		.pl-1{ padding-left: .5rem; }

		.pb-2{ padding-bottom: 1rem; }
		.pb-1{ padding-bottom: .5rem; }
		.pr-40{ padding-right: 40%; }

		/*END PADDING STYLE*/

		.text-10{
			font-size: 10px;
		}
		.text-14{
			font-size: 14px;
		}
		.text-18{
			font-size: 18px !important;
		}
		.text-24{
			font-size: 24px !important;
		}
		.text-36{
			font-size: 36px;
		}

		.bold{
			font-weight: 800;
		}
	</style>
	<section id="header">
		</span>
		<table class="table">
			<tr>
				<td colspan="3" class="text-24 bold pt-2 pr-2 pb-2 text-right">
					Purchase Order
				</td>
			</tr>
			@php
			$path = 'images/logo-cdc.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$img = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
			@endphp
			<tr>
				<td rowspan="2" width="70%" class="pr-40">
					<div>
						<img src="{{$base64}}" class="logo"/>
						{{-- <span class="logo-text">LOGO</span> --}}
					</div>
				</td>
				<td width="15%" class="valign-top">
					Tanggal
				</td>
				<td width="15%" class="valign-top">
					:
					<span class="float-right">{{$date}}</span>
				</td>
			</tr>
			<tr>
				<td class="valign-top">
					Status
				</td>
				<td class="valign-top">
					:
					<span class="float-right">Draft</span>
				</td>
			</tr>
		</table>
		<table class="table mt-2 pt-2">
			<tr>
				<td colspan="3" width="45%" class="border-bottom pl-2">
					Info Perusahaan
				</td>
				<td width="10%"></td>
				<td colspan="3" width="45%" class="border-bottom pl-2">
					Order Ke
				</td>
			</tr>
			<tr>
				<td colspan="3" class="pt-2 pl-2 pb-2 bold">
					{{$data->gudang->nama}}
				</td>
				<td></td>
				<td colspan="3" class="pt-2 pl-2 pb-2 bold">
					{{$data->penerima_po}}
				</td>
			</tr>
			<tr class="text-14">
				<td>Telp</td>
				<td>:</td>
				<td class="text-right">{{$data->gudang->kontak}}</td>
				<td></td>
				<td>Telp</td>
				<td>:</td>
				<td class="text-right">{{$data->telepon_penerima}}</td>
			</tr>
			<tr class="text-14">
				<td>Email</td>
				<td>:</td>
				<td class="text-right">{{$data->gudang->user->email}}</td>
				<td></td>
				<td>Email</td>
				<td>:</td>
				<td class="text-right">{{$data->email_penerima}}</td>
			</tr>
			<tr class="text-14">
				<td colspan="4"></td>
				<td class="valign-top">Alamat</td>
				<td class="valign-top">:</td>
				<td class="text-right">
					{{$data->alamat_penerima}}
				</td>
			</tr>
		</table>
	</section>
	<section id="body">
		<table class="table text-center table-po">
				<tr class="head">
					<td>No</td>
					<td>Produk</td>
					<td>Kuantitas</td>
					<td>Harga</td>
					<td>Diskon (%)</td>
					<td>Pajak (%)</td>
					<td>Total</td>
				</tr>
				@php
					$totalPajak = 0;
					$totalDiskon = 0;
					$subtotalHarga = 0;
				@endphp
				@foreach($data->po_item as $key => $d)
				@php
					$subtotal = $d->harga*$d->jumlah;
					$diskon = $subtotal*$d->diskon/100;
					$hasilPajak = $subtotal*$d->pajak/100;
					// $total = $subtotal+$hasilPajak;

					$totalPajak = $totalPajak + $hasilPajak;
					$totalDiskon = $totalDiskon + $diskon;
					$subtotalHarga = $subtotalHarga + $subtotal;
				@endphp
				<tr>
					<td>{!! $key+1 !!}</td>
					<td class="text-left">
						{{$d->nama_barang}}
					</td>
					<td>
						{{$d->jumlah.' '.$d->satuan}}
					</td>
					<td>
						Rp. {{number_format($d->harga,0,',','.')}}
					</td>
					<td>
						{{$d->diskon}}% : Rp. {{number_format($diskon,0,',','.')}}
					</td>
					<td>
						{{$d->pajak}}% : Rp. {{number_format($hasilPajak,0,',','.')}}
					</td>
					<td>
						Rp. {{number_format($subtotal,0,',','.')}}
					</td>
				</tr>
				@endforeach
				{!! $totalHarga = $subtotalHarga + $totalPajak - $totalDiskon; !!}
				<tr class="bg-white">
					<td colspan="5" class="text-right">
						<span >Subtotal</span>
						<span>:</span>
					</td>
					<td colspan="2" class="text-right">
						<span>Rp. {{number_format($subtotalHarga,0,',','.')}}</span>
					</td>
				</tr>
				<tr class="bg-white">
					<td colspan="5" class="text-right">
						<span>Pajak</span>
						<span>:</span>
					</td>
					<td colspan="2" class="text-right">
						<span>Rp. {{number_format($totalPajak,0,',','.')}}</span>
					</td>
				</tr>
				<tr class="bg-white">
					<td colspan="5" class="text-right">
						<span>Diskon</span>
						<span>:</span>
					</td>
					<td colspan="2" class="text-right">
						<span>Rp. {{number_format($totalDiskon,0,',','.')}}</span>
					</td>
				</tr>
				<tr class="bg-white bold">
					<td colspan="5" class="text-right text-18">
						<span>Total</span>
						<span>:</span>
					</td>
					<td colspan="2" class="text-right text-18">
						<span>Rp. {{number_format($totalHarga,0,',','.')}}</span>
					</td>
				</tr>
		</table>
	</section>
	<br><br>
	<section id="footer">
		<table class="table mt-2">
			<tr>
				<td width="10%"></td>
				<td width="30%" class="border-bottom text-center">
					{{$data->gudang->nama}}
					<br><br><br><br>
					{{$data->gudang->pemilik}}
				</td>
				<td width="20%"></td>
				<td width="30%" class="border-bottom text-center">
					{{$data->penerima_po}}
					<br><br><br><br>
					{{$data->nama_penerima}}
				</td>
				<td width="10%"></td>
			</tr>
		</table>
	</section>
</body>
</html>
