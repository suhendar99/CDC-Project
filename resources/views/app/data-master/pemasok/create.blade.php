@extends('layouts.app')

@section('content')
<div class="container">
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
                                <h5>Data User</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('pemasok.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('pemasok.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Enter Nama">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Telepon <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" placeholder="Enter Telepon">
                                        @error('telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                  </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                        <textarea name="alamat" id="" cols="30" rows="10" class="form-control @error('alamat') is-invalid @enderror">{{old('alamat')}}</textarea>
                                        @error('alamat')
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
