@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Rekening Pemasok';
        $dashboard = true;
        // $rightbar = true;
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
            <a href="#" class="text-14">Data Rekening Pemasok</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data</a>
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

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('rekeningPemasok.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('rekeningPemasok.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Bank <small class="text-success">*Harus dipilih</small></label>
                                        <select name="bank_id" id="" class="js-example-basic-single form-control @error('bank_id') is-invalid @enderror">
                                            <option value="0">--Pilih Bank--</option>
                                            @foreach ($bank as $item)
                                                <option value="{{$item->id}}" {{ $data->bank_id == $item->id ? 'selected' : ''}}>{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Pemilik <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('pemilik') is-invalid @enderror" name="pemilik" value="{{ $data->pemilik }}" placeholder="Enter nama barang">
                                        @error('pemilik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nomor Rekening <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" class="form-control @error('no_rek') is-invalid @enderror" name="no_rek" value="{{ $data->no_rek }}" placeholder="Enter nama barang">
                                        @error('no_rek')
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
{{-- Chart Section --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        function inputed(){
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        }
        $('#jumlah').on('keyup',(value) => {
            console.log()
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
        $('#satuan').on('keyup',(value) => {
            console.log()
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
    });
</script>
{{--  --}}
@endpush
