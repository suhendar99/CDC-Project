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
        <th style="border: 1px solid black">Waktu Pencatatan</th>
        <th style="border: 1px solid black">Laba Kotor</th>
        <th style="border: 1px solid black">Penjualan</th>
        <th style="border: 1px solid black">Pembelian</th>
        <th style="border: 1px solid black">Biaya Operasional</th>
        <th style="border: 1px solid black">Laba Bersih</th>
    </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $a)
            <tr>
                <td style="border: 1px solid black">{{ $no++ }}</td>
                <td style="border: 1px solid black">{{ date('d F Y',strtotime($a->created_at)) }}</td>
                <td style="border: 1px solid black">{{ 'Rp. '.number_format($a->laba_kotor,0,',','.') }}</td>
                <td style="border: 1px solid black">{{ 'Rp. '.number_format($a->penjualan,0,',','.') }}</td>
                <td style="border: 1px solid black">{{ 'Rp. '.number_format($a->pembelian,0,',','.') }}</td>
                <td style="border: 1px solid black">{{ 'Rp. '.number_format($a->biaya_operasional,0,',','.') }}</td>
                <td style="border: 1px solid black">{{ 'Rp. '.number_format($a->laba_bersih,0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
