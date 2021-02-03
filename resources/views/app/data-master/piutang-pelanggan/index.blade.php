@php
        $icon = 'money_off';
        $pageTitle = 'Data Piutang Pelanggan';
        $dashboard = true;
        // $rightbar = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row valign-center mb-2">
    <div class="col-md-8 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Piutang Pelanggan</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('pelangganPiutang.pdf')}}" class="btn btn-primary btn-sm" target="__blank"><i class="far fa-file-pdf"></i> Download PDF</a>
                                <a href="{{route('pelangganPiutang.excel')}}" class="btn btn-primary btn-sm" target="__blank"><i class="far fa-file-excel"></i> Download EXCEL</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No transaksi</th>
                                <th>Jumlah Hutang</th>
                                <th>Waktu Transaksi</th>
                                <th>Jatuh Tempo</th>
                                <th>Nama Pembeli</th>
                                {{-- <th>Nama Barang</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="" id="formDelete" method="POST">
    @csrf
    @method('DELETE')
</form>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
    let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('piutangPelanggan.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'pemesanan.kode', name: 'barang_id'},
                {data : 'hutang', name: 'hutang'},
                {data : 'tanggal', name: 'tanggal'},
                {data : 'jatuh_tempo', name: 'jatuh_tempo'},
                {data : 'nama_pembeli', name: 'nama_pembeli'},
                // {data : 'barang.nama', name: 'barang_id'},
            ]
        });
</script>
{{--  --}}
@endpush
