@php
        $icon = 'storage';
        $pageTitle = 'Edit Laba Rugi Retail';
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
            <a href="#" class="text-14">Laporan</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Laba Rugi Retail</a>
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
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('retail.laba-rugi.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form action="{{route('retail.laba-rugi.update', $data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="bulan" id="barang" class="form-control">
                                            <option value="1" @if($data->bulan == 1) selected @endif>Januari</option>
                                            <option value="2" @if($data->bulan == 2) selected @endif>Februari</option>
                                            <option value="3" @if($data->bulan == 3) selected @endif>Maret</option>
                                            <option value="4" @if($data->bulan == 4) selected @endif>April</option>
                                            <option value="5" @if($data->bulan == 5) selected @endif>Mei</option>
                                            <option value="6" @if($data->bulan == 6) selected @endif>Juni</option>
                                            <option value="7" @if($data->bulan == 7) selected @endif>Juli</option>
                                            <option value="8" @if($data->bulan == 8) selected @endif>Agustus</option>
                                            <option value="9" @if($data->bulan == 9) selected @endif>September</option>
                                            <option value="10" @if($data->bulan == 10) selected @endif>Oktober</option>
                                            <option value="11" @if($data->bulan == 11) selected @endif>November</option>
                                            <option value="12" @if($data->bulan == 12) selected @endif>Desember</option>
                                        </select>
                                        @error('bulan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Laba Kotor <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('laba_kotor') is-invalid @enderror" name="laba_kotor" value="{{ $data->laba_kotor }}">
                                        </div>
                                        @error('laba_kotor')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Total Penjualan <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('penjualan') is-invalid @enderror" name="penjualan" value="{{ $data->penjualan }}">
                                        </div>
                                        @error('penjualan')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Total Pembelian <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('pembelian') is-invalid @enderror" name="pembelian" value="{{ $data->pembelian }}">
                                        </div>
                                        @error('pembelian')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Operasional <small class="text-success">*Harus diisi</small></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="number" class="form-control @error('biaya_operasional') is-invalid @enderror" name="biaya_operasional" value="{{ $data->biaya_operasional }}">
                                    </div>
                                    @error('biaya_operasional')
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
</script>
@endpush
