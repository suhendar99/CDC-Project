<style>
    .eye {
        position: absolute;right: 1.7rem;top: .9rem;cursor: pointer;
    }
</style>
@php
    $set = App\Models\PengaturanAplikasi::find(1);
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
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
            @elseif (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i data-feather="alert-circle"></i>
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="col-md-12">
                <div class="text-center mb-3">
                    <img src="{{asset($set->logo_app)}}" alt="" height="65" width="85">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="text-center">
                    <h6><b>( <span class="text-my-primary">Consolidated</span> <span class="text-warning">Distribution Center</span> )</b></h6>
                </div>
            </div>
            <div class="card shadow">
                <div class="ml-4 p-2 font"><i class="fas fa-sign-in-alt text-warning"></i> <small>{{ __('Login') }}</small></div>
                <hr class="m-0">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username or Email') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <i class="far fa-eye" style="position: absolute;right: 1.7rem;top: .9rem;cursor: pointer;" id="togglePassword"></i>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-4">
                            <div class="col-md-8 offset-md-4 float-right">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{ __('Login') }}
                                </button> or
                                <a href="{{route('register')}}">Register</a>
                                <a href="#" style="margin-left:115px;">Bantuan</a>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
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
@endpush
