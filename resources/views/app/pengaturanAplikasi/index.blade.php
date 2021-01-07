@php
        $icon = 'settings';
        $pageTitle = 'Pengaturan Aplikasi';
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
            <a href="#" class="text-14">Pengaturan Aplikasi</a>
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
                <form action="{{ route('setApp.store') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-6 pt-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <p>Logo Tab Browser</p>
                                </div>
                                <div class="card-body">
                                    @if(!$data->logo_tab == null)
                                        <img class="card-img-top" width="110" height="110" style="border-radius: 10px; height: 100px; width: auto; object-fit: scale-down;" src="{{ asset($data->logo_tab) }}">
                                    @else
                                        <i class="mdi mdi-image-broken-variant" style="font-size: 100px;"></i>
                                    @endif
                                    <div class="form-group">
                                    {{-- <label for="first-name-vertical">Logo Tab</label> --}}
                                    <input type="file" id="first-name-vertical" class="form-control @error('logo_tab') is-invalid @enderror" name="logo_tab" placeholder="Logo Tab" value="{{ $data->logo_tab }}">
                                    @error('logo_tab')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pt-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <p>Logo Aplikasi</p>
                                </div>
                                <div class="card-body">
                                    @if(!$data->logo_app == null)
                                        <img class="card-img-top" width="110" height="110" style="border-radius: 10px; height: 100px; width: auto; object-fit: scale-down;" src="{{ asset($data->logo_app) }}">
                                    @else
                                        <i class="mdi mdi-image-broken-variant mb-2" style="font-size: 100px;"></i>
                                    @endif
                                    <div class="form-group">
                                    {{-- <label for="first-name-vertical">Logo Aplikasi</label> --}}
                                    <input type="file" id="first-name-vertical" class="form-control @error('logo_app') is-invalid @enderror" name="logo_app" placeholder="Logo Aplikasi" value="{{ $data->logo_app }}">
                                    @error('logo_app')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="first-name-vertical">Nama Tab Browser</label>
                            <input type="text" id="first-name-vertical" class="form-control @error('nama_tab') is-invalid @enderror" name="nama_tab" placeholder="Nama Tab" value="{{ $data->nama_tab }}">
                            @error('nama_tab')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="first-name-vertical">Nama Aplikasi</label>
                            <input type="text" id="first-name-vertical" class="form-control @error('nama_app') is-invalid @enderror" name="nama_app" placeholder="Nama Aplikasi" value="{{ $data->nama_app }}">
                            @error('nama_app')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="first-name-vertical">Copyright Text</label>
                            <input type="text" id="first-name-vertical" class="form-control @error('copyright_text') is-invalid @enderror" name="copyright_text" placeholder="Copyright Text" value="{{ $data->copyright_text }}">
                            @error('copyright_text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="first-name-vertical">Copyright Link</label>
                            <input type="text" id="first-name-vertical" class="form-control @error('copyright_link') is-invalid @enderror" name="copyright_link" placeholder="Copyright Link" value="{{ $data->copyright_link }}">
                            @error('copyright_link')
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
