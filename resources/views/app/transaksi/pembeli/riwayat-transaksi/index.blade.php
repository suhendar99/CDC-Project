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
                                        Pesanan Dengan Rincian :
                                        @foreach($d->pemesananPembeliItem as $b)
                                        {{$b->nama_barang}} ({{$b->jumlah_barang}} {{$b->satuan}})
                                        @endforeach
                                        , Ditolak Oleh Penjual
                                    </h6>
                                </div>
                            </div>
                            @elseif($d->barangKeluar == null)
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <span>
                                        Pesanan dengan Rincian :
                                        @foreach($d->pemesananPembeliItem as $b)
                                        {{$b->nama_barang}} ({{$b->jumlah_barang}} {{$b->satuan}})
                                        @endforeach
                                        , Belum Diproses Penjual
                                    </span>
                                    @if ($d->status == 6)
                                        @if($d->foto_bukti == null)
                                        <a class="btn btn-sm btn-primary" href="#"><i class="fas fa-shopping-bag"></i> Ambil Barang</a>
                                        @else
                                        <a class="btn btn-sm btn-primary disabled" href="#">Mohon Tunggu Validasi Penjual ...</a>
                                        @endif
                                    @else
                                        @if($d->foto_bukti == null)
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#exampleModal" onclick="uploadBukti({{ $d->id }})" data-id="{{ $d->id }}">Kirim Bukti Pembayaran</a>
                                        @else
                                        <a class="btn btn-sm btn-primary disabled" href="#">Mohon Tunggu Validasi Penjual ...</a>
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
                                            Pesanan Sedang Dikirim
                                        </span>
                                        @elseif($d->status == 5)
                                        <span class="badge rounded-pill bg-my-success">
                                            Pesanan Diterima
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    Dikirim Dari : <br><span class="text-14 bold">{{$d->penerima_po}} ({{$d->pelanggan->kabupaten->nama}})</span>
                                    {{-- {{dd($d->storageOut)}} --}}
                                </div>
                                <div class="col-md-4 border-right">
                                    Ke : <br><span class="text-14 bold">{{$d->nama_pemesan}} ({{$d->pelanggan->kabupaten->nama}})</span>
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
                                        {{($d->status == 4) ? route('konfirmasi.terima.pembeli',$d->id) : '#'}}
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
        $('#form').attr('action',`/v1/upload/bukti/pembeli/${id}`);
    }
</script>
@endpush
