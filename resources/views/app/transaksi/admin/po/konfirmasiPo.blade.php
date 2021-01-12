@php
    $icon = 'receipt_long';
    $pageTitle = 'Konfirmasi Purchase Order';
    $date = date('d-m-Y');
    $pajak = 5;
    $data = array(
        [
            'nama' => 'Beras Super Nganu',
            'jumlah' => 170,
            'harga' => 11500,
            'diskon' => 10,
            'satuan' => 'Kg'
        ],
        [
            'nama' => 'Mangga Super Nganu',
            'jumlah' => 230,
            'harga' => 12000,
            'diskon' => 20,
            'satuan' => 'Kg'
        ]
    );
    $preview = true;
@endphp

@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Purchase Order</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Purchase Order</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">{{$pageTitle}}</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card my-3">
                <div class="card-header">
                    <h4 class="card-title float-left">Preview Surat Purchase Order</h4>
                    <div class="float-right">
                        <a href="{{route('po.print')}}" class="btn bg-my-success">
                            <div class="d-flex valign-center">
                                <i class="material-icons md-18 p-0 mr-1">download</i>Download
                            </div>
                        </a>
                        <a href="{{route('po.index')}}" class="btn bg-my-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="print-page border-all">
                        @include('app.transaksi.admin.po.print')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
</script>
@endpush
