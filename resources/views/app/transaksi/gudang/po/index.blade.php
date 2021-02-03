@php
    $icon = 'receipt_long';
    $pageTitle = 'Data Pemesanan Keluar';
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
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <a href="/shop" class="btn btn-primary btn-sm">Kembali Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @forelse($data as $d)
                <div class="col-md-6 col-6 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between valign-center my-2">
                                    {{-- <a href="{{route('po.preview',$d->id)}}" class="btn btn-sm bg-my-primary">Lihat Detail</a> --}}
                                    <div class="float-left" id="pill-status">
                                        {{-- @if($d->status == 0)
                                        <span class="badge rounded-pill bg-my-primary p-2">Pesanan Sedang Diproses</span>
                                        @elseif($d->status == 1)
                                        <span class="badge rounded-pill bg-my-warning p-2">Pinjaman Anda Sudah Disetujui</span>
                                        @elseif($d->status == 2)
                                        <span class="badge rounded-pill bg-my-success p-2">Pesanan Sudah Diterima Pemasok</span>
                                        @elseif($d->status == 3)
                                        <span class="badge rounded-pill bg-my-danger p-2">Pesanan Ditolak</span>
                                        @endif --}}
                                        @if($d->status == 0)
                                        <span class="badge rounded-pill bg-my-primary p-2">Pesanan Belum Dibayar</span>
                                        @elseif($d->status == 1)
                                        <span class="badge rounded-pill bg-my-primary p-2">Pesanan Sedang Diproses</span>
                                        @elseif($d->status == 2)
                                        <span class="badge rounded-pill bg-my-primary p-2">Pesanan Sedang Dikirim</span>
                                        @elseif($d->status == 3)
                                        <span class="badge rounded-pill bg-my-success p-2">Pesanan Diterima</span>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        @if($d->status == 2)
                                            <button type="button" class="btn btn-info btn-sm" title="Klik jika pesanan sudah diterima" onclick="terima({{ $d->id }})" id="btn-terima">Pesanan Diterima</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 border-right">
                                    Dari : <br><span class="text-14 bold">{{$d->nama_pemesan}}</span>
                                </div>
                                <div class="col-md-6">
                                    Ke : <br><span class="text-14 bold">{{$d->penerima_po}}</span>
                                </div>
                                <div class="col-md-12 border-right">
                                    Nomor Pemesanan : <br><span class="text-14 bold">{{$d->nomor_pemesanan}}</span>
                                </div>
                                <div class="col-md-12">
                                    <hr class=" my-1">
                                    <span class=" text-18">Data Pemesanan Barang</span><br>
                                    <span>{{$d->barangPesananBulky->nama_barang}} ({{$d->barangPesananBulky->jumlah.' '.$d->barangPesananBulky->satuan}})</span>
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
    function terima(id) {
        $.ajax({
            url: "/api/v1/retail/pemesanan/"+id+"/terima",
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                console.log(response.data)

                $('#btn-terima').remove();
                $('#pill-status').html(`<span class="badge rounded-pill bg-my-success p-2">Pesanan Diterima</span>`);
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
            }
        });
    }
</script>
@endpush
