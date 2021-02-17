@php
        $icon = 'storage';
        $pageTitle = 'Data Retur';
        $nosidebar = true;
        $shop = true;
        $detail = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5 class="text-dark"><i class="ri-reply-fill"></i> {{$pageTitle}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('retur-pembeli.create')}}" class="btn btn-primary btn-sm">Buat Retur</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @forelse ($data as $item)
            <div class="card shadow mt-4">
                <div class="card-body">
                  <h5 class="card-title">{{$item->pemesanan->pemesananPembeliItem[0]->nama_barang}} ({{$item->pemesanan->pemesananPembeliItem[0]->jumlah_barang}} {{$item->pemesanan->pemesananPembeliItem[0]->satuan}})</h5>
                  <p class="card-text">Keterangan Retur : {{$item->keterangan}}</p>
                </div>
                <div class="card-footer text-muted">
                  {{$item->created_at->diffForHumans()}}
                </div>
            </div>
            @empty
            <div class="card shadow mt-3">
                <div class="card-body">
                    <center>-- Tidak Ada Retur --</center>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
<form action="" id="formDelete" method="POST">
    @csrf
    @method('DELETE')
</form>
@push('script')
    <script>
    </script>
@endpush
@endsection
