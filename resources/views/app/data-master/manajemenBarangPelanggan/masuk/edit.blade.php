@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Penyimpanan Masuk';
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
            <a href="#" class="text-14">Data Penyimpanan Masuk</a>
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
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('barangMasukPelanggan.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('barangMasukPelanggan.update', $data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nomor Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('nomor_kwitansi') is-invalid @enderror" name="nomor_kwitansi" value="{{ $data->nomor_kwitansi }}" placeholder="Masukan Nomor Kwitansi">
                                        @error('nomor_kwitansi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor Surat Jalan <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('nomor_surat_jalan') is-invalid @enderror" name="nomor_surat_jalan" value="{{ $data->nomor_surat_jalan }}" placeholder="Masukan Nomor Surat Jalan">
                                        @error('nomor_surat_jalan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Foto Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <input type="file" class="form-control-file @error('foto_kwitansi') is-invalid @enderror" name="foto_kwitansi" value="{{ $data->foto_kwitansi }}" placeholder="Masukan Foto Kwitansi">
                                        @error('foto_kwitansi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Foto Surat Jalan <small class="text-success">*Harus diisi</small></label>
                                        <input type="file" class="form-control-file @error('foto_surat_jalan') is-invalid @enderror" name="foto_surat_jalan" value="{{ $data->foto_surat_jalan }}" placeholder="Masukan Foto Surat Jalan">
                                        @error('foto_surat_jalan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Nama Barang Dari Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <select name="storage_out_kode" id="barang" class="form-control">
                                            <option value="0" data-satuan="-">--Pilih Barang--</option>
                                            @foreach ($barang as $barangs)
                                                <option value="{{$barangs->kode}}" {{ $data->storage_out_kode == $barangs->kode ? 'selected' : ''}} data-satuan="{{ $barangs->barang->satuan }}">{{$barangs->barang->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                        @error('storage_out_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="satuan" value="{{$data->satuan}}">
                                    <div class="form-group col-md-4">
                                        <label style="font-size: 12px;">Jumlah Barang Dari Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ $data->jumlah }}" aria-describedby="satuanAppend">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend"></span>
                                            </div>
                                        </div>
                                        @error('jumlah')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Harga Beli Dari Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" value="{{ $data->harga_beli }}">
                                        </div>
                                        @error('harga_beli')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-md-3">
                                        <label>Harga Jual Barang Per <span id="here">-</span> <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{ old('harga_barang') }}" placeholder="Masukan Harga Jual Barang" aria-describedby="ada_harga" id="harga_barang">
                                        <small id="ada_harga" class="form-text text-primary"></small>
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
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
<script src="{{ asset('js/onscan.js') }}"></script>
<script>
    $(document).ready(function() {

        onScan.attachTo(document, {
            suffixKeyCodes: [13],
            reactToPaste: true,
            onScan: function(sCode, qty){
                console.log(sCode)
                $('#scanBarang').val(sCode)
                $.ajax({
                    url: "/api/v1/storage/barang/"+sCode,
                    method: "GET",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: (response)=>{
                        console.log(response.data)
                        $('#barangStatus').empty();
                        $('#barangStatus').append('Barang ditemukan <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>')
                        $('#card-table').remove();
                        $('#card-form').after(`<div class="card card-block d-flex" id="card-table">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 col-sm-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Kode Barang</td>
                                                <td id="kodeBarang">${response.data.kode_barang}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Barang</td>
                                                <td id="nama">${response.data.nama_barang}</td>
                                            </tr>
                                            <tr>
                                                <td>Kategori Barang</td>
                                                <td id="kategori">${response.data.kategori.nama}</td>
                                            </tr>
                                            <tr>
                                                <td>Harga Barang</td>
                                                <td id="harga">${response.data.harga_barang}</td>
                                            </tr>
                                            <tr>
                                                <td>Pemasok Barang</td>
                                                <td id="pemasok">${response.data.pemasok.nama}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>`)
                    },
                    error: (xhr)=>{
                        let res = xhr.responseJSON;
                        console.log(res)
                        console.log('error')
                        $('#barangStatus').empty();
                        $('#card-table').remove();
                        $('#barangStatus').append('Barang tidak ditemukan! <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>');
                    }
                });
            }
            // onKeyDetect: function(key){
            //     console.log(key)
            // }
        });
    });

    $(document).ready(function() {
        $('#scanBarang').keyup(function(event) {
            /* Act on the event */
            let kode = $(this).val()

            $.ajax({
                url: "/api/v1/storage/barang/"+kode,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $('#barangStatus').empty();
                    $('#barangStatus').append('Barang ditemukan <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>')
                    $('#card-table').remove();
                    $('#card-form').after(`<div class="card card-block d-flex">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Kode Barang</td>
                                            <td id="kodeBarang">${response.data.kode_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td id="nama">${response.data.nama_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Kategori Barang</td>
                                            <td id="kategori">${response.data.kategori.nama}</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Barang</td>
                                            <td id="harga">${response.data.harga_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemasok Barang</td>
                                            <td id="pemasok">${response.data.pemasok.nama}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`)
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                    $('#barangStatus').empty();
                    $('#card-table').remove();
                    $('#barangStatus').append('Barang tidak ditemukan! <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>');
                }
            });
        });
    });
</script>
@endpush
