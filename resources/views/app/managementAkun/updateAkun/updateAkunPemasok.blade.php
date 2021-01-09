@php
        $icon = 'dashboard';
        $pageTitle = 'Edit Akun Pemasok';
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row valign-center mb-2">
    <div class="col-md-8 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          {{-- <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data User</a>
          </div> --}}
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            {{-- @if (session()->has('success'))
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
		    @endif --}}
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('setPemasok.action')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$auth->id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Username <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $auth->username }}">
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
                                            <div class="col-md-12">
                                                <label>Email <small class="text-success">*Harus diisi</small></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$auth->email}}">
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
                                            <div class="col-md-12">
                                                <label>Nama Lengkap <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $auth->pemasok->nama }}">
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
                                            <div class="col-md-12">
                                                <label>NIK <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{$auth->pemasok->nik}}">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Tempat Lahir <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{$auth->pemasok->tempat_lahir}}">
                                                @error('tempat_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Tanggal Lahir <small class="text-success">*Harus diisi</small></label>
                                                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" value="{{$auth->pemasok->tgl_lahir}}">
                                                @error('tgl_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Jenis Kelamin <small class="text-success">*Harus diisi</small></label>
                                        <select name="jenis_kelamin" id="" class="form-control">
                                            <option value="Pria" {{$auth->pemasok->jenis_kelamin == 'Pria' ? 'selected' : ''}}>Pria</option>
                                            <option value="Wanita" {{$auth->pemasok->jenis_kelamin == 'Wanita' ? 'selected' : ''}}>Wanita</option>
                                        </select>
                                        @error('tgl_lahir')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="provinsi-select">Provinsi <small class="text-success">*Boleh tidak dipilih</small></label>
                                                <select class="form-control @error('provinsi_id') is-invalid @enderror" id="provinsi-select" name="provinsi_id">
                                                    <option value="">-- Pilih Disini --</option>
                                                    @foreach($provinsi as $p)
                                                    <option value="{{$p->id}}"  {{$p->id == $auth->pemasok->provinsi_id ? 'selected' : ''}}>{{$p->nama}}</option>
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
                                                <label for="kabupaten-select">Kabupaten <small class="text-success">*Boleh tidak dipilih</small></label>
                                                <select class="form-control @error('kabupaten_id') is-invalid @enderror" id="kabupaten-select" name="kabupaten_id">
                                                    <option value="{{$auth->pemasok->kabupaten_id}}">-- Pilih Disini --</option>
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
                                                <label for="kecamatan-select">Kecamatan <small class="text-success">*Boleh tidak dipilih</small></label>
                                                <select class="form-control @error('kecamatan_id') is-invalid @enderror" id="kecamatan-select" name="kecamatan_id">
                                                    <option value="{{$auth->pemasok->kecamatan_id}}">-- Pilih Disini --</option>
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
                                                <label for="desa-select">Desa <small class="text-success">*Boleh tidak dipilih</small></label>
                                                <select class="form-control @error('desa_id') is-invalid @enderror" id="desa-select" name="desa_id">
                                                    <option value="{{$auth->pemasok->desa_id}}">-- Pilih Disini --</option>
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
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                        <textarea name="alamat" id="" cols="10" rows="3" class="form-control @error('alamat') id-invalid @enderror" >{{$auth->pemasok->alamat}}</textarea>
                                        @error('pekerjaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Agama <small class="text-success">*Harus diisi</small></label>
                                                <select name="agama" id="" class="form-control">
                                                    <option value="Islam" {{$auth->pemasok->agama == 'Islam' ? 'selected' : ''}}>Islam</option>
                                                    <option value="Protestan" {{$auth->pemasok->agama == 'Protestan' ? 'selected' : ''}}>Protestan</option>
                                                    <option value="Katolik" {{$auth->pemasok->agama == 'Katolik' ? 'selected' : ''}}>Katolik</option>
                                                    <option value="Hindu" {{$auth->pemasok->agama == 'Hindu' ? 'selected' : ''}}>Hindu</option>
                                                    <option value="Buddha" {{$auth->pemasok->agama == 'Buddha' ? 'selected' : ''}}>Buddha</option>
                                                    <option value="Khonghucu" {{$auth->pemasok->agama == 'Khonghucu' ? 'selected' : ''}}>Khonghucu</option>
                                                </select>
                                                @error('pekerjaan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Status Perkawinan <small class="text-success">*Harus diisi</small></label>
                                                <select name="status_perkawinan" id="" class="form-control">
                                                    <option value="Belum Kawin" {{$auth->pemasok->status_perkawinan == 'Belum Kawin' ? 'selected' : ''}}>Belum Kawin</option>
                                                    <option value="Sudah" {{$auth->pemasok->status_perkawinan == 'Sudah' ? 'selected' : ''}}>Sudah</option>
                                                </select>
                                                @error('telepon')
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
                                            <div class="col-md-12">
                                                <label>Pekerjaan <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ $auth->pemasok->pekerjaan }}">
                                                @error('pekerjaan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Telepon <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ $auth->pemasok->telepon }}">
                                                @error('telepon')
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
                                            <div class="col-md-12">
                                                <label>Kewarganegaraan <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('kewarganegaraan') is-invalid @enderror" name="kewarganegaraan" value="{{ $auth->pemasok->kewarganegaraan }}">
                                                @error('kewarganegaraan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Foto <small class="text-success">*Harus diisi</small></label>
                                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" value="{{ $auth->pemasok->foto }}">
                                                @error('foto')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
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
<script type="text/javascript">
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
@endpush
