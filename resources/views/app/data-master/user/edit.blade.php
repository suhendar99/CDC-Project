@php
        $icon = 'storage';
        $pageTitle = 'Edit Data User';
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
            <a href="#" class="text-14">Data User</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data User</a>
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
                                <a href="{{route('user.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('user.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Role / Level <small class="text-success">*Harus dipilih</small></label>
                                        <select name="role" id="" class="form-control">
                                            {{-- <option value="pelanggan" {{$data->pelanggan_id != null ? 'selected' : 'disabled'}}>Pelanggan</option> --}}
                                            {{-- <option value="karyawan" {{$data->karyawan_id != null ? 'selected' : 'disabled'}}> Karyawan</option> --}}
                                            <option value="bank" {{$data->bank_id != null ? 'selected' : 'disabled'}}>Bank</option>
                                            <option value="pemasok" {{$data->pemasok_id != null ? 'selected' : 'disabled'}}>Pemasok</option>
                                            <option value="pengurus gudang" {{$data->pengurus_gudang_id != null ? 'selected' : 'disabled'}}>Pengurus Gudang</option>
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->karyawan_id) ? Auth::user()->karyawan->nama :(isset(Auth::user()->bank_id) ? Auth::user()->bank->nama : (isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : ''))) }}" placeholder="Enter Nama">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Username <small class="text-success">*Boleh tidak diisi</small></label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $data->username }}" placeholder="Enter Username">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                  </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Email <small class="text-success">*Harus diisi</small></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" placeholder="Enter email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Password <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Enter password">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend2"><i class="far fa-eye" style="cursor: pointer;" id="togglePassword"></i></span>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
</script>
{{--  --}}
@endpush
