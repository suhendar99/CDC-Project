<!DOCTYPE html>
<html>
<head>
	<title>Surat Jalan</title>
	@if (isset($preview))
		<link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
	@endif
</head>
<body>
	<style type="text/css">
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
			padding: .6rem 0 !important;
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

		.pl-4{ padding-left: 2rem !important; }
		.pl-2{ padding-left: 1rem !important; }
		.pl-1{ padding-left: .5rem; }

		.pb-2{ padding-bottom: 1rem; }
		.pb-1{ padding-bottom: .5rem; }
		.pr-40{ padding-right: 40%; }

		/*END PADDING STYLE*/

		.text-10{
			font-size: 10px;
		}
		.text-12{
			font-size: 12px;
		}
		.text-14{
			font-size: 14px;
		}
		.text-16{
			font-size: 16px;
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
			font-weight: 600;
		}
	</style>
	<section id="header">
		<table class="table mt-2 pt-2">
			@php
			$path = 'images/logo-cdc.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$img = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
			@endphp
			<tr>
				<td width="30%" class=" bold text-24 pb-1">
					{{$data->pemesanan->gudang->nama}}
				</td>
				<td width="20%" rowspan="3" style="vertical-align: middle;" class="border-bottom pb-4">
					<center>
						<img src="{{$base64}}" alt="logo" height="80" style="object-fit: scale-down">
					</center>
				</td>
				<td width="20%"></td>
				<td width="30%" class=" text-14">
					Kepada<br>
					{{$data->penerima}} <br>
					{{$data->pemesanan->alamat_pemesan}}
				</td>
			</tr>
			<tr class="text-14">
				<td class=" text-14 pb-1">
					{{$data->pemesanan->gudang->alamat}}
				</td>
				<td></td>
				<td class="">
				</td>
			</tr>
			<tr class="text-14">
				<td class=" border-bottom pb-1">Telp. {{$data->pemesanan->gudang->kontak}}</td>
				<td></td>
				<td class=""></td>
			</tr>
			<tr>
				<td colspan="2" class="text-16 pb-2 pt-2"> NO SURAT : {{$data->kode}}</td>
				<td></td>
				<td class="  pt-4 text-14"> {{$data->tempat}}, {!!date("d F Y")!!}</td>
			</tr>
		</table>
	</section>
	<section id="body">
		<span class="pl-2">Berikut adalah barang-barang yang dikirim, sebagai berikut :</span>
		<table class="table text-center table-po">
			<tr class="head">
				<td>No</td>
				<td class="text-left">&nbsp; Uraian Barang</td>
				<td>Jumlah</td>
				<td>Satuan</td>
				<td>Ket</td>
			</tr>

			@foreach($data->pemesanan->barangPesanan as $key => $row)
			<tr>
				<td>{{$key+1}}</td>
				<td class="text-left">&nbsp; {{$row->nama_barang}}</td>
				<td>{{$row->jumlah_barang}}</td>
				<td>{{$row->satuan}}</td>
				<td>&nbsp;</td>
			</tr>
			@endforeach
		</table>
	</section>
	<br><br>
	<section id="footer">
		<table class="table mt-2">
			<tr>
				<td width="15%"></td>
				<td width="25%" class="text-center text-14">
					Tanda Terima,
					<br><br>
				</td>
				<td width="20%"></td>
				<td width="25%" class="text-center text-14">
					Hormat Kami,
					<br><br>
				</td>
				<td width="15%"></td>
			</tr>
			<tr>
				<td colspan="5" height="50px">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td class="border-bottom text-center text-14">
				</td>
				<td></td>
				<td class="text-center text-14">
					
					({{$data->pemesanan->gudang->pemilik}})<br>
					{{$data->pemesanan->gudang->nama}}
				</td>
				<td></td>
			</tr>

		</table>
	</section>
</body>
</html>
