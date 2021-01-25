@php
    $icon = 'receipt_long';
    $pageTitle = 'Preview Pemesanan';
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
                    <h4 class="card-title float-left">Preview Pemesanan</h4>
                    <div class="float-right">
                        <a href="{{route('print',$data->id)}}" target="_blank" class="btn bg-my-success">
                            <div class="d-flex valign-center">
                                <i class="material-icons md-18 p-0 mr-1">download</i>Download
                            </div>
                        </a>
                        {{-- @if (Auth::user()->pemasok_id != null)
                            <a href="{{route('po.masuk.pemasok')}}" class="btn bg-my-primary">Kembali</a>
                        @elseif (Auth::user()->pengurus_gudang_id != null)
                            <a href="{{route('po.index')}}" class="btn bg-my-primary">Kembali</a>
                        @endif --}}
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <div class="print-page border-all">
                        @include('app.transaksi.pemesanan-barang.print')
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
