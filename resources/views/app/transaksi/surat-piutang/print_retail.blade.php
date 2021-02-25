@php
    $title = 'SURAT PERNYATAAN HUTANG';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<style>
    *{
        font-family: sans-serif;
    }
    .center-bold{
        font-size: 15px;
        margin-bottom: 15px;
    }
    .after-title{
        font-size: 15px;
        margin-top: 30px;
        margin-bottom: 12px;
    }
    .first{
        font-size: 15px;
        margin-top: 20px;
        margin-bottom: 12px;
    }
    .after-title-2{
        margin-left: 80px;
        font-size: 13px;
    }
    .left{
        text-align: right;
    }
    .end{
        margin-left: 30px;
    }
    .table{
        margin: auto;
        padding: auto;
        width: 100%;
    }
    .footer{
        margin-bottom: 20px;
    }
    .name{
        padding: 40px;
    }
</style>
<body>
    <header>
        <center><b class="center-bold">{{$title}}</b></center>
    </header>
    <main>
        <div class="after-title">
            Kami yang bertanda tangan di bawah ini : <br>
        </div>
        <div class="after-title-2">
            <span>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$data->pihak_pertama}}</span> <br><br>
            <span>No KTP&nbsp;&nbsp;&nbsp;&nbsp; : {{$data->retail->nik}}</span> <br><br>
            <span>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$data->retail->alamat}}</span>
        </div>
        <div class="after-title first">
            Selanjutnya disebut pihak pertama. <br>
        </div>
        <div class="after-title-2">
            <span>Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$data->pihak_kedua}}</span> <br><br>
            <span>No KTP&nbsp;&nbsp;&nbsp;&nbsp; : {{$pengurus->nik}}</span> <br><br>
            <span>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$pengurus->alamat}}</span>
        </div>
        <div class="after-title first">
            Selanjutnya disebut pihak kedua. <br>
        </div>
        <div class="paragraf">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pihak pertama menyerahkan {{$data->pemesanan->barangPesanan[0]->jumlah_barang}} {{$data->pemesanan->barangPesanan[0]->satuan}} {{$data->pemesanan->barangPesanan[0]->nama_barang}} senilai Rp {{number_format($data->jumlah_uang_digits)}},-({{$data->jumlah_uang_word}} Rupiah) kepada pihak kedua. Pihak pertama menyetujui untuk mengembalikan pinjaman dalam tempo waktu {{$day->jumlah_hari}} hari terhitung sejak perjanjian dengan jatuh tempo pada tanggal {{date('d-m-Y',strtotime($data->pemesanan->piutang->jatuh_tempo))}}. Apabila pihak pertama mengembalikan uang pinjamamn dengan lunas sebelum atau maksimal satu minggu setelah waktu yang telah ditentukan dalam perjanjian maka {{$data->pemesanan->barangPesanan[0]->jumlah_barang}} {{$data->pemesanan->barangPesanan[0]->satuan}} {{$data->pemesanan->barangPesanan[0]->nama_barang}} tidak akan dikirim.</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Demikian surat ini dibuat dengan sebenar - benarnya tanpa paksaan dari pihak manapun. </p>
            <div class="left">
                {{$data->tempat}}, {{$date}}
            </div>
            <div class="footer">
                Yang membuat pernyataan, <br>
            </div>
            <table class="table">
                <tr>
                    <td>
                        <center>Pihak Pertama</center>
                    </td>
                    <td class="name">
                        <center>Pihak Kedua</center>
                    </td>
                </tr>
                <tr>
                    <td>
                        <center>{{$data->pihak_pertama}}</center>
                    </td>
                    <td class="name">
                        <center>{{$data->pihak_kedua}}</center>
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>
