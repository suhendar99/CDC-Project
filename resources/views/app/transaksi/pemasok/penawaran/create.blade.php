@php
        $icon = 'storage';
        $pageTitle = 'Buat Penawaran';
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
            <a href="#" class="text-14">Transaksi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Penawaran</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Buat Penawaran</a>
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
                                <a href="{{route('penawaran-pemasok.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('penawaran-pemasok.update',$gudang->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Barang Untuk Ditawarkan <small class="text-success">*Harus diisi</small></label>
                                                <select name="barang_id" id="barang" class="form-control @error('barang_id') is-invalid @enderror">
                                                    <option value="0">-- Pilih Barang --</option>
                                                    @foreach ($barang as $b)
                                                        <option value="{{$b->id}}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>{{$b->nama_barang}}</option>
                                                    @endforeach
                                                </select>
                                                @error('barang_id')
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
                                                <label>Harga Barang</label>
                                                <div class="input-group mb-3">
                                                  <input type="number" min="1" max="" id="hargaBarang" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{ old('harga_barang') }}" aria-describedby="satuanAppend">
                                                  <div class="input-group-append">
                                                    <span class="input-group-text" id="satAppend"></span>
                                                  </div>
                                                  @error('harga_barang')
                                                      <span class="invalid-feedback" role="alert">
                                                          <strong>{{ $message }}</strong>
                                                      </span>
                                                  @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="satuan" id="satuan">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                                <div class="input-group mb-3">
                                                  <input type="number" min="1" max="" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success btn-sm">Tawarkan</button>
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
    $('#barang').change(function () {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/api/v1/barang/"+id,
            dataType: "json",
            success: function (response) {
                var data = response.data
                $('#hargaBarang').val(data.harga_barang);
                $('#satuanAppend').text(data.satuan);
                $('#satAppend').text('per-'+data.satuan);
                $('#satuan').val(data.satuan);
                $('#jumlah').attr("max",data.jumlah);
            }
        });
    });
</script>
{{--  --}}
@endpush

