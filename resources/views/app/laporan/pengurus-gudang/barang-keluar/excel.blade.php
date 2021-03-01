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
        <th style="border: 1px solid black">Waktu Barang Keluar</th>
        <th style="border: 1px solid black">Kode Barang</th>
        <th style="border: 1px solid black">Nama Barang</th>
        <th style="border: 1px solid black">Nama Gudang</th>
        <th style="border: 1px solid black">Kode Barang Keluar</th>
        <th style="border: 1px solid black">Jumlah</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ $a->waktu }}</td>
                <td style="border: 1px solid black">{{ $a->stockBarangRetail->kode }}</td>
                <td style="border: 1px solid black">{{ $a->stockBarangRetail->nama_barang }}</td>
                <td style="border: 1px solid black">{{ $a->gudang->nama }}</td>
                <td style="border: 1px solid black">{{ $a->kode }}</td>
                <td style="border: 1px solid black">{{ $a->jumlah }} {{ $a->satuan->nama }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
