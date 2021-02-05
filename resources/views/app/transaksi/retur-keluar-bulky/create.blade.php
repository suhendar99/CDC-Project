@php
        $icon = 'storage';
        $pageTitle = 'Tambah Data Retur Keluar';

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
            <a href="#" class="text-14">Data Retur Keluar</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Data Retur Keluar</a>
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
                                <a href="{{route('bulky.retur.keluar.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('bulky.retur.keluar.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Nomor Kwitansi <small class="text-success">*Harus diisi</small></label>
                                    <input type="numeric" class="form-control @error('nomor_kwitansi') is-invalid @enderror" name="nomor_kwitansi" value="{{ old('nomor_kwitansi') }}" placeholder="Masukan Nomor Kwitansi">
                                    @error('nomor_kwitansi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="barang_kode" id="barang" class="form-control">
                                            <option value="0">--Pilih Pesanan--</option>
                                            @foreach ($barang as $pesan)
                                                <option value="{{$pesan->barang->kode_barang}}" {{ old('barang_kode') == $pesan->barang->kode_barang ? 'selected' : ''}} data-satuan="{{ $pesan->barang->satuan }}" data-jumlah="{{ $pesan->jumlah }}">{{$pesan->barang->kode_barang}} | {{ $pesan->bulky->nama }} | {{$pesan->barang->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                        @error('barang_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend">-</span>
                                            </div>
                                        </div>
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengembalian <small class="text-success">*Harus diisi</small></label>
                                    <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}" placeholder="Enter tanggal_pengembalian">
                                    @error('tanggal_pengembalian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
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
    $('#barang').change(function(event) {
        /* Act on the event */
        
        if ($('#barang option:selected').data('satuan') == 'Kg') {
            $('#satuanAppend').text('Ton')
            $('#jumlah').attr('type', 'numeric');
            $('#jumlah').val($('#barang option:selected').data('jumlah'));
        } else {
            $('#satuanAppend').text($('#barang option:selected').data('satuan'))
            $('#jumlah').attr('type', 'number');
            $('#jumlah').val($('#barang option:selected').data('jumlah'));
        }

    });
</script>
@endpush
