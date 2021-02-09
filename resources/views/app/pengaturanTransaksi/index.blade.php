@php
        $icon = 'settings';
        $pageTitle = 'Pengaturan Transaksi';
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
            <a href="#" class="text-14">Pengaturan</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Pengaturan Transaksi</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="row match-height">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h4 class="card-title">Setting App</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaturanTransaksi.store') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                        <label for="first-name-vertical">Jumlah Pajak (%)</label>
                        <input type="number" min="1" id="first-name-vertical" class="form-control @error('pajak') is-invalid @enderror" name="pajak" placeholder="Nama Tab" value="{{ $data->pajak }}">
                        @error('pajak')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                        <label for="first-name-vertical">Biaya Admin (Rp)</label>
                        <input type="number" min="1" id="first-name-vertical" class="form-control @error('biaya_admin') is-invalid @enderror" name="biaya_admin" placeholder="Nama Aplikasi" value="{{ $data->biaya_admin }}">
                        @error('biaya_admin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                        <label for="first-name-vertical">Biaya Merchant (Rp)</label>
                        <input type="number" min="1" id="first-name-vertical" class="form-control @error('biaya_merchant') is-invalid @enderror" name="biaya_merchant" placeholder="Nama Aplikasi" value="{{ $data->biaya_merchant }}">
                        @error('biaya_merchant')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mr-1 mb-1 btn-sm"><i class="mdi mdi-check"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>

</script>
@endpush
