@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Barang';
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
            <a href="#" class="text-14">Data Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data</a>
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
                            <form action="{{route('barang.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" name="kode_barang" value="{{ $data->kode_barang }}" placeholder="Enter nama barang">
                                        @error('kode_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ $data->nama_barang }}" placeholder="Enter nama barang">
                                        @error('nama_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <span class="font-weight-bold">Pilih Kota dan Provinsi</span>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight">Provinsi</label>
                                        <select class="form-control provinsi-asal" name="province_origin">
                                            <option value="0">-- pilih provinsi asal --</option>
                                            @foreach ($provinces as $province => $value)
                                                <option value="{{ $province  }}" {{ $data->province_id == $province ? 'selected' : ''}}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight">Kota / Kabupaten</label>
                                        <select class="form-control kota-asal" name="city_origin">
                                            <option value="">-- pilih kota asal --</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Harga Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="satuan" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{  $data->harga_barang }}" placeholder="Enter harga barang">
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
                                        <input type="number" min="0" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ $data->jumlah }}" placeholder="Enter jumlah barang">
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
                                        <input type="number" min="0" id="hasil" class="form-control @error('harga_total') is-invalid @enderror" name="harga_total" value="{{ $data->harga_total }}" placeholder="Enter total harga barang">
                                        @error('harga_total')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kategori Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="kategori_id" id="" class="form-control">
                                            <option value="0">--Pilih Kategori--</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{$item->id}}" {{ $data->kategori_id == $item->id ? 'selected' : ''}}>{{$item->nama}}</option>
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
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ $data->satuan }}" placeholder="Enter satuan">
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Berat(GRAM) <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('berat') is-invalid @enderror" name="berat" value="{{ $data->berat }}" placeholder="Enter berat">
                                        @error('berat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Foto Barang <small class="text-success">*Boleh Tidak diisi</small></label>
                                        <input type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror" name="foto" value="{{ $data->foto }}" placeholder="Enter foto">
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
        $('#jumlah').on('keyup',(value) => {
            console.log($('#jumlah').val() * $('#satuan').val())
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
        $('#satuan').on('keyup',(value) => {
            console.log($('#jumlah').val() * $('#satuan').val())
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
</script>
{{--  --}}
@endpush
