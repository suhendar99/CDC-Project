@php
    $icon = 'receipt_long';
    $pageTitle = 'Data Pemesanan Ke Bulky';
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
                            @if($d->status == 0)
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <h6 class="text-danger">
                                        Pesan Dengan Rincian :
                                        {{$d->barangPesananBulky->nama_barang}} ({{$d->barangPesananBulky->jumlah_barang}} {{$d->barangPesananBulky->satuan}})
                                        , Ditolak Oleh Penjual
                                    </h6>
                                </div>
                            </div>
                            @elseif($d->storageKeluarBulky == null)
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <span>
                                        Pesanan dengan Rincian :
                                        {{$d->barangPesananBulky->nama_barang}} ({{$d->barangPesananBulky->jumlah_barang}} {{$d->barangPesananBulky->satuan}})
                                        , Belum Diproses Penjual
                                    </span>
                                    @if ($d->status == 6)
                                        @if($d->foto_bukti == null)
                                        <span class="badge rounded-pill bg-my-success text-dark p-2" >
                                            <i class="fas fa-shopping-bag"></i> Mohon Ambil Barang
                                        </span>
                                        @else
                                        <a class="btn btn-sm btn-primary disabled" href="#">
                                            {{
                                                (($d->status == 1) ? 'Mohon Tunggu Validasi Penjual ...' :
                                                (($d->status == 2) ? 'Pembayaran Sudah Diverifikasi, Pesanan Akan Segera Dikirim ... ' :
                                                (($d->status == 4) ? 'Pesanan Sedang Dikirim ... ' : 'Pesanan Diproses ...')))
                                            }}
                                        </a>
                                        @endif
                                    @else
                                        @if($d->foto_bukti == null && $d->status == 1)
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#exampleModal" onclick="uploadBukti({{ $d->id }})" data-id="{{ $d->id }}"><i class="fa fa-upload"></i> Upload Bukti Pembayaran</a>
                                        @elseif($d->foto_bukti == null && $d->status == 2 && $d->metode_pembayaran == null)
                                        <a class="btn btn-sm btn-primary disabled" href="#">
                                            {{
                                                (($d->status == 2) ? 'Pesanan Sedang Diproses ' :
                                                (($d->status == 4) ? 'Pesanan Sedang Dikirim ... ' : 'Pesanan Diproses ...'))
                                            }}
                                        </a>
                                        @elseif($d->status == 7)
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#exampleModal" onclick="uploadBukti({{ $d->id }})" data-id="{{ $d->id }}"><i class="fa fa-upload"></i> Upload Bukti Pembayaran yang sesuai</a>
                                        @elseif($d->foto_bukti == null && $d->status == 2 && $d->metode_pembayaran == null)
                                        <a class="btn btn-sm btn-primary disabled" href="#">
                                            {{
                                                (($d->status == 2) ? 'Pesanan Sedang Diproses ' :
                                                (($d->status == 4) ? 'Pesanan Sedang Dikirim ... ' : 'Pesanan Diproses ...'))
                                            }}
                                        </a>
                                        @else
                                        <a class="btn btn-sm btn-primary disabled" href="#">
                                            {{
                                                (($d->status == 1) ? 'Mohon Tunggu Validasi Penjual ...' :
                                                (($d->status == 2) ? 'Pembayaran Sudah Diverifikasi, Pesanan Akan Segera Dikirim ... ' :
                                                (($d->status == 4) ? 'Pesanan Sedang Dikirim ... ' : 'Pesanan Diproses ...')))
                                            }}
                                        </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between valign-center my-2">
                                    <div id="pill-status">
                                        @if($d->status == 0)
                                        <span class="badge rounded-pill bg-my-danger p-2" >
                                            Pesanan Ditolak
                                        </span>
                                        @elseif($d->status == 1)
                                        <span class="badge rounded-pill bg-my-warning p-2">
                                            Pesanan Diproses
                                        </span>
                                        @elseif($d->status == 2)
                                        <span class="badge rounded-pill bg-my-warning p-2">
                                            Pembayaran Diterima
                                        </span>
                                        @elseif($d->status == 3)
                                        <span class="badge rounded-pill bg-my-primary p-2">
                                            Pesanan Sedang Dikemas
                                        </span>
                                        @elseif($d->status == 4)
                                        <span class="badge rounded-pill bg-my-primary p-2">
                                            Pesanan Dikirim
                                        </span>
                                        @elseif($d->status == 5)
                                        <span class="badge rounded-pill bg-my-success">
                                            Pesanan Diterima
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    Dikirim Dari : <br><span class="text-14 bold">{{$d->storageKeluarBulky->user->pengurusGudangBulky->nama}} ({{$d->storageKeluarBulky->user->pengurusGudangBulky->kabupaten->nama}})</span>
                                </div>
                                {{-- {{dd($d->retail->akunGudang[0]->kabupaten->nama)}} --}}
                                <div class="col-md-4 border-right">
                                    Ke : <br><span class="text-14 bold">{{$d->retail->akunGudang[0]->nama}} ({{$d->retail->akunGudang[0]->kabupaten->nama}})</span>
                                </div>
                                <div class="col-md-4">
                                    Alamat Tujuan : <br><span class="text-14 bold">{{$d->alamat_pemesan}}</span>
                                </div>
                                @if ($d->metode_pembayaran == null)
                                    <div class="col-md-4 border-right">
                                        Status Pembayaran : <br><span class="text-14 bold">Berhutang</span>
                                    </div>
                                    <div class="col-md-4">
                                        No Pemesanan : <br><span class="text-14 bold">{{$d->nomor_pemesanan}}</span>
                                    </div>
                                @else
                                <div class="col-md-4 border-right">
                                    Metode Pembayaran : <br><span class="text-14 bold">{{ucwords($d->metode_pembayaran)}}</span>
                                </div>
                                <div class="col-md-4">
                                    No Pemesanan : <br><span class="text-14 bold">{{$d->nomor_pemesanan}}</span>
                                </div>
                                    <div class="col-md-4 border-right">
                                        Status Pembayaran : <br>
                                        <span class="text-14 bold">
                                            @if($d->status == 1)
                                                Belum Diverifikasi Penjual
                                            @else
                                                Lunas
                                            @endif
                                        </span>
                                    </div>
                                @endif
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
                                        {{$d->barangPesananBulky->nama_barang}}, Rp {{ number_format($d->barangPesananBulky->harga,0,',','.')}} ({{$d->barangPesananBulky->jumlah_barang.' '.$d->barangPesananBulky->satuan}})
                                        {{-- @endforeach --}}
                                    </h6>
                                </div>
                                <div class="col-md-4 d-flex valign-center justify-content-end">
                                    <a href="
                                        {{($d->status == 4) ? route('konfirmasi.terima.retail',$d->id) : '#'}}
                                    " class="btn btn-primary btn-sm
                                        {{($d->status == 4) ? '' : 'disabled'}}
                                    " title="Klik Jika Pesanan Anda Sudah Diterima" id="btn-terima">
                                        Konfirmasi Penerimaan
                                    </a>
                                </div>
                            </div>
                            @endif
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <form action="" target="_blank" id="form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Bukti Pembayaran</label><br>
                    <input required="" type="file" name="foto_bukti" class="">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
          {{-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> --}}
        </div>
        </form>
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
