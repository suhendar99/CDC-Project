@php
    $icon = 'receipt_long';
    $pageTitle = 'Konfirmasi Purchase Order';
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
                    <h4 class="card-title">Preview Surat Purchase Order</h4>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="print-page border-all">
                        @include('app.transaksi.admin.po.print')
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header">
                    <div class="float-right">
                        <a href="{{route('po.print')}}" class="btn btn-sm bg-my-success">Cetak PO</a>
                        <a href="{{route('po.index')}}" class="btn btn-sm bg-my-success">Selesai</a>
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
