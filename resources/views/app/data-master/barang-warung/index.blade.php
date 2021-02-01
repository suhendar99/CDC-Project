@php
        $icon = 'storage';
        $pageTitle = 'Barang';
        $dashboard = true;
        // $rightbar = true;
@endphp
<style>
    .blockquote-custom {
    position: relative;
    font-size: 1.1rem;
    }

    .blockquote-custom-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -25px;
    left: 50px;
    }
</style>
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
            <a href="#" class="text-14">Data Barang</a>
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
        </div>
        <div class="col-md-12">
            <div class="row">
                @forelse($barangWarung as $d)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <h5 class="card-title">{{$d->stok->barang->nama_barang}}</h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        <a href="#" class="badge badge-warning">{{$d->stok->barang->kategori->nama}}</a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <span class="card-text">Kode Barang : {{$d->barang_kode}}</span><br>
                            <span class="card-text">Harga Barang : Rp {{number_format($d->stok->harga_barang,0,',','.')}} ({{$d->jumlah}} {{$d->satuan}})</span><br>
                            <span class="card-text">Deskripsi Barang : {{$d->stok->barang->deskripsi}}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 my-4 py-4">
                    <center>-- Anda Tidak Mempunyai Barang --</center>
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <div class="text-center">
                <center>
                    {{$barangWarung->links()}}
                </center>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')

@endpush
