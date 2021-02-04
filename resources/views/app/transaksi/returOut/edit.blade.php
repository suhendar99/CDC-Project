@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Pengembalian Barang Ke Bulky';

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
            <a href="#" class="text-14">Data Transaksi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Pengembalian Barang Ke Bulky</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data Pengembalian Barang</a>
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
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('returOut.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('returOut.update', $data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <select name="kwitansi_bulky_id" id="" class="form-control">
                                            <option value="0">--Pilih Pesanan--</option>
                                            <option value="{{$data->kwitansiBulky->id}}" selected>{{$data->kwitansiBulky->kode}} | {{ $data->kwitansiBulky->bulky->nama }} | {{ $data->kwitansiBulky->pemesananBulky->barangPesananBulky->nama_barang }} </option>
                                            @foreach ($kwitansi as $pesan)
                                                <option value="{{$pesan->id}}">{{$pesan->kode}} | {{ $pesan->bulky->nama }} | {{ $pesan->pemesananBulky->barangPesananBulky->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        @error('kwitansi_bulky_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Pengembalian <small class="text-success">*Harus diisi</small></label>
                                        <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ $data->tanggal_pengembalian }}" placeholder="Enter tanggal_pengembalian">
                                        @error('tanggal_pengembalian')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ $data->keterangan }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
<script>
</script>
@endpush
