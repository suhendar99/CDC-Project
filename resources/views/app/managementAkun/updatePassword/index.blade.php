@php
    $icon = 'dashboard';
    $pageTitle = 'Edit Password';
    if (Auth::user()->pembeli_id != null) {
        $nosidebar = true;
        $shop = true;
        $detail = true;
    }
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="container">
    <div class="row valign-center mb-2">
        <div class="col-md-8 col-sm-12 valign-center py-2">
            <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
            <div>
              <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('failed'))
		    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		    	<i data-feather="alert-circle"></i>
		        {{ session()->get('failed') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    @endif
            <div class="card card-block d-flex">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('setPass.action')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$auth->id}}">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Password Lama <small class="text-success">*Harus diisi</small></label>
                                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password">
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Password Baru <small class="text-success">*Harus diisi</small></label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label>Konfirmasi Password Baru <small class="text-success">*Harus diisi</small></label>
                                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation">
                                        @error('new_password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                  <div class="row">
                                      <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
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
