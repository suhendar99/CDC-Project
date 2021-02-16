<!DOCTYPE html>
<html>
<head>
	<title>Kwitansi Pembelian</title>
	@if (isset($preview))
		{{-- <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}"> --}}
	@endif
</head>
<body>
	<style type="text/css">
		/**{
			font-family: 'Crimson Text', serif;
		}*/

		.table{
			width: 100%;
			background: transparent;
			padding: 0.3rem;
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
			padding: .3rem 0;
			font-size: 12px;
		}

		#body{
			margin-top: 2rem;
			margin-left: 2rem;
			margin-right: 2rem;
			margin-bottom: 2rem;
		}

		.bord{
			border: 1px solid #000;
		}

		.border-bottom{
			border-bottom: 2px dotted #000 !important;
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
		.text-12{
			font-size: 12px;
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

		.line{
			line-height: 1px;
		}

		p.kwit{
		    width: 100%;
		    color: #333;
		    background-image: repeating-linear-gradient(180deg, transparent, transparent 19px, #333 20px);
		}

		.bg-grey{
			background-color: #c6c6c6;
		}

		.jumlah{
			font-size: 1.2em;
		}

	</style>
	<div class="bord">
		<section id="body">
			<table class="table">
				{{-- @php
				$path = 'images/logo-cdc.png';
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$img = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
				@endphp --}}
				<tr>
					<td width="60%" class="text-center">
						<u><span class="text-24 bold">{{ $data->pemasok->nama }}</span></u><br>
						<span class="text-14">{{ $data->pemasok->alamat }}</span><br>
						{{-- <span class="text-14">Kec. Bojongsoang, Kab. Bandung</span><br>
						<span class="text-14">Jawa Barat</span> --}}

					</td>
					<td width="40%" class="text-center text-24 pb-2">
						<b><i>Kwitansi Pembayaran</i></b>
					</td>
				</tr>
			</table>
			<table class="table mt-2 pt-2 line">
				<tr>
					<td colspan="7" class="text-12">
						No Kwitansi: {{$data->kode}}
					</td>
				</tr>
				<tr>
					<td colspan="7" class="text-12">
						No Pemesanan: {{$data->pemesananKeluarBulky->kode}}
					</td>
				</tr>
				<tr>
					<td width="30%" class="text-12">
						Sudah Diterima Dari
					</td>
					<td width="5%">:</td>
					<td width="65%" class="border-bottom">
						<p class="kwit text-12">{{$data->terima_dari}}</p>
					</td>
				</tr>
				<tr>
					<td width="30%" class="text-12">
						Jumlah Terbilang
					</td>
					<td width="5%">:</td>
					<td width="65%" class="border-bottom bg-grey">
						<p class="kwit text-12">{{$data->jumlah_uang_word}} Rupiah</p>
					</td>
				</tr>
				<tr>
					<td width="30%" class="text-12">
						Untuk Pembayaran
					</td>
					<td width="5%">:</td>
					<td width="65%" class="border-bottom">
						<p class="kwit text-12">
								{{$data->pemesananKeluarBulky->barangKeluarPemesananBulky[0]->nama_barang}}
						</p>
					</td>
				</tr>
				<tr>
					<td width="30%" class="text-12">
						Keterangan
					</td>
					<td width="5%">:</td>
					<td width="65%" class="border-bottom">
						<p class="kwit text-12">{{$data->keterangan}}</p>
					</td>
				</tr>
			</table>
		</section>
		<section id="footer">
			<table class="table mt-2">
				<tr>
					<td width="40%" class="text-center" rowspan="2">
						<div class="jumlah">
							Jumlah Terhitung : Rp. {{number_format($data->jumlah_uang_digits,0,',','.')}},-
						</div>
					</td>
					<td width="20%"></td>
					<td width="40%" class="text-center text-14">
						<i>{{$data->tempat.', '.$date}}</i>
					</td>
				</tr>
				<tr>
					<td width="20%"></td>
					<td width="40%" class="text-center" height="100px">
						<div style="width: 250px;margin: 0 auto;font-size: 1.1em;">(  <span>...........................................</span>  )</div>
					</td>
				</tr>
			</table>
		</section>
	</div>
</body>
</html>
