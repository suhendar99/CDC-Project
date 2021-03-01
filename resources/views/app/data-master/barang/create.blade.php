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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Masukan nama barang">
                                            @error('nama_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Deskripsi Barang <small class="text-success">*Harus diisi</small></label>
                                            <textarea name="deskripsi" id="" cols="10" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{old('deskripsi')}}</textarea>
                                            @error('nama_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                            <select name="satuan" id="satuanOn" class="form-control @error('satuan') is-invalid @enderror">
                                                <option value="">-- Pilih Satuan --</option>
                                                <option value="Ton">Ton</option>
                                                {{-- @foreach ($satuan as $item)
                                                    <option value="{{$item->satuan}}" {{ old('satuan') == $item->satuan ? 'selected' : ''}}>{{$item->satuan}}</option>
                                                @endforeach --}}
                                            </select>
                                            @error('satuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Harga Barang<small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group mb-3">
                                              <input type="number" type="number" id="harga" class="form-control @error('jumlah') is-invalid @enderror" name="harga_barang" value="{{ old('harga_barang') }}" aria-describedby="satAppend">
                                              <div class="input-group-append">
                                                <span class="input-group-text" id="satAppend">/</span>
                                              </div>
                                              @error('harga_barang')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Keuntungan <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group mb-3">
                                              <input type="number" type="number" id="keuntungan" class="form-control @error('jumlah') is-invalid @enderror" name="keuntungan" value="{{ old('keuntungan') }}">
                                              <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                              </div>
                                              @error('keuntungan')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group mb-3">
                                              <input type="number" type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                              <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend"></span>
                                              </div>
                                              @error('jumlah')
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
                                            <label>Total harga <small class="text-success">*Harus diisi</small></label>
                                            <input type="number" min="0" id="hasil" class="form-control @error('harga_total') is-invalid @enderror" name="harga_total" value="{{ old('harga_total') }}" placeholder="Total harga barang" readonly>
                                            @error('harga_total')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto Barang <small class="text-success">*Harus diisi</small></label>
                                            <input type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror " name="foto[]" value="{{ old('foto') }}" placeholder="Masukan foto" multiple>
                                            @error('foto')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
    $("#satuanOn").change(function () {
        var satuan = $(this).val();
        $('#satuanAppend').text(satuan);
        $('#satAppend').text('Per-'+satuan);
    });
    function inputed(){
        $('#hasil').val($('#jumlah').val() * $('#keuntungan').val()/100 * $('#harga').val())
    }
    $('#jumlah').on('keyup',(value) => {
        console.log()
        $('#hasil').val($('#jumlah').val() * $('#keuntungan').val()/100 * $('#harga').val())
    })
    $('#harga').on('keyup',(value) => {
        console.log()
        $('#hasil').val($('#jumlah').val() * $('#keuntungan').val()/100 * $('#harga').val())
    })
    $('#keuntungan').on('keyup',(value) => {
        console.log()
        $('#hasil').val($('#jumlah').val() * $('#keuntungan').val()/100 * $('#harga').val())
    })
</script>
{{--  --}}
@endpush
