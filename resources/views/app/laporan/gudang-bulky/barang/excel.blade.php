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
        <th style="border: 1px solid black">Waktu Barang Masuk</th>
        <th style="border: 1px solid black">Nama Gudang</th>
        <th style="border: 1px solid black">Kode Barang</th>
        <th style="border: 1px solid black">Nama Barang</th>
        <th style="border: 1px solid black">Jumlah Barang</th>
        <th style="border: 1px solid black">Satuan</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ date('d F Y',strtotime($a->created_at)) }}</td>
                <td style="border: 1px solid black">{{ $a->bulky->nama }}</td>
                <td style="border: 1px solid black">{{ $a->barang_kode }}</td>
                <td style="border: 1px solid black">{{ $a->barang->nama_barang }}</td>
                <td style="border: 1px solid black">{{ $a->jumlah }}</td>
                <td style="border: 1px solid black">{{ $a->satuan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
