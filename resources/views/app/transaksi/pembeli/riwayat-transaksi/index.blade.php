@php
    $icon = 'receipt_long';
    $pageTitle = 'Riwayat Transaksi';
    $nosidebar = true;
    $shop = true;
    $detail = true;
@endphp

@extends('layouts.dashboard.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show valign-center" role="alert">
                <i class="material-icons text-my-success">check_circle</i>
                {{ session()->get('success') }}
                <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons md-14">close</i>
                </button>
            </div>
            @elseif (session()->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
                <i class="material-icons text-my-danger">cancel</i>
                {{ session()->get('failed') }}
                <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons md-14">close</i>
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="row valign-center mb-2">
        <div class="col-md-12 col-sm-12 valign-center py-2">
            <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
            <div>
              <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
              <div class="valign-center breadcumb">
                <a href="#" class="text-14">iMarket</a>
                <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
                <a href="#" class="text-14">{{$pageTitle}}</a>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @forelse($data as $d)
                <div class="col-md-12 col-12 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between valign-center my-2">
                                    <div>
                                        @if($d->status == 0)
                                        <span class="badge rounded-pill bg-my-danger p-2">
                                            Pesanan Ditolak
                                        </span>
                                        @elseif($d->status == 1)
                                        <span class="badge rounded-pill bg-my-warning p-2">
                                            Pesanan Diproses
                                        </span>
                                        @elseif($d->status == 2)
                                        <span class="badge rounded-pill bg-my-primary p-2">
                                            Pesanan Sedang Dikemas
                                        </span>
                                        @elseif($d->status == 3)
                                        <span class="badge rounded-pill bg-my-primary p-2">
                                            Pesanan Dikirim
                                        </span>
                                        @elseif($d->status == 4)
                                        <span class="badge rounded-pill bg-my-success">
                                            Pesanan Diterima
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 border-right">
                                    Nomor Pemesanan : <br><span class="text-14 bold">{{$d->nomor_pemesanan}}</span>
                                </div> --}}
                                <div class="col-md-4 border-right">
                                    Dikirim Dari : <br><span class="text-14 bold">{{$d->pelanggan->nama}} ({{$d->pelanggan->kabupaten->nama}})</span>
                                </div>
                                <div class="col-md-4 border-right">
                                    Ke : <br><span class="text-14 bold">{{$d->pembeli->nama}}</span>
                                </div>
                                <div class="col-md-4">
                                    Alamat Tujuan : <br><span class="text-14 bold">{{$d->alamat_pemesan}}</span>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr class=" my-1">
                                </div>
                                <div class="col-md-8">
                                    <h6 class="my-2">Pesanan : 
                                        @foreach($d->pemesananPembeliItem as $key => $i)
                                        {{($key != 0) ? ',' : ''}}
                                        {{$i->nama_barang}} ({{$i->jumlah_barang.' '.$i->satuan}})
                                        @endforeach
                                    </h6>
                                </div>
                                <div class="col-md-4 d-flex valign-center justify-content-end">
                                    <a href="
                                        {{($d->status == 3) ? route('konfirmasi.terima.pembeli',$d->id) : '#'}}
                                    " class="btn btn-primary btn-sm {{($d->status == 3) ? '' : 'disabled'}}" title="Klik Jika Pesanan Anda Sudah Diterima">
                                        Konfirmasi Penerimaan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 my-4 py-4">
                    <center>-- Anda Belum Pernah Melakukan Pesanan --</center>
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <div class="text-center">
                <center>
                    {{$data->links()}}
                </center>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
</script>
@endpush
