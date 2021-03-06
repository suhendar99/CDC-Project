@php
        $icon = 'storage';
        $pageTitle = 'Edit Bank Akun';
        
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
            <a href="#" class="text-14">Data Bank Akun</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Bank Akun</a>
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
                                <a href="{{route('akun-bank.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('akun-bank.update', $akun->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Akun <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $akun->name }}" id="scanBarang" aria-describedby="barangStatus" placeholder="Enter the Name Account...">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Username <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $akun->username }}" placeholder="Enter the username...">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>E-mail <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $akun->email }}" aria-describedby="barangStatus" aria-describedby="barangStatus" placeholder="Enter the email...">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Bank <small class="text-success">*Harus diisi</small></label>
                                        <select name="bank_id" id="" class="form-control">
                                            <option value="0">--Pilih Bank--</option>
                                            @foreach($bank as $data)
                                                <option value="{{ $data->id }}" @if($data->id == $akun->bank_id) selected @endif>{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
<script>
</script>
@endpush