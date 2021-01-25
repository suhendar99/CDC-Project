@php
        $icon = 'storage';
        $pageTitle = 'Edit Koperasi';
        $dashboard = true;
        $admin = true;
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
            <a href="#" class="text-14">Data Master</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Koperasi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Koperasi</a>
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
                                <a href="{{route('koperasi.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('koperasi.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Nama Koperasi <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('nama_koperasi') is-invalid @enderror" name="nama_koperasi" value="{{ $data->nama_koperasi }}">
                                                @error('nama_koperasi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Jenis Koperasi <small class="text-success">*Harus diisi</small></label>
                                                <select name="jenis_koperasi" id="" class="form-control">
                                                    <option value="Koperasi Produsen" {{ $data->jenis_koperasi == 'Koperasi Produsen' ? "selected":"" }}>Koperasi Produsen</option>
                                                    <option value="Koperasi Konsumen" {{ $data->jenis_koperasi == 'Koperasi Konsumen' ? "selected":"" }}>Koperasi Konsumen</option>
                                                    <option value="Koperasi Simpan Pinjam" {{ $data->jenis_koperasi == 'Koperasi Simpan Pinjam' ? "selected":"" }}>Koperasi Simpan Pinjam</option>
                                                    <option value="Koperasi Pemasaran" {{ $data->jenis_koperasi == 'Koperasi Pemasaran' ? "selected":"" }}>Koperasi Pemasaran</option>
                                                    <option value="Koperasi Jasa" {{ $data->jenis_koperasi == 'Koperasi Jasa' ? "selected":"" }}>Koperasi Jasa</option>
                                                </select>
                                                @error('jenis_koperasi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Sektor Usaha <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('sektor_usaha') is-invalid @enderror" name="sektor_usaha" value="{{ $data->sektor_usaha }}">
                                                @error('sektor_usaha')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                                <textarea name="alamat" id="" cols="10" rows="5" class="form-control">{{$data->alamat}}</textarea>
                                                @error('alamat')
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
