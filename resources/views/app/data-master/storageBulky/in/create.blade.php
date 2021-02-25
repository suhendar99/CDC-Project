@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Penyimpanan Masuk';
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
            <a href="#" class="text-14">Buat Data</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <a href="{{route('bulky.storage.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('bulky.storage.index')}}" class="btn btn-primary btn-sm">Next <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('bulky.storage.masuk.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label>Pilih Gudang Retail Untuk Menyimpan Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="bulky_id" id="gudang" class="form-control">
                                            <option value="0">--Pilih Gudang Retail--</option>
                                            @foreach ($gudang as $list)
                                                <option value="{{$list->id}}" {{ old('bulky_id') == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('bulky_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6" id="noKwitt">
                                        <label>Nomor Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" id="noKwi" class="form-control @error('nomor_kwitansi') is-invalid @enderror" name="nomor_kwitansi" value="{{ old('nomor_kwitansi') }}" placeholder="Masukan Nomor Kwitansi">
                                        @error('nomor_kwitansi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6" id="noSurJal">
                                        <label>Nomor Surat Jalan <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('nomor_surat_jalan') is-invalid @enderror" name="nomor_surat_jalan" id="noSj" value="{{ old('nomor_surat_jalan') }}" placeholder="Masukan Nomor Surat Jalan">
                                        @error('nomor_surat_jalan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6" id="fotoKwit">
                                        <label>Foto Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <input type="file" class="form-control-file @error('foto_kwitansi') is-invalid @enderror" name="foto_kwitansi" value="{{ old('foto_kwitansi') }}" placeholder="Masukan Foto Kwitansi">
                                        @error('foto_kwitansi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Foto Surat Jalan <small class="text-success">*Harus diisi</small></label>
                                        <input type="file" class="form-control-file @error('foto_surat_jalan') is-invalid @enderror" name="foto_surat_jalan" value="{{ old('foto_surat_jalan') }}" placeholder="Masukan Foto Surat Jalan">
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
                                        <select name="barang_kode" id="barang" class="form-control">
                                            <option value="0" data-satuan="-" disabled>--Pilih Gudang Dahulu--</option>
                                        </select>
                                        @error('barang_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label style="font-size: 12px;">Jumlah Barang Dari Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend">-</span>
                                            </div>
                                        </div>
                                        @error('jumlah')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="pemesanan_bulky_id" id="pemesanan_bulky_id">
                                    <div class="form-group col-md-4">
                                        <label>Harga Beli Dari Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" value="{{ old('harga_beli') }}" id="harga">
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
    $('#gudang').change(function(event) {
        /* Act on the event */

        let id = $('#gudang option:selected').val()
        $.ajax({
                url: "/api/v1/gudang/bulky/"+id+"/pemesanan",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $('#barang').html(`<option>-- Pilih Barang --</option>`);
                    $.each(response.data, function(index, val) {
                        console.log(val);
                         /* iterate through array or object */

                         $('#barang').append(`<option value="${val.barang_kode}" data-satuan="${val.satuan}" data-id="${val.id}" data-jumlah="${val.jumlah_barang}" data-pemesanan="${val.pemesanan_id}" data-harga="${val.harga}" data-admin="${val.biaya_admin}">${val.barang.kode_barang} | ${val.barang.nama_barang}</option>`)
                    });
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                }
            });
    });
    $('#barang').change(function(event) {
        let id = $('#barang option:selected').data("id")
        console.log(id);
        $.ajax({
            type: "get",
            url: "/api/v1/barang/pemesanan/bulky/"+id,
            dataType: "json",
            success: function (response) {
                var data = response.data
                $.each(data, function (a, b) {
                    if (b.pemesanan.metode_pembayaran == null) {
                        $('#fotoKwit').html(`
                            <label>Foto Surat Piutang <small class="text-success">*Harus diisi</small></label>
                            <input type="file" class="form-control-file @error('foto_surat_piutang') is-invalid @enderror" name="foto_surat_piutang" value="{{ old('foto_surat_piutang') }}" placeholder="Masukan Foto Surat Piutang">
                            @error('foto_surat_piutang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        `)
                        $('#noKwitt').addClass('d-none');
                        $('#noSurJal').removeClass('col-md-6');
                        $('#noSurJal').addClass('col-md-12');
                    } else {
                        $('#fotoKwit').html(`
                            <label>Foto Kwitansi <small class="text-success">*Harus diisi</small></label>
                            <input type="file" class="form-control-file @error('foto_kwitansi') is-invalid @enderror" name="foto_kwitansi" value="{{ old('foto_kwitansi') }}" placeholder="Masukan Foto Kwitansi">
                            @error('foto_kwitansi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        `)
                        $('#noKwitt').removeClass('d-none');
                        $('#noSurJal').addClass('col-md-6');
                        $('#noSurJal').removeClass('col-md-12');
                        $('#noKwi').val(b.pemesanan.kwitansi_pemasok.kode);

                    }
                    $('#noSj').val(b.pemesanan.surat_jalan_pemasok.kode);
                });
            }
        });
        /* Act on the event */
        let satuan = $('#barang option:selected').data("satuan")
        let jumlah = $('#barang option:selected').data("jumlah")
        let pemesanan = $('#barang option:selected').data("pemesanan")
        let harga = $('#barang option:selected').data("harga")
        let admin = $('#barang option:selected').data("admin")
        let total = harga - admin;

         console.log(satuan)
         if (satuan == 'Kg') {
             $('#satuanAppend').text('Kuintal')
             $('#jumlah').val(jumlah);
             $('#jumlah').attr('type', 'number');
             $('#pemesanan_bulky_id').val(pemesanan)
             $('#harga').val(total)
         } else {
             $('#satuanAppend').text(satuan);
             $('#jumlah').val(jumlah);
             $('#jumlah').attr('type', 'number');
             $('#pemesanan_bulky_id').val(pemesanan)
             $('#harga').val(total)
         }
    });

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
                                            <td id="pemasok">${(response.data.pemasok == null) ? 'NULL' : response.data.pemasok.nama}</td>
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
                                            <td id="pemasok">${(response.data.pemasok == null) ? 'NULL' : response.data.pemasok.nama}</td>
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

        // $('#barang').change(function(event) {
        //     /* Act on the event */
        //     let kode = $('#barang').val()

        //     $.ajax({
        //         url: "/api/v1/check/barang/"+kode,
        //         method: "GET",
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: (response)=>{
        //             // console.log(response.data)
        //             let harga = response.data.harga_barang;

        //             $('#harga_barang').val(harga)
        //             $('#ada_harga').text('Harga untuk barang yang sama di gudang ini')
        //         },
        //         error: (xhr)=>{
        //             let res = xhr.responseJSON;
        //             console.log(res)
        //             console.log('error')
        //         }
        //     });
        // });
    });
</script>
@endpush
