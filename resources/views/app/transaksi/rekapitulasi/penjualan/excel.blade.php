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
        <th style="border: 1px solid black">Tanggal Penjualan</th>
        <th style="border: 1px solid black">No Penjualan</th>
        <th style="border: 1px solid black">No Kwitansi</th>
        <th style="border: 1px solid black">No Surat Jalan</th>
        <th style="border: 1px solid black">Nama Pembeli</th>
        <th style="border: 1px solid black">Nama Barang</th>
        <th style="border: 1px solid black">Jumlah Barang</th>
        <th style="border: 1px solid black">Harga Barang</th>
        <th style="border: 1px solid black">Total Harga Barang</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ date('d F Y',strtotime($a->tanggal_penjualan)) }}</td>
                <td style="border: 1px solid black">{{ $a->no_penjualan }}</td>
                @if ($a->no_kwitansi != null)
                    <td style="border: 1px solid black">{{ $a->no_kwitansi }}</td>
                    @else
                    <td style="border: 1px solid black">{{ $a->storageOut->suratPiutangPelangganRetail[0]->kode }}</td>
                    @endif
                <td style="border: 1px solid black">{{ $a->no_surat_jalan }}</td>
                <td style="border: 1px solid black">{{ $a->nama_pembeli }}</td>
                <td style="border: 1px solid black">{{ $a->barang }}</td>
                <td style="border: 1px solid black">{{ $a->jumlah }} {{ $a->satuan }}</td>
                <td style="border: 1px solid black">{{ $a->harga }}</td>
                <td style="border: 1px solid black">{{ $a->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
