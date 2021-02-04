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
                                        @foreach($d->barangPesanan as $b)
                                        {{$b->nama_barang}} ({{$b->jumlah_barang}} {{$b->satuan}})
                                        @endforeach
                                        , Ditolak Oleh Penjual
                                    </h6>
                                </div>
                            </div>
                            @elseif($d->storageOut == null)
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <span>
                                        Pesanan dengan Rincian :
                                        @foreach($d->barangPesanan as $b)
                                        {{$b->nama_barang}} ({{$b->jumlah_barang}} {{$b->satuan}})
                                        @endforeach
                                        , Belum Diproses Penjual
                                    </span>
                                    @if ($d->status == 5)
                                        @if($d->foto_bukti == null)
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fas fa-shopping-bag"></i> Ambil Barang</a>
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
                                        @if($d->foto_bukti == null)
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#exampleModal" onclick="uploadBukti({{ $d->id }})" data-id="{{ $d->id }}"><i class="fa fa-upload"></i> Upload Bukti Pembayaran</a>
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
                                    Dikirim Dari : <br><span class="text-14 bold">{{$d->storageOut->user->pengurusGudang->nama}} ({{$d->storageOut->user->pengurusGudang->kabupaten->nama}})</span>
                                    {{-- {{dd($d->storageOut)}} --}}
                                </div>
                                <div class="col-md-4 border-right">
                                    Ke : <br><span class="text-14 bold">{{$d->pelanggan->nama}} ({{$d->pelanggan->kabupaten->nama}})</span>
                                </div>
                                <div class="col-md-4">
                                    Alamat Tujuan : <br><span class="text-14 bold">{{$d->alamat_pemesan}}</span>
                                </div>
                                @if ($d->metode_pembayaran == null)
                                    <div class="col-md-12 border-right">
                                        Status Pemesanan : <br><span class="text-14 bold">Berhutang</span>
                                    </div>
                                @else
                                    <div class="col-md-12 border-right">
                                        Status Pemesanan : <br><span class="text-14 bold"> Bayar dengan metode {{$d->metode_pembayaran}}</span>
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
                                        @foreach($d->barangPesanan as $key => $i)
                                        {{($key != 0) ? ',' : ''}}
                                        {{$i->nama_barang}}, Rp {{ number_format($i->harga,0,',','.')}} ({{$i->jumlah_barang.' '.$i->satuan}})
                                        @endforeach
                                    </h6>
                                </div>
                                <div class="col-md-4 d-flex valign-center justify-content-end">
                                    <a href="
                                        {{($d->status == 4) ? route('konfirmasi.terima.warung',$d->id) : '#'}}
                                    " class="btn btn-primary btn-sm
                                        {{($d->status == 4) ? '' : 'disabled'}}
                                    " title="Klik Jika Pesanan Anda Sudah Diterima">
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
                    <center>-- Belum Ada Pesanan Ke Retail --</center>
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
        <form action="" id="form" method="post" enctype="multipart/form-data">
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
                    <input type="file" name="foto_bukti" class="">
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
        $('#form').attr('action',`/v1/upload/bukti/warung/${id}`);
    }
</script>
@endpush
