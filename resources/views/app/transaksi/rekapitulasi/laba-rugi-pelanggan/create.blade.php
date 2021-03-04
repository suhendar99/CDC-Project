@php
        $icon = 'book';
        $pageTitle = 'Tambah Laba Rugi';
        $dashboard = true;
        $bulan = array(
            ['no'=>'1','val' => 'Januari'],
            ['no'=>'2','val' => 'Februari'],
            ['no'=>'3','val' => 'Maret'],
            ['no'=>'4','val' => 'April'],
            ['no'=>'5','val' => 'Mei'],
            ['no'=>'6','val' => 'Juni'],
            ['no'=>'7','val' => 'Juli'],
            ['no'=>'8','val' => 'Agustus'],
            ['no'=>'9','val' => 'September'],
            ['no'=>'10','val' => 'Oktober'],
            ['no'=>'11','val' => 'November'],
            ['no'=>'12','val' => 'Desember'],
        );


        $dataBulan = [];

        foreach ($data as $key => $value) {
            $dataBulan[] = $value->bulan;
        }

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
            <a href="#" class="text-14">Laporan</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Laba Rugi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Laba Rugi</a>
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
                                                    @foreach($bulan as $b)
                                                        @if(!in_array($b['no'],$dataBulan))
                                                            <option value="{{$b['no']}}" @if(old('bulan') == $b['no']) selected @endif>{{$b['val']}}</option>
                                                        @endif
                                                    @endforeach
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
                                                <input type="number" name="laba_bersih" class="form-control @error('laba_bersih') is-invalid @enderror" id="laba_bersih" placeholder="Masukan Jumlah Laba Bersih" aria-describedby="inputGroupPrepend" value="{{old('laba_bersih')}}" required>
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
        $('#laba_bersih').val( parseInt($('#penjualan').val()) - (parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val())))
    }
    $('#pembelian').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val( parseInt($('#penjualan').val()) - (parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val())))
    })
    $('#biaya_operasional').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val( parseInt($('#penjualan').val()) - (parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val())))
    })
    $('#penjualan').on('keyup',(value) => {
        console.log()
        $('#laba_bersih').val( parseInt($('#penjualan').val()) - (parseInt($('#pembelian').val()) + parseInt($('#biaya_operasional').val())))
    })
</script>
{{--  --}}
@endpush
