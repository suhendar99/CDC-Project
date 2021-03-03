@php
    $date = Carbon\Carbon::now()->translatedFormat(' d F Y');
    $title = 'Laporan Rekapitulasi Laba Rugi'
@endphp

<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
	<style>
		#customers {
		font-family: 'Poppins', sans-serif;
		border-collapse: collapse;
		width: 100%;
		}
		#customers td, #customers th {
		border: 1px solid #ddd;
		padding: 8px;
		}
		#customers tr:nth-child(even){background-color: #ddd;}
		#customers tr:hover {background-color: #ddd;}
		#customers thead {
		padding-top: 7px;
		padding-bottom: 7px;
		text-align: left;
		background-color: #8a8a8a;
		color: white;
		}
		*{
			font-family:sans-serif;
		}
		table {
			width: 100%;
			padding: 5px;
		}
		table, th, tr, td {
			border: 1px black;
            text-align: center;
        }
		#header,
		#footer {
		  position: fixed;
		  left: 0;
			right: 0;
			color: #aaa;
			font-size: 0.7em;
		}
		#header {
		  top: 0;
			border-bottom: 0.1pt solid #aaa;
		}
		#footer {
		  bottom: 0;
		  border-top: 0.1pt solid #aaa;
		}
		.page-number:before {
		  content: "Page " counter(page);
		}
	</style>
</head>
<body>
	{{-- <img src="{{ $set->icon }}" style="float: left;" width="50px" height="50px"> --}}
	<h3 style=" margin-top: 30px; margin-right:20px;">
		{{-- {{ $set->header }} --}}
	</h3>

	<div class="container">
	<style type="text/css">
		table tr td{
            text-align: center;
            font-size: 15px;
		}
		table tr th{
            text-align: center;
            font-size: 15px;
		}
		table {
		  border-collapse: collapse;
		  width: 100%;
		}
		th, td {
		  text-align: left;
		  padding: 8px;
        }
        img {
            height: 60px;
            width: auto;
        }
        .left {
            height: auto;
            width: 50px;
        }
        .text {
            padding: 1px !important;
            margin-left: 40px;
            text-align: center ;
            margin-top: 20px;
            height: auto;
        }
        table, td{
            background-color: #ffffff;
            /* padding: 2px; */
        }
        table td .text{
            background-color: #ffffff;
            padding: 2px;
        }
		tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
        <center>
            <h3>{{$title}}</h3>
        </center>
	<table style="margin-bottom:-10px;">
		{{-- <tr>
			@if ($month != null)
            <td rowspan="2" style="text-align:left; font-size:13px;">
				Sumber Data : {{ $sumber }}
			</td>
            @elseif($awal != null && $akhir != null)
            <td rowspan="2" style="text-align:right; font-size:13px;">
				Waktu : {{$awal}} s.d. {{$akhir}}
			</td>
            @endif
		</tr> --}}
	</table>
    <table width="100%" style="margin-bottom: -10px; " id="customers">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Pencatatan</th>
                <th>Laba Kotor</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Biaya Operasional</th>
                <th>Laba Bersih</th>
        </thead>
        <tbody>
            @php $no = 1 @endphp
            @foreach($data as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ date('d F Y',strtotime($a->created_at)) }}</td>
                    <td>{{ 'Rp. '.number_format($a->laba_kotor,0,',','.') }}</td>
                    <td>{{ 'Rp. '.number_format($a->penjualan,0,',','.') }}</td>
                    <td>{{ 'Rp. '.number_format($a->pembelian,0,',','.') }}</td>
                    <td>{{ 'Rp. '.number_format($a->biaya_operasional,0,',','.') }}</td>
                    <td>{{ 'Rp. '.number_format($a->laba_bersih,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
	</table>

	{{-- <div style="float: right; margin-top:30px;">
        Bandung,  {{$date}}<br><br><br><br>
		{{Auth::user()->pengurusGudang->nama}}
	</div> --}}
	<div id="footer">
	  <div class="page-number"></div>
	</div>

<script>
</script>
</body>
</html>
