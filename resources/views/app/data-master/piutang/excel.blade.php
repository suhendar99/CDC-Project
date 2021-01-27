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
        <th style="border: 1px solid black">No transaksi</th>
        <th style="border: 1px solid black">Waktu Transaksi</th>
        <th style="border: 1px solid black">Nama Pembeli</th>
        <th style="border: 1px solid black">Jumlah Hutang</th>
        <th style="border: 1px solid black">Nama Barang</th>
        <th style="border: 1px solid black">Jatuh Tempo</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ date('d F Y',strtotime($a->tanggal_pembelian)) }}</td>
                <td style="border: 1px solid black">{{ $a->no_pembelian }}</td>
                <td style="border: 1px solid black">{{ $a->no_kwitansi }}</td>
                <td style="border: 1px solid black">{{ $a->no_surat_jalan }}</td>
                <td style="border: 1px solid black">{{ $a->nama_penjual }}</td>
                <td style="border: 1px solid black">{{ $a->barang }}</td>
                <td style="border: 1px solid black">{{ $a->jumlah }} {{ $a->satuan }}</td>
                <td style="border: 1px solid black">{{ $a->harga }}</td>
                <td style="border: 1px solid black">{{ $a->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
