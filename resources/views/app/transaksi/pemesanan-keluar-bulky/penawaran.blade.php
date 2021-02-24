@php
    $icon = 'receipt_long';
    $pageTitle = 'Data Penawaran dari Retail';
@endphp

@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="container">
    <div class="row valign-center mb-2">
        <div class="col-md-12 col-sm-12 valign-center py-2">
            <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
            <div>
              <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
              <div class="valign-center breadcumb">
                <a href="#" class="text-14">Dashboard</a>
                <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
                <a href="#" class="text-14">Data Transaksi</a>
                <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
                <a href="#" class="text-14">{{$pageTitle}}</a>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-md-12">
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
        </div> --}}
        <div class="col-md-12">
            <div class="row">
                @forelse($data as $d)
                <div class="col-md-12 col-12 my-2">
                    <div class="card">
                        <div class="card-body">
                            @if($d->status == null)
                            <div class="row">
                                <div class="col-7 d-flex justify-content-between">
                                    <h6>
                                        Pesan Dengan Rincian :
                                        {{$d->nama_barang}} ({{$d->jumlah}} {{$d->satuan}})
                                        , Menunggu Konfirmasi
                                    </h6>
                                </div>
                                <div class="col-5">
                                    <div class="float-right">
                                        <a href="{{route('tolak.penawaran',$d->id)}}" class="btn btn-danger">Tolak Penawaran</a>
                                        <a href="{{route('konfirmasi.penawaran',$d->id)}}" class="btn btn-primary">Konfirmasi Penawaran</a>
                                    </div>
                                </div>
                            </div>
                            @elseif($d->status == 4)
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <h6 class="text-danger">
                                        Pesan Dengan Rincian :
                                        {{$d->nama_barang}} ({{$d->jumlah}} {{$d->satuan}})
                                        , Telah Ditolak
                                    </h6>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between valign-center my-2">
                                    <div id="pill-status">
                                        @if($d->status == 4)
                                        <span class="badge rounded-pill bg-my-danger p-2" >
                                            Penawaran Ditolak
                                        </span>
                                        @elseif($d->status == 1)
                                        <span class="badge rounded-pill bg-my-success p-2">
                                            Penawaran Disetujui
                                        </span>
                                        @elseif($d->status == 2)
                                        <span class="badge rounded-pill bg-my-warning p-2">
                                            Penawaran Dikirim
                                        </span>
                                        @elseif($d->status == 3)
                                        <span class="badge rounded-pill bg-my-success p-2">
                                            Barang Diterima
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    Dikirim Dari : <br><span class="text-14 bold">{{$d->pemasok->nama}} ({{$d->pemasok->kabupaten->nama}})</span>
                                </div>
                                {{-- {{dd($d->retail->akunGudang[0]->kabupaten->nama)}} --}}
                                {{-- <div class="col-md-4 border-right">
                                    Ke : <br><span class="text-14 bold">{{$d->gudangBulky->akunGudangBulky->nama}} ({{$d->gudangBulky->akunGudangBulky->kabupaten->nama}})</span>
                                </div> --}}
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr class=" my-1">
                                </div>
                                <div class="col-md-8">
                                    <h6 class="my-2">Pesanan :
                                        {{-- {{dd($d->barangPesananBulky->nama_barang)}} --}}
                                        {{-- @foreach($d->barangPesananBulky as $key => $i)
                                        {{($key != 0) ? ',' : ''}} --}}
                                        {{$d->nama_barang}}, Rp {{ number_format($d->harga_barang,0,',','.')}} ({{$d->jumlah.' '.$d->satuan}})
                                        {{-- @endforeach --}}
                                    </h6>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 my-4 py-4">
                    <center>-- Tidak Ada Penawaran --</center>
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
    function uploadBukti(id){
        $('#form').attr('action',`/v1/upload/bukti/retail/${id}`);
    }
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
