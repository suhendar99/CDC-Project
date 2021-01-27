@php
    $icon = 'receipt_long';
    $pageTitle = 'Pemesanan';
    $nosidebar = true;
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
            <a href="#" class="text-14">{{$pageTitle}}</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('pesanan.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rincian Tujuan Pemesanan</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pelanggan_id}}">
                                <div id="rowTujuan" class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Perusahaan Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('penerima_po') is-invalid @enderror" name="penerima_po" value="{{ old('penerima_po') }}" >
                                            @error('penerima_po')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Penerima <small class="text-success">*Harus dipilih</small></label>
                                            <select name="pengurus_gudang_id" id="pemasok" class="form-control">
                                                <option value="">--Pilih Nama Penerima--</option>
                                                @foreach ($pGudang as $p)
                                                    <option value="{{$p->id}}">{{$p->nama}}</option>
                                                @endforeach
                                            </select>
                                            @error('pengurus_gudang_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>No HP Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email Penerima<small class="text-success">*Harus diisi</small></label>
                                            <input id="email" type="email" class="form-control @error('email_penerima') is-invalid @enderror" name="email_penerima" value="{{ old('email_penerima') }}" >
                                            @error('email_penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- @if (Auth::user()->keanggotaan == 1) --}}
                                    <div class="col-md-4">
                                        <label>Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectPembayaran" class="form-control @error('pembayaran') is-invalid @enderror" name="pembayaran"  >
                                            @if (Auth::user()->keanggotaan == 1)
                                                <option value="now">Bayar Sekarang</option>
                                                <option value="later">Bayar Nanti</option>
                                            @else
                                                <option value="now">Bayar Sekarang</option>
                                            @endif
                                        </select>
                                        @error('pembayaran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div id="pilihMetode" class="col-md-4 ">
                                        <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran"  >
                                            <option value="">-- Pilih Metode --</option>
                                            <option value="transfer">Transfer Ke (Rekening Penjual)</option>
                                            <option value="wangpas">Wangpas</option>
                                            <option value="bayar di tempat">Bayar di tempat</option>
                                        </select>
                                        @error('metode_pembayaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- @else
                                        <input type="hidden" name="pembayaran" value="later">
                                    @endif --}}
                                    {{-- @if (Auth::user()->keanggotaan == 0)
                                    <div class="col-md-8">
                                    @else --}}
                                    <div class="col-md-12">
                                    {{-- @endif --}}
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
                                        <h4 class="card-title">Rincian Pemesanan</h4>
                                        <button type="button" class="btn btn-sm bg-my-success " onclick="appendBarang()">Tambah Barang PO</button>
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
<input type="hidden" name="">
@endsection
@push('script')
<script type="text/javascript">

    var key = 0;
    var satuan;
    var pembayaran;
    var gudang;
    $('#pemasok').on('change',function(){
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/api/v1/getPemesananPelanggan/"+id,
            data: "data",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                $('#email').val(response.user.email);
                $.each(data, function (a, b) {
                    console.log(b.user);
                    $('#telepon').val(b.telepon);
                    $('#alamat').val(b.alamat);
                });
            }
        });
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama Barang <small class="text-success">*Harus dipilih</small></label>
                        <select name="barang[]" onchange="changebarang(${key},this)" class="form-control">
                            <option value="">--Pilih Nama Barang--</option>
                            @foreach ($barang as $p)
                                <option value="{{$p->kode_barang}}-{{$p->nama_barang}}">{{$p->nama_barang}}</option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diskon <small class="text-success">*Jika Tidak Ada Kosongkan</small></label>
                        <div class="input-group mb-3">
                          <input type="number" min="0" id="diskon" class="form-control @error('diskon') is-invalid @enderror" name="diskon[]" value="{{ old('diskon') }}" aria-describedby="satuanAppend">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                          @error('diskon')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pajak <small class="text-success">*Jika Tidak Ada Kosongkan</small></label>
                        <div class="input-group mb-3">
                          <input type="number" min="0" id="pajak" class="form-control @error('pajak') is-invalid @enderror" name="pajak[]" value="10" aria-describedby="satuanAppend" readonly>
                          <div class="input-group-append">
                            <span class="input-group-text" >%</span>
                          </div>
                          @error('pajak')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
        `)
        var conceptName = $('#hoho option:selected').text();
        console.log(conceptName);
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
        $('input[name="barang['+key+']"]').val(sel.value)
        $('#hoho option:selected').text();
    }

    function changeSatuan(key,sel) {
        $('#satuanAppend'+key).text(sel.value)
        $('input[name="satuan['+key+']"]').val(sel.value)
    }
</script>
@endpush
