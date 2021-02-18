@php
    $koperasi = App\Models\Koperasi::all();
    $set = App\Models\PengaturanAplikasi::find(1);
@endphp
@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row fullscreen" style="margin-top: -50px;">
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
            <div class="col-md-12">
                <div class="text-center mb-1">
                    <img src="{{($set->logo_app == null) ? asset('images/logo/Logo-CDC.svg') : asset($set->logo_app)}}" alt="" height="100" width="200" style="object-fit: scale-down">
                </div>
            </div>
            {{-- <div class="col-md-12 mb-2">
                <div class="text-center">
                    <h6><b>( <span class="text-my-primary">Consolidated</span> <span class="text-warning">Distribution Center</span> )</b></h6>
                </div>
            </div> --}}
            <div class="card shadow">
                <div class="ml-4 p-2 font"><i class="fas fa-user-plus text-my-primary"></i> <small>{{ __('Register') }}</small></div>
                <hr class="m-0">

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="email_verified_at" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Role') }} <small class="text-danger">*harus pilih</small></label>

                                    <div class="col-md-12">
                                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                            <option value="">--Pilih Role--</option>
                                            <option value="pemasok">Pemasok</option>
                                            <option value="bulky">Bulky</option>
                                            <option value="retail">Retail</option>
                                            <option value="warung">Warung</option>
                                            <option value="pembeli">pembeli</option>
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
                        <div class="row d-none" id="anggota">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Keanggotaan Koperasi') }} <small class="text-danger">*harus pilih</small></label>

                                    <div class="col-md-12">
                                        <select name="keanggotaan" id="keanggotaan" class="form-control @error('keanggotaan') is-invalid @enderror">
                                            <option value="null">--Pilih keanggotaan--</option>
                                            <option value="1">Anggota</option>
                                            <option value="0">Bukan Anggota</option>
                                        </select>

                                        @error('keanggotaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none hide">
                            <div class="" id="nameFull">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Nama Lengkap') }}</label>

                                    <div class="col-md-12 nama">
                                        <input id="nama_lengkap" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus>

                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="koperasi">
                                <div class="form-group">
                                    <label for="name" class="col-md-12">{{ __('Pilih Koperasi') }} </label>

                                    <div class="col-md-12">
                                        <select name="koperasi_id" id="koperasi" class="form-control">
                                            {{-- <option value="">--Pilih Koperasi--</option> --}}
                                            @forelse ($koperasi as $item)
                                                <option value="{{$item->id}}">{{$item->nama_koperasi}}</option>
                                            @empty
                                                <option>Data Koperasi Kosong !</option>
                                            @endforelse
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
                        <div class="row d-none hide">
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

                        <div class="row d-none hide">
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
                                <div class="float-right d-none hide">
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
    $('#anggota').hide();
    $('#role').on('change', function () {
        var role = $(this).val();
        if (role == 'warung') {
            $('#anggota').show();
            $('#anggota').removeClass('d-none');
        } else {
            $('.d-none').removeClass('d-none');
            $('.d-none').show();
            $('#nameFull').removeClass('col-md-6');
            $('#nameFull').addClass('col-md-12');
            $('#koperasi').hide();
            $('#anggota').addClass('d-none');
        }
        if (role == "") {
            $(".hide").addClass('d-none');
        }
    });
    $('#keanggotaan').on('change', function(){
        var id = $(this).val();
        if (id == 1) {
            $('.d-none').removeClass('d-none');
            $('.d-none').show();
            $('#nameFull').removeClass('col-md-12');
            $('#nameFull').addClass('col-md-6');
            $('#koperasi').show();
        } else if (id == 0) {
            $('.d-none').removeClass('d-none');
            $('.d-none').show();
            $('#nameFull').removeClass('col-md-6');
            $('#nameFull').addClass('col-md-12');
            $('#koperasi').hide();
        } else {
            $(".hide").addClass('d-none');
        }
    })
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
