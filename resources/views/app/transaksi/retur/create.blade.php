@php
        $icon = 'storage';
        $pageTitle = 'Tambah Data Retur Masuk';

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
            <a href="#" class="text-14">Data Retur Masuk</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Data Retur Masuk</a>
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
                                <a href="{{route('returKeluarPelanggan.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('returKeluarPelanggan.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <select name="kwitansi_id" id="kwitansi" class="form-control">
                                            <option value="0">--Pilih Pesanan--</option>
                                            @foreach ($kwitansi as $pesan)
                                                <option value="{{$pesan->id}}" {{ old('kwitansi_id') == $pesan->id ? 'selected' : ''}}>Kode: {{$pesan->kode}} || Kode Pemesanan: {{ $pesan->pemesanan->kode }}</option>
                                            @endforeach
                                        </select>
                                        @error('kwitansi_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="barang_id[]" id="barang" class="form-control" multiple="multiple">
                                            <option value="0" disabled>--Pilih Barang--</option>
                                        </select>
                                        @error('barang_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengembalian <small class="text-success">*Harus diisi</small></label>
                                    <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}" placeholder="Enter tanggal_pengembalian">
                                    @error('tanggal_pengembalian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
    $('#kwitansi').change(function(event) {
        /* Act on the event */

        // $('#barang').html()
        let id = $('#kwitansi').val();

        $.ajax({
            url: "/api/v1/barang/pesanan/"+id,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                let barang = response.data;

                $('#barang').html('<option value="0" disabled>--Pilih Barang--</option>');

                for (let i = barang.length - 1; i >= 0; i--) {
                    // Things[i]
                    $('#barang').append($('<option>').text(`Kode Barang: ${barang[i].kode_barang} || Nama Barang: ${barang[i].nama_barang}`).attr('value', barang[i].id));
                }
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
                console.log('error')
                $('#barang').html('<option value="0" disabled>--Tidak Ada Barang--</option>');
            }
        });
    });
</script>
@endpush
