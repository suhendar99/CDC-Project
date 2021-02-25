@php
        $icon = 'shopping_cart';
        $pageTitle = 'Buat Surat Piutang';
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
            <a href="#" class="text-14">Data Penyimpanan Keluar</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Buat Surat Piutang</a>
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
                                {{-- <a href="{{route('kategoriBarang.index')}}" class="btn btn-primary btn-sm">Kembali</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('surat-piutang-warung-retail.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="jumlah_uang_digits" id="jumlah_uang" value="{{$data->pemesanan->barangPesanan[0]->harga}}">
                                <input type="hidden" name="jumlah_uang_word" id="word">
                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-16">
                                                <label>Nama Pihak Pertama <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('pihak_pertama') is-invalid @enderror" name="pihak_pertama" value="{{ $data->pemesanan->penerima_po }}">
                                                @error('pihak_pertama')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-16">
                                                <label>Nama Pihak Kedua <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('pihak_kedua') is-invalid @enderror" name="pihak_kedua" value="{{ $data->pemesanan->nama_pemesan }}">
                                                @error('pihak_kedua')
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
                                        <div class="form-group">
                                            <div class="col-md-16">
                                                <label>Tempat Pembuatan <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" value="{{ old('tempat') }}">
                                                @error('tempat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-16">
                                                <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                                <textarea name="keterangan" id="keterangan" cols="10" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{old('keterangan')}}</textarea>
                                                @error('keterangan')
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
    var digit =  JSON.parse('{!! json_encode($data->pemesanan->barangPesanan[0]->harga) !!}')
    console.log(digit);
    var a = ['','Satu ','Dua ','Tiga ','Empat ', 'Lima ','Enam ','Tujuh ','Delapan ','Sembilan ','Sepuluh ','Sebelas ','Dua Belas ','Tiga Belas ','Empat Belas ','Lima Belas ','Enam Belas ','Tujuh Belas ','Delapan Belas ','Sembilan Belas '];
    var b = ['', '', 'Dua Puluh','Tiga Puluh','Empat Puluh','Lima Puluh', 'Enam Puluh','Tujuh Puluh','Delapan Puluh','Sembilan Puluh'];
    var c = ['', '', 'Dua Ratus', 'Tiga Ratus', 'Empat Ratus', 'Lima Ratus', 'Enam Ratus', 'Tujuh Ratus', 'Delapan Ratus', 'Sembilan Ratus'];

    function inWords (num) {
        if ((num = num.toString()).length > 10) return 'overflow';
        n = ('000000000' + num).substr(-10).match(/^(\d{1})(\d{3})(\d{3})(\d{1})(\d{2})$/);
        console.log(n);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Miliar ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || c[n[2][0]] + ' ' + b[n[2][1]] + ' ' + a[n[2][2]]) + 'Juta ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || c[n[3][0]] + ' ' + b[n[3][1]] + ' ' + a[n[3][2]]) + 'Ribu ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Ratus ' : '';
        str += (n[5] != 0) ? ((str != '') ? ' ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        console.log(str);
        return str;
    }

    document.getElementById('jumlah_uang').oninput = function () {
        // document.getElementById('word').innerHTML = inWords(document.getElementById('jumlah_uang').value);
        $('#word').val(inWords(digit))
    };
    console.log($('#word').val(inWords(digit)));
</script>
{{--  --}}
@endpush
