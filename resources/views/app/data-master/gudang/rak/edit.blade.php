@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Rak Gudang';
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
            <a href="#" class="text-14">Data Master</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Gudang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Rak Gudang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data Rak</a>
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
                                <a href="{{route('rak.index', ['gudang' => $gudang->id])}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('rak.update', ['gudang' => $gudang->id, 'rak' => $data->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Nama Rak <small class="text-success">*Harus diisi</small></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $data->nama }}"  placeholder="Masukan Nama Rak">
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Panjang ( Meter ) <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('panjang') is-invalid @enderror" name="panjang" value="{{ $data->panjang }}" id="scanBarang" aria-describedby="barangStatus" placeholder="Masukan Panjang Rak ">
                                        @error('panjang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Lebar ( Meter ) <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('lebar') is-invalid @enderror" name="lebar" value="{{ $data->lebar }}" placeholder="Masukan Lebar Rak">
                                        @error('lebar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Tinggi ( Meter ) <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('tinggi') is-invalid @enderror" name="tinggi" value="{{ $data->tinggi }}" placeholder="Masukan Tinggi Rak">
                                        @error('tinggi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Maksimal Kapasitas Berat ( Kg ) <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('kapasitas_berat') is-invalid @enderror" name="kapasitas_berat" value="{{ $data->kapasitas_berat }}" placeholder="Masukan Berat...">
                                        @error('kapasitas_berat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Jumlah Tingkatan Rak <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('tingkat') is-invalid @enderror" name="tingkat" value="{{ $data->tingkat_count }}" placeholder="Masukan Jumlah Tingkat Rak...">
                                        @error('tingkat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
<script>
</script>
@endpush
