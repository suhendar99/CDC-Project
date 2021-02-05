@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Laba Rugi Bulky';
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
        // dd($bulan);
        
        $dataBulan = [];

        foreach ($data as $key => $value) {
            $dataBulan[] = $value->bulan;
        }

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
            <a href="#" class="text-14">Data Laba Rugi Bulky</a>
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
                                <a href="{{route('bulky.laba-rugi.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form action="{{route('bulky.laba-rugi.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Bulan <small class="text-success">*Harus diisi</small></label>
                                        <select name="bulan" id="barang" class="form-control">
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
                                    <div class="form-group col-md-6">
                                        <label>Laba Kotor <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('laba_kotor') is-invalid @enderror" name="laba_kotor" value="{{ old('laba_kotor') }}">
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
                                            <input type="number" class="form-control @error('penjualan') is-invalid @enderror" name="penjualan" value="{{ old('penjualan') }}">
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
                                            <input type="number" class="form-control @error('pembelian') is-invalid @enderror" name="pembelian" value="{{ old('pembelian') }}">
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
                                        <input type="number" class="form-control @error('biaya_operasional') is-invalid @enderror" name="biaya_operasional" value="{{ old('biaya_operasional') }}">
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