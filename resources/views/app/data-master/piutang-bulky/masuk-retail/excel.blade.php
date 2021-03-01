@php
    // dd($uptd);
    // setlocale(LC_MONETARY, 'id_ID');
@endphp
<style>
    table {
        border: 1px solid #000;
    }
    tr th{
        border: 1px solid #000000;
    }
</style>
<table border="1 solid">
    <thead>
    <tr>
        <th style="border: 1px solid black">No</th>
        <th style="border: 1px solid black">Tanggal Transaksi</th>
        <th style="border: 1px solid black">Kode Transaksi</th>
        <th style="border: 1px solid black">Nama Pembeli</th>
        <th style="border: 1px solid black">Jumlah Hutang</th>
        <th style="border: 1px solid black">Jatuh Tempo</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ date('d F Y',strtotime($a->tanggal)) }}</td>
                <td style="border: 1px solid black">{{ $a->pemesananRetail->kode }}</td>
                <td style="border: 1px solid black">{{ $a->nama_pembeli }}</td>
                <td style="border: 1px solid black">{{ 'Rp '.number_format($a->hutang) }}</td>
                <td style="border: 1px solid black">{{ $a->jatuh_tempo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
