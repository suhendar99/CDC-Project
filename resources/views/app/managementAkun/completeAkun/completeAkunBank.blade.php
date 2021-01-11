@php
        $icon = 'dashboard';
        $pageTitle = 'Pengisian Data Diri';
        $nosidebar = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="container-fluid">
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
    <div class="row h-100">
        <div class="col-md-12">
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
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5>Melengkapi Data Diri</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('complete.akun',$auth->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Nama Perusahaan / Bank <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $auth->bank->nama }}">
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
                                                <label>Tahun Berdiri <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('tahun_berdiri') is-invalid @enderror" name="tahun_berdiri" value="{{old('tahun_berdiri')}}">
                                                @error('tahun_berdiri')
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
                                                <label for="provinsi-select">Provinsi</label>
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
                                                <label for="kabupaten-select">Kabupaten</label>
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
                                                <label for="kecamatan-select">Kecamatan</label>
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
                                                <label for="desa-select">Desa</label>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                                <textarea name="alamat" id="" cols="10" rows="3" class="form-control @error('alamat') id-invalid @enderror" >{{old('alamat')}}</textarea>
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
                                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}">
                                                @error('telepon')
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
                                        <label>Foto Profil <small class="text-success">*Harus diisi</small></label>
                                        <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" value="{{ old('foto') }}">
                                        @error('foto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Kewarganegaraan <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('kewarganegaraan') is-invalid @enderror" name="kewarganegaraan" value="{{ $auth->bank->kewarganegaraan }}">
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
                                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" value="{{ $auth->bank->foto }}">
                                                @error('foto')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                  <div class="row">
                                      <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success btn-sm">Selanjutnya</button>
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
