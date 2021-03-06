@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row fullscreen">
        <div class="col-md-7">
            @if (session()->has('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
		    	<i data-feather="check-circle"></i>
		        {{ session()->get('success') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    @elseif (session()->has('failed'))
		    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		    	<i data-feather="alert-circle"></i>
		        {{ session()->get('failed') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    @endif
            <div class="card shadow">
                <div class="ml-4 p-2 font"><i class="fas fa-user-plus text-warning"></i> <small>{{ __('Register') }}</small></div>
                <hr class="m-0">

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="email_verified_at" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Nama Lengkap') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus>

                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Tujuan Mendaftar') }}</label>

                                    <div class="col-md-12">
                                        <select name="role" id="role" class="form-control">
                                            {{-- <option value="">--Pilih Role--</option> --}}
                                            <option value="pelanggan">Membeli</option>
                                            {{-- <option value="pemasok">Penjual Barang</option> --}}
                                            {{-- <option value="karyawan">Karyawan</option> --}}
                                            {{-- <option value="bank">Bank</option> --}}
                                            <option value="gudang">Menjual</option>
                                        </select>

                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="show" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Jenis Usaha') }}</label>

                                    <div class="col-md-12">
                                        <select name="jenis" id="" class="form-control">
                                            {{-- <option value="">--Pilih Jenis Usaha--</option> --}}
                                            <option value="0">Perorangan</option>
                                            <option value="1">Instansi</option>
                                            {{-- <option value="karyawan">Karyawan</option> --}}
                                            {{-- <option value="bank">Bank</option> --}}
                                            {{-- <option value="gudang">Pengurus Gudang</option> --}}
                                        </select>

                                        @error('jenis')
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
                                    <label for="name" class="col-md-12">{{ __('Username') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="col-md-4">{{ __('Email') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
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
                                    <label for="password" class="col-md-12">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <i class="far fa-eye" style="position: absolute;right: 1.7rem;top: .9rem;cursor: pointer;" id="togglePassword"></i>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-12">{{ __('Password Konfirmasi') }}</label>

                                    <div class="col-md-12">
                                        <input id="passwordConfirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <i class="far fa-eye" style="position: absolute;right: 1.7rem;top: .9rem;cursor: pointer;" id="togglePasswordConfirm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="col-md-12">
                                <div class="float-left">
                                    <a href="{{route('login')}}">Sudah punya akun ?</a>
                                </div>
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $('#show').hide();
    $('#role').on('change', function () {
        var role = $(this).val();
        if (role == 'gudang') {
            $('#show').fadeIn();
        } else {
            $('#show').fadeOut();
        }
    });
    const togglePassword = document.querySelector('#togglePassword');
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const password = document.querySelector('#password');
    const passwordConfirm = document.querySelector('#passwordConfirm');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    togglePasswordConfirm.addEventListener('click', function (e) {
        // toggle the type attribute
        const typeConfirm = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', typeConfirm);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endpush
