@php
        $icon = 'shopping_cart';
        $pageTitle = 'Tambah Kategori Induk';
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
            <a href="#" class="text-14">Data Pembeli</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Kategori Induk</a>
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
                                <a href="{{route('labaRugiPelanggan.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('labaRugiPelanggan.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Bulan <small class="text-success">*Harus dipilih</small></label>
                                                <select name="bulan" id="" class="form-control @error('bulan') is-invalid @enderror">
                                                    <option value="">--Pilih Bulan--</option>
                                                    <option value="1" @if(old('bulan') == 1) selected @endif>Januari</option>
                                                    <option value="2" @if(old('bulan') == 2) selected @endif>Februari</option>
                                                    <option value="3" @if(old('bulan') == 3) selected @endif>Maret</option>
                                                    <option value="4" @if(old('bulan') == 4) selected @endif>April</option>
                                                    <option value="5" @if(old('bulan') == 5) selected @endif>Mei</option>
                                                    <option value="6" @if(old('bulan') == 6) selected @endif>Juni</option>
                                                    <option value="7" @if(old('bulan') == 7) selected @endif>Juli</option>
                                                    <option value="8" @if(old('bulan') == 8) selected @endif>Agustus</option>
                                                    <option value="9" @if(old('bulan') == 9) selected @endif>September</option>
                                                    <option value="10" @if(old('bulan') == 10) selected @endif>Oktober</option>
                                                    <option value="11" @if(old('bulan') == 11) selected @endif>November</option>
                                                    <option value="12" @if(old('bulan') == 12) selected @endif>Desember</option>
                                                </select>
                                                @error('bulan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustomUsername">Laba Kotor <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="number" min="1" name="laba_kotor" class="form-control @error('laba_kotor') is-invalid @enderror" id="laba_kotor" placeholder="Masukan Jumlah Laba Kotor" aria-describedby="inputGroupPrepend" value="{{old('laba_kotor')}}" required>
                                                @error('laba_kotor')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustomUsername">Pembelian <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="number" min="1" name="pembelian" class="form-control @error('pembelian') is-invalid @enderror" id="pembelian" placeholder="Masukan Pembelian" aria-describedby="inputGroupPrepend" value="{{old('pembelian')}}" required>
                                                @error('pembelian')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustomUsername">Biaya Operasional <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="number" min="1" name="biaya_operasional" class="form-control @error('biaya_operasional') is-invalid @enderror" id="biaya_operasional" placeholder="Masukan Jumlah Biaya Operasional" aria-describedby="inputGroupPrepend" value="{{old('biaya_operasional')}}" required>
                                                @error('biaya_operasional')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustomUsername">Penjualan <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="number" min="1" name="penjualan" class="form-control @error('penjualan') is-invalid @enderror" id="penjualan" placeholder="Masukan Penjualan" aria-describedby="inputGroupPrepend" value="{{old('penjualan')}}" required>
                                                @error('penjualan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustomUsername">Laba Bersih <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="number" min="1" name="laba_bersih" class="form-control @error('laba_bersih') is-invalid @enderror" id="laba_bersih" placeholder="Masukan Jumlah Laba Bersih" aria-describedby="inputGroupPrepend" value="{{old('laba_bersih')}}" required>
                                                @error('laba_bersih')
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
    function inputed(){
        $('#laba_bersih').val(parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val()) - parseInt($('#penjualan').val()))
    }
    $('#pembelian').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val(parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val()) - parseInt($('#penjualan').val()))
    })
    $('#biaya_operasional').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val(parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val()) - parseInt($('#penjualan').val()))
    })
    $('#penjualan').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val(parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val()) - parseInt($('#penjualan').val()))
    })
</script>
{{--  --}}
@endpush
