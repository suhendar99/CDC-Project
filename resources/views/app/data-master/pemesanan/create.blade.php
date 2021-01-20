@php
    $icon = 'receipt_long';
    $pageTitle = 'Tambah Pemesanan';
@endphp

@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Purchase Order</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">{{$pageTitle}}</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('pemesanan.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="float-left">
                                            <h4 class="card-title">Tambah Pemesanan</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="float-right">
                                            <a href="{{route('pemesanan.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Penerima <small class="text-success">*Harus dipilih</small></label>
                                            <select name="pelanggan_id" id="pemasok" class="form-control">
                                                <option value="">--Pilih Nama Penerima--</option>
                                                @foreach ($pelanggan as $p)
                                                    <option value="{{$p->id}}">{{$p->nama}}</option>
                                                @endforeach
                                            </select>
                                            @error('pelanggan_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No HP Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="text" class="form-control @error('telepon_penerima') is-invalid @enderror" name="telepon_penerima" value="{{ old('telepon_penerima') }}" >
                                            @error('telepon_penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectPembayaran" class="form-control @error('pembayaran') is-invalid @enderror" name="pembayaran"  >
                                            <option value="now">Bayar Sekarang</option>
                                            <option value="later">Bayar Nanti</option>
                                        </select>
                                        @error('pembayaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div id="pilihMetode" class="col-md-6">
                                        <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran"  >
                                            <option value="">-- Pilih Metode --</option>
                                            <option value="1">Transfer Ke (Rekening Penjual)</option>
                                        </select>
                                        @error('metode_pembayaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alamat Penerima <small class="text-success">*Harus diisi</small></label>
                                            <textarea id="alamat" class="form-control @error('alamat_pemesan') is-invalid @enderror" name="alamat_pemesan" value="{{ old('alamat_pemesan') }}"></textarea>
                                            @error('alamat_pemesan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <h4 class="card-title">Rincian Pemesanan Barang</h4>
                                        <button type="button" class="btn btn-sm bg-my-success " onclick="appendBarang()">Tambah Pesanan Barang</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="barang-parent">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button id="btnPo" type="button" class="btn btn-sm bg-my-primary btn-block" disabled>Buat Pemesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">

    var key = 0;
    var satuan;
    var pembayaran;
    var gudang;
    $('#pemasok').on('change',function(){
        var id = $(this).val();
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/api/v1/getPemesananPelanggan/"+id,
            data: "data",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                $.each(data, function (a, b) {
                    $('#telepon').val(b.telepon);
                    $('#alamat').val(b.alamat);
                });
            }
        });
    })
    $('#selectGudang').change(function(){
        gudang = $(this).val()
        if (gudang == 'none') {
            $('#rowTujuan').addClass('d-none')
        } else {
            $('#rowTujuan').removeClass('d-none')
        }
    })

    $('#selectPembayaran').change(function(){
        pembayaran = $(this).val()
        if (pembayaran == 'now') {
            $('#pilihMetode').removeClass('d-none')
        } else {
            $('#pilihMetode').addClass('d-none')
        }
    })

    function removeArray(id) {
        $('#rowKe'+id).remove()
        key = id-1
        console.log(key)
        return key
    }

    function appendBarang() {
        key = key+1
        // console.log(key)
        $('#barang-parent').append(`
            <div class="row" id="rowKe${key}">
                <div class="col-md-12 d-flex justify-content-between">
                    <h6>Form Barang</h6><i class="material-icons md-14" onclick="removeArray(${key})" style="cursor:pointer">close</i>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Penerima <small class="text-success">*Harus dipilih</small></label>
                        <select name="barang[]"  onchange="changebarang(${key},this)" class="form-control">
                            <option value="">--Pilih Nama Penerima--</option>
                            @foreach ($barang as $p)
                                <option value="{{$p->kode_barang}}">{{$p->nama_barang}}</option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Satuan <small class="text-success">*Harus diisi</small></label>
                    <select id="selectSatuan" onchange="changeSatuan(${key},this)" class="form-control @error('satuan') is-invalid @enderror" name="satuan[]"  >
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                        <div class="input-group mb-3">
                          <input type="number" type="number" id="jumlah[]" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah[]" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                          <div class="input-group-append">
                            <span class="input-group-text" id="satuanAppend${key}"></span>
                          </div>
                          @error('jumlah')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Harga Barang <small class="text-success">*Harus diisi</small></label>
                        <input type="number" id="harga[]" class="form-control @error('harga') is-invalid @enderror" name="harga[]" value="{{ old('harga') }}" >
                        @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
        `)
        satuan = $('#selectSatuan').val()
        $('#satuanAppend'+key).text(satuan)
        $('input[name="satuan['+key+']"]').val(satuan)

        if(key != 0){
            $('#btnPo').removeAttr('disabled')
            $('#btnPo').attr('type','submit')
        } else {
            $('#btnPo').attr('disabled')
            $('#btnPo').attr('type','button')
        }
    }
    function changebarang(key,sel){
        console.log(sel.value);
        $('input[name="barang['+key+']"]').val(sel.value)
    }
    function changeSatuan(key,sel) {
        $('#satuanAppend'+key).text(sel.value)
        $('input[name="satuan['+key+']"]').val(sel.value)
    }
</script>
@endpush
