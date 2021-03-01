@php
    $koperasi = App\Models\Koperasi::all();
    $set = App\Models\PengaturanAplikasi::find(1);
    $provinsi = App\Models\Provinsi::all();
    $auth = Auth::user();
@endphp
<style>
    .steps-form {
    display: table;
    width: 100%;
    position: relative; }
    .steps-form .steps-row {
        display: table-row; }
    .steps-form .steps-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc; }
    .steps-form .steps-row .steps-step {
        display: table-cell;
        text-align: center;
        position: relative; }
    .steps-form .steps-row .steps-step p {
        margin-top: 0.5rem; }
    .steps-form .steps-row .steps-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important; }
    .steps-form .steps-row .steps-step .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
        margin-top: 0; }
</style>
@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row full" style="margin-top: -50px;">
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
            <!-- Stepper -->
            <div class="steps-form">
                <div class="steps-row setup-panel">
                    <div class="steps-step">
                        <a href="#step-9" type="button" class="btn btn-primary btn-circle mb-2">1</a>
                    </div>
                    <div class="steps-step">
                        <a href="#step-10" type="button" class="btn btn-default btn-circle mb-2" disabled="disabled">2</a>
                    </div>
                    <div class="steps-step">
                        <a href="#step-11" type="button" class="btn btn-default btn-circle mb-2" disabled="disabled">3</a>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="email_verified_at" value="">
                        {{-- First Step --}}
                        <!-- First Step -->
                        <div class="row setup-content" id="step-9">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold pl-0 my-4"><strong>Buat Akun</strong></h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group md-form">
                                            <div class="col-md-12">
                                                <label for="yourName" data-error="wrong" data-success="right">Role Akses</label>
                                                <select name="role" id="role" class="form-control validate @error('role') is-invalid @enderror">
                                                    <option value="">--Pilih Role--</option>
                                                    <option value="pemasok">Pemasok</option>
                                                    <option value="bulky">Bulky</option>
                                                    <option value="retail">Retail</option>
                                                    <option value="warung">Warung</option>
                                                    <option value="pembeli">Pembeli</option>
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
                                        <div class="form-group md-form">
                                            <div class="col-md-12">
                                                <label for="yourName" data-error="wrong" data-success="right">Keanggotaan</label>
                                                <select name="keanggotaan" id="keanggotaan" class="form-control validate @error('keanggotaan') is-invalid @enderror">
                                                    <option value="0">--Pilih keanggotaan--</option>
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
                                <div class="row d-none">
                                    <div class="col-md-12" id="koperasi">
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
                                        <div class="float-right">
                                            <button type="button" class="btn btn-primary btn-sm btn-rounded nextBtn float-right">
                                                {{ __('Selanjutnya') }} <i class="ri-arrow-right-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Step -->
                        <div class="row setup-content d-none" id="step-10">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold pl-0 my-4"><strong>Pengisian Data Diri</strong></h3>
                                <div class="row">
                                    <div class="col-6">
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
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name" class="col-md-12">{{ __('NIK') }}</label>

                                            <div class="col-md-12">
                                                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required autocomplete="nik" autofocus>

                                                @error('nik')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name" class="col-md-12">{{ __('No Telepon') }}</label>

                                            <div class="col-md-12">
                                                <input id="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" required autocomplete="telepon" autofocus>

                                                @error('telepon')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name" class="col-md-12">{{ __('Jenis Kelamin') }}</label>

                                            <div class="col-md-12">
                                                <select name="jenis_kelamin" id="" class="form-control  @error('jenis_kelamin') is-invalid @enderror">
                                                    <option value="Pria">Pria</option>
                                                    <option value="Wanita">Wanita</option>
                                                </select>

                                                @error('jenis_kelamin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <button class="btn btn-danger btn-sm btn-rounded prevBtn float-left" type="button"><i class="ri-arrow-left-line"></i> Sebelumnya</button>
                                    <button class="btn btn-primary btn-sm btn-rounded nextBtn float-right" type="button">Selanjutnya <i class="ri-arrow-right-line"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Third Step -->
                        <div class="row setup-content d-none" id="step-11">
                            <div class="col-md-12">
                            <h3 class="font-weight-bold pl-0 my-4"><strong>Pengisian Alamat</strong></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="provinsi-select">Provinsi <small class="text-success">*Harus dipilih</small></label>
                                            <select class="form-control @error('provinsi_id') is-invalid @enderror" id="provinsi-select" name="provinsi_id">
                                                <option value="">-- Pilih Disini --</option>
                                                @foreach($provinsi as $p)
                                                <option value="{{$p->id}}">{{$p->nama}}</option>
                                                @endforeach
                                            </select>
                                            @error('provinsi_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{{$message}}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="kabupaten-select">Kabupaten <small class="text-success">*Harus dipilih</small></label>
                                            <select class="form-control @error('kabupaten_id') is-invalid @enderror" id="kabupaten-select" name="kabupaten_id">
                                                <option value="">-- Pilih Disini --</option>
                                            </select>
                                            @error('kabupaten_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{{$message}}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="kecamatan-select">Kecamatan <small class="text-success">*Harus dipilih</small></label>
                                            <select class="form-control @error('kecamatan_id') is-invalid @enderror" id="kecamatan-select" name="kecamatan_id">
                                                <option value="">-- Pilih Disini --</option>
                                            </select>
                                            @error('kecamatan_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{{$message}}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="desa-select">Desa <small class="text-success">*Harus dipilih</small></label>
                                            <select class="form-control @error('desa_id') is-invalid @enderror" id="desa-select" name="desa_id">
                                                <option value="">-- Pilih Disini --</option>
                                            </select>
                                            @error('desa_id')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{{$message}}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="col-md-12">{{ __('Alamat Lengkap') }}</label>

                                        <div class="col-md-12">
                                            <textarea name="alamat" id="alamat" cols="10" rows="5" class="form-control @error('alamat') is-invalid @enderror">{{old('alamat')}}</textarea>

                                            @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <button class="btn btn-danger btn-sm btn-rounded prevBtn float-left" type="button"><i class="ri-arrow-left-line"></i> Sebelumnya</button>
                                <button class="btn btn-success btn-sm btn-rounded float-right" type="submit">Register</button>
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
{{-- Part Stepper --}}
<script>
    $(document).ready(function () {
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.removeClass('d-none');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepSteps = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepSteps.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],textarea"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i< curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
{{-- End Part --}}
{{-- Part Select Alamat --}}
<script>
    $('#provinsi-select').change(function() {
            var valueProv = $('#provinsi-select').val();
            console.log('Provinsi Id : '+valueProv);
            getKabupaten(valueProv);
        });
        $('#kabupaten-select').change(function() {
            var valueKab = $('#kabupaten-select').val();
            console.log('Kabupaten Id : '+valueKab);
            getKecamatan(valueKab);
        });
        $('#kecamatan-select').change(function() {
            var valueKec = $('#kecamatan-select').val();
            console.log('Kecamatan Id : '+valueKec);
            getDesa(valueKec);
        });
        $('#desa-select').change(function() {
            var valueDesa = $('#desa-select').val();
            console.log('Desa Id : '+valueDesa);
        });
        function getKabupaten(id) {
            $.ajax({
              url: '/api/v1/getKabupaten/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#kabupaten-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                        //   $('#kecamatan-select').append($('<option>').text('-- Silahkan Pilih Kabupaten --').attr('value', 0));
                          // console.log(json.data[i].nama);
                          $('#kabupaten-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#kabupaten-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
        function getKecamatan(id) {
            $.ajax({
              url: '/api/v1/getKecamatan/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#kecamatan-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                        //   $('#kecamatan-select').append($('<option>').text('-- Silahkan Pilih Kecamatan --').attr('value', 0));
                          // console.log(json.data[i].nama);
                          $('#kecamatan-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#kecamatan-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
        function getDesa(id) {
            $.ajax({
              url: '/api/v1/getDesa/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#desa-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                        //   $('#kecamatan-select').append($('<option>').text('-- Silahkan Pilih Desa --').attr('value', 0));
                          // console.log(json.data[i].nama);
                          $('#desa-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#desa-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
</script>
{{-- End Part --}}
<script>
    $('#anggota').hide();
    $('#role').on('change', function () {
        var role = $(this).val();
        if (role == 'pembeli') {
            $('.hide').removeClass('d-none');
            $('#anggota').addClass('d-none');
            $('#anggota').hide();
        } else {
            $('.hide').removeClass('d-none');
            $('#anggota').removeClass('d-none');
            $('#anggota').show();
            $('#koperasi').hide();
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
