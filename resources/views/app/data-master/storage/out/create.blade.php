@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Storage Keluar';
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
            <a href="#" class="text-14">Data Storage Keluar</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Buat Data</a>
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
                                <a href="{{route('storage.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('storage.out.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                        <label>Gudang <small class="text-success">*Harus diisi</small></label>
                                        <select name="gudang_id" id="gudang" class="form-control">
                                            <option value="">--Pilih Gudang--</option>
                                            @foreach ($gudang as $list)
                                                <option value="{{$list->id}}" {{ old('gudang_id') == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Telah diterima dari <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('terima_dari') is-invalid @enderror" name="terima_dari" value="{{ old('terima_dari') }}" placeholder="Enter terima_dari barang">
                                        @error('terima_dari')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Jumlah Uang <small class="text-success">*Harus diisi</small></label>
                                        <input type="integer" class="form-control @error('jumlah_uang_digits') is-invalid @enderror" name="jumlah_uang_digits" value="{{ old('jumlah_uang_digits') }}" placeholder="Enter jumlah_uang_digits barang">
                                        @error('jumlah_uang_digits')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="jumlah_uang_word">
                                    <div class="form-group col-md-3">
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectSatuan" class="form-control @error('satuan') is-invalid @enderror" name="satuan" placeholder="Enter satuan">
                                            <option value="kg">kg</option>
                                            <option value="ons">ons</option>
                                            <option value="gram">gram</option>
                                            <option value="ml">ml</option>
                                            <option value="m3">m<sup>3</sup></option>
                                            <option value="m2">m<sup>2</sup></option>
                                            <option value="m">m</option>
                                            <option value="gram">cm</option>
                                        </select>
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="barang_kode" id="barang" class="form-control">
                                            <option value="">-Pilih Barang-</option>
                                        </select>
                                        @error('barang_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Enter jumlah barang">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectSatuan" class="form-control @error('satuan') is-invalid @enderror" name="satuan" placeholder="Enter satuan">
                                            <option value="kg">kg</option>
                                            <option value="ons">ons</option>
                                            <option value="gram">gram</option>
                                            <option value="ml">ml</option>
                                            <option value="m3">m<sup>3</sup></option>
                                            <option value="m2">m<sup>2</sup></option>
                                            <option value="m">m</option>
                                            <option value="gram">cm</option>
                                        </select>
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
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

    $('#gudang').change(function(event) {
        /* Act on the event */
        let id = $('#gudang').val();
        let array = [];
        $('#barang').html(`<option value="">--Pilih Barang--</option>`);

        $.ajax({
                url: "/api/v1/storage/out/gudang/"+id+"/barang",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)

                    for (var i = response.data.length - 1; i >= 0; i--) {
                        
                        for (var j = response.data[i].storage_in.length - 1; j >= 0; j--) {
                            array.push(response.data[i].storage_in[j].storage.jumlah);
                        }
                        let jumlah = array.reduce((a, b) => a+b);

                        $('#barang').append(`
                            <option value="${response.data[i].kode_barang}">Nama: ${response.data[i].nama_barang} | Jumlah: ${jumlah} ${response.data[i].storage_in[0].storage.satuan}</option>
                        `)
                    }
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                }
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