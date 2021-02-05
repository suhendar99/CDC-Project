@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Pemesanan Keluar';
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Rekapitulasi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Pemesanan Keluar</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Buat Data</a>
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
                                <a href="{{route('bulky.pemesanan.keluar.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form action="{{route('bulky.pemesanan.keluar.update', $data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @if(Auth::user()->pengurusGudangBulky->status == 1)
                                    <div class="form-group">
                                        <label>Pilih Gudang <small class="text-success">*Harus diisi</small></label>
                                        <select name="bulky_id" id="gudang" class="form-control">
                                            <option value="">~ Pilih Gudang Bulky ~</option>
                                            @foreach($bulky as $gud)
                                            <option value="{{ $gud->id }}">{{ $gud->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('bulky_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Pilih Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="barang_kode" id="barang" class="form-control">
                                            <option value="">~ Pilih Barang ~</option>
                                            @foreach($barangs as $barang)
                                            <option value="{{ $barang->kode_barang }}" data-satuan="{{ $barang->satuan }}" @if($barang->kode_barang == $data->barang_kode) selected @endif>{{ $barang->kode_barang }} | {{ $barang->nama_barang }}</option>
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
                                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ $data->jumlah }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuan">{{ $data->satuan }}</span>
                                            </div>
                                        </div>
                                        @error('jumlah')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Telepon <small class="text-success">*Harus diisi</small></label>
                                        <input type="numeric" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ $data->telepon }}">
                                        @error('telepon')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                    <div id="pilihMetode" class="form-group col-md-6">
                                        <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran"  >
                                            <option value="">-- Pilih Metode --</option>
                                            <option value="transfer">Transfer Ke (Rekening Penjual)</option>
                                            <option value="wangpas">Wangpas</option>
                                            <option value="bayar di tempat">Bayar di tempat</option>
                                        </select>
                                        @error('metode_pembayaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                    <textarea name="alamat_pemesan" class="form-control">{{ $data->alamat_pemesan }}</textarea>
                                    @error('alamat_pemesan')
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
<script src="{{ asset('js/onscan.js') }}"></script>
<script>
    $('#barang').change(function(event) {
        /* Act on the event */
        $('#satuan').text($('#barang option:selected').data('satuan'));
    });
</script>
@endpush
