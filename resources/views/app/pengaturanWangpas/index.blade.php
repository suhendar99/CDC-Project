@php
        $icon = 'settings';
        $pageTitle = 'Pengaturan Wangpas';
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
            <a href="#" class="text-14">Pengaturan Wangpas</a>
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
                <form action="{{ route('pengaturan-wangpas.store') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                <label for="first-name-vertical">URL Pendaftaran Wangpas</label>
                                <input type="url" id="first-name-vertical" class="form-control @error('pendaftaran') is-invalid @enderror" name="pendaftaran" value="{{ $data->pendaftaran }}">
                                @error('pendaftaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                <label for="first-name-vertical">URL Top Up</label>
                                <input type="url" id="first-name-vertical" class="form-control @error('top_up') is-invalid @enderror" name="top_up" value="{{ $data->top_up }}">
                                @error('top_up')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                <label for="first-name-vertical">URL Pembayaran</label>
                                <input type="url" id="first-name-vertical" class="form-control @error('pembayaran') is-invalid @enderror" name="pembayaran" value="{{ $data->pembayaran }}">
                                @error('pembayaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                <label for="first-name-vertical">URL Cek Saldo</label>
                                <input type="url" id="first-name-vertical" class="form-control @error('cek_saldo') is-invalid @enderror" name="cek_saldo" value="{{ $data->cek_saldo }}">
                                @error('cek_saldo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1 btn-sm"><i class="mdi mdi-check"></i> Simpan</button>
                            </div>
                        </div>
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
