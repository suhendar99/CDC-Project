@php
        $icon = 'storage';
        $pageTitle = 'Ubah Penyimpanan Barang Bulky';
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
            <a href="#" class="text-14">Data Penyimpanan Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Ubah Penyimpanan</a>
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
                                <a href="{{route('bulky.storage.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('bulky.storage.rak.simpan', $masuk->storageMasukBulky->kode)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Rak <small class="text-success">*Harus diisi</small></label>
                                        <select name="rak_id" id="rak" class="form-control">
                                            <option value="0">--Pilih Rak--</option>
                                            @foreach ($rak as $list)
                                                <option value="{{$list->id}}" {{ $raks == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('rak_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tingkat Rak <small class="text-success">*Harus diisi</small></label>
                                        <select name="tingkat_id" id="tingkat" class="form-control">
                                            <option value="0" selected>--Pilih Tingkat--</option>
                                        </select>
                                        @error('tingkat_id')
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
    $(document).ready(function() {
        if ($('#rak').val() != 0 || $('#rak').val() !== 'undefined') {
            let id = $('#rak').val();
            let tink = '{{ $tingkat }}';
            $.ajax({
                url: "/api/v1/bulky/storage/rak/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    let tingkat = response.data;

                    $('#tingkat').html(`<option value="0">--Pilih Tingkat--</option>`);

                    for (let i = tingkat.length - 1; i >= 0; i--) {
                        // Things[i]
                        if (tingkat[i].id == tink) {
                            $('#tingkat').append($('<option>').text(tingkat[i].nama).attr({
                                value: tingkat[i].id,
                                selected: 'selected'
                            }));
                        } else {
                            $('#tingkat').append($('<option>').text(tingkat[i].nama).attr('value', tingkat[i].id));
                        }
                    }
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                    $('#tingkat').html('');
                }
            });
        }    
    });

    $('#rak').change(function(event) {
        /* Act on the event */
        let id = $('#rak').val();
        $.ajax({
            url: "/api/v1/bulky/storage/rak/"+id,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                let tingkat = response.data;

                $('#tingkat').html(`<option value="0">--Pilih Tingkat--</option>`);

                for (let i = tingkat.length - 1; i >= 0; i--) {
                    // Things[i]
                    $('#tingkat').append($('<option>').text(tingkat[i].nama).attr('value', tingkat[i].id));
                }
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
                console.log('error')
                $('#tingkat').html('');
            }
        });
    });
</script>
@endpush