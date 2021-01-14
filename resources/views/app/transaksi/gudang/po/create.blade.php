@php
    $icon = 'receipt_long';
    $pageTitle = 'Tambah Purchase Order';
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
            <form action="{{route('po.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rincian Tujuan Purchase Order</h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Perusahaan Pengirim <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('pengirim_po') is-invalid @enderror" name="pengirim_po" value="{{ old('pengirim_po') }}" >
                                            @error('pengirim_po')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nama Pengirim <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim" value="{{ old('nama_pengirim') }}" >
                                            @error('nama_pengirim')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>No HP Pengirim <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('telepon_pengirim') is-invalid @enderror" name="telepon_pengirim" value="{{ old('telepon_pengirim') }}" >
                                            @error('telepon_pengirim')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email Pengirim<small class="text-success">*Harus diisi</small></label>
                                            <input type="email" class="form-control @error('email_pengirim') is-invalid @enderror" name="email_pengirim" value="{{ old('email_pengirim') }}" >
                                            @error('email_pengirim')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <div class="row">
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
                                            <label>Nama Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" name="nama_penerima" value="{{ old('penerima_po') }}" >
                                            @error('nama_penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>No HP Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('telepon_penerima') is-invalid @enderror" name="telepon_penerima" value="{{ old('telepon_penerima') }}" >
                                            @error('telepon_penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email Penerima<small class="text-success">*Harus diisi</small></label>
                                            <input type="email" class="form-control @error('email_penerima') is-invalid @enderror" name="email_penerima" value="{{ old('email_penerima') }}" >
                                            @error('email_penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectPembayaran" class="form-control @error('pembayaran') is-invalid @enderror" name="pembayaran"  >
                                            <option value="direct">Direct(Langsung Ke Penjual)</option>
                                            <option value="kredit">Kredit(Pinjam Ke Bank)</option>
                                        </select>
                                        @error('pembayaran')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div id="pilihBank" class="col-md-4 d-none">
                                        <label>Pilih Bank <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('bank_id') is-invalid @enderror" name="bank_id"  >
                                            @foreach($bank as $b)
                                            <option value="{{$b->id}}">{{$b->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alamat Penerima <small class="text-success">*Harus diisi</small></label>
                                            <textarea class="form-control @error('alamat_penerima') is-invalid @enderror" name="alamat_penerima" value="{{ old('alamat_penerima') }}"></textarea>
                                            @error('alamat_penerima')
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
                                        <h4 class="card-title">Rincian Barang PO</h4>
                                        <button type="button" class="btn btn-sm bg-my-success " onclick="appendBarang()">Tambah Barang PO</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="barang-parent">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button id="btnPo" type="button" class="btn btn-sm bg-my-primary btn-block" disabled>Buat PO</button>
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
    $('#selectPembayaran').change(function(){
        pembayaran = $(this).val()
        if (pembayaran == 'kredit') {
            $('#pilihBank').removeClass('d-none')
        } else {
            $('#pilihBank').addClass('d-none')
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
                        <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang[]" value="{{ old('nama_barang') }}" >
                        @error('nama_barang')
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
                          <input type="number" type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah[]" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
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
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga[]" value="{{ old('harga') }}" >
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
                          <input type="number" type="number" id="diskon" class="form-control @error('diskon') is-invalid @enderror" name="diskon[]" value="{{ old('diskon') }}" aria-describedby="satuanAppend">
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
                          <input type="number" type="number" id="pajak" class="form-control @error('pajak') is-invalid @enderror" name="pajak[]" value="{{ old('pajak') }}" aria-describedby="satuanAppend">
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

    function changeSatuan(key,sel) {
        $('#satuanAppend'+key).text(sel.value)
        $('input[name="satuan['+key+']"]').val(sel.value)
    }
</script>
@endpush
