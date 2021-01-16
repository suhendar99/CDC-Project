<table width="100%" style="margin-bottom: -10px; " id="customers">
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center;font-size:11px;border: 1px solid #475F7B; padding: 30px;"><center>No</center></th>
            <th rowspan="2" style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Kode PO</th>
            <th rowspan="2" style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Gudang</th>
            <th rowspan="2" style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Penerima PO</th>
            <th rowspan="2" style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Alamat peneriam</th>
            <th colspan="5" style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Item</th>
        </tr>
        <tr>
            <th style="color: black; text-align:center;font-size:11px;border: 1px solid #475F7B;">Nama Barang</th>
            <th style="color: black; text-align:center;font-size:11px;border: 1px solid #475F7B;">Jumlah Barang</th>
            <th style="color: black; text-align:center;font-size:11px;border: 1px solid #475F7B;">Harga Barang</th>
            <th style="color: black; text-align:center;font-size:11px;border: 1px solid #475F7B;">Diskon</th>
            <th style="color: black; text-align:center;font-size:11px;border: 1px solid #475F7B;">Pajak</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
        <tr>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;" rowspan="{{$value->po_item->count()}}">{{$key+1}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;" rowspan="{{$value->po_item->count()}}">{{$value->kode_po}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;" rowspan="{{$value->po_item->count()}}">{{$value->gudang->nama}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;" rowspan="{{$value->po_item->count()}}">{{$value->penerima_po}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;" rowspan="{{$value->po_item->count()}}">{{$value->alamat_penerima}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$value->po_item[0]->nama_barang}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$value->po_item[0]->jumlah}} {{$value->po_item[0]->satuan}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Rp {{number_format($value->po_item[0]->harga)}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$value->po_item[0]->diskon}} %</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$value->po_item[0]->pajak}} %</td>
        </tr>
        @if ($value->po_item->count() > 1)
        @foreach ($value->po_item as $key => $i)
        @if ($key > 0)
        <tr>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$i->nama_barang}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$i->jumlah}} {{$i->satuan}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">Rp {{number_format($i->harga)}}</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$i->diskon}} %</td>
            <td style="text-align:center;font-size:11px;border: 1px solid #475F7B;">{{$i->pajak}} %</td>
        </tr>
        @endif
        @endforeach
        @endif
        @endforeach
    </tbody>
</table>
