@php
        $icon = 'shopping_cart';
        $pageTitle = 'Pemesanan Barang';
        $dashboard = true;
        // $rightbar = true;
@endphp
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
            <a href="#" class="text-14">Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Pemesanan barang</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{-- <a href="{{route('kategoriBarang.index')}}" class="btn btn-primary btn-sm">Kembali</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('pemesanan.store',$id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('jumlah_barang') is-invalid @enderror" name="jumlah_barang" value="{{ old('jumlah_barang') }}">
                                                @error('jumlah_barang')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Pembayaran <small class="text-success">*Harus diisi</small></label>
                                                <select name="pembayaran" id="" class="form-control">
                                                    <option value="">-- Pilih Pembayaran --</option>
                                                    <option value="sekarang">Bayar sekarang</option>
                                                    <option value="nanti">Bayar nanti</option>
                                                </select>
                                                @error('pembayaran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                                <select name="metode_pembayaran" id="" class="form-control">
                                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                                    <option value="1">Transfer Ke(Rekening Penjual)</option>
                                                </select>
                                                @error('metode_pembayaran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">

</script>
{{--  --}}
@endpush
