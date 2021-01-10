@php
        $icon = 'storage';
        $pageTitle = 'Tambah Data Barang';
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
            <a href="#" class="text-14">Data Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Data</a>
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

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('barang.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('barang.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- <input type="hidden" name="provinces_origin" id="provinceVal" value=""> --}}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Enter nama barang">
                                        @error('nama_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kategori Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="kategori_id" id="" class="form-control @error('kategori_id') is-invalid @enderror">
                                            <option value="0">--Pilih Kategori--</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{$item->id}}" {{ old('kategori_id') == $item->id ? 'selected' : ''}}>{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Deskripsi Barang <small class="text-success">*Harus diisi</small></label>
                                        <textarea name="deskripsi" id="" cols="10" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{old('deskripsi')}}</textarea>
                                        @error('nama_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Harga Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="satuan" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{ old('harga_barang') }}" placeholder="Enter harga barang">
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Enter jumlah barang">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Total harga <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="hasil" class="form-control @error('harga_total') is-invalid @enderror" name="harga_total" value="{{ old('harga_total') }}" placeholder="Total harga barang" readonly>
                                        @error('harga_total')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan') }}" placeholder="Enter satuan">
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Foto Barang <small class="text-success">*Boleh Tidak diisi & bisa di pilih banyak</small></label>
                                        <input type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror " name="foto[]" value="{{ old('foto') }}" placeholder="Enter foto" multiple>
                                        @error('foto')
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
{{-- Chart Section --}}
<script type="text/javascript">
    function inputed(){
        $('#hasil').val($('#jumlah').val() * $('#satuan').val())
    }
    $('#jumlah').on('keyup',(value) => {
        console.log()
        $('#hasil').val($('#jumlah').val() * $('#satuan').val())
    })
    $('#satuan').on('keyup',(value) => {
        console.log()
        $('#hasil').val($('#jumlah').val() * $('#satuan').val())
    })
</script>
{{--  --}}
@endpush
