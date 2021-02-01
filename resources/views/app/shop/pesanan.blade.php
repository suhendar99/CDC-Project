@php
    $icon = 'receipt_long';
    $pageTitle = 'Pemesanan';
    $nosidebar = true;
    $biayaAdmin = $biaya->biaya_admin;
    if (Auth::user()->pembeli_id != null) {
        $hargaBarangPembeli = $data->harga_barang;
        $pajakPembeli = $biaya->pajak * $hargaBarangPembeli/100;
        $totalBiayaPembeli = $hargaBarangPembeli - $pajakPembeli + $biayaAdmin;
    } elseif (Auth::user()->pelanggan_id != null) {
        $hargaBarang = $data->harga_barang;
        $pajak = $biaya->pajak * $hargaBarang/100;
        $totalBiaya = $hargaBarang - $pajak + $biayaAdmin;
    }
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
@if (Auth::user()->pelanggan_id != null)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('shop.pesanan.action',$id)}}" name="keranjang" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pemesanan Barang</h4>
                            </div>
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->gudang->pemilik}}">
                            <input type="hidden" name="nama_pemesan" id="pemesan" value="{{Auth::user()->pelanggan->nama}}">
                            <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pelanggan_id}}">
                            <input type="hidden" name="gudang_id" value="{{$data->gudang->id}}">
                            <input type="hidden" name="harga" id="harga" value="{{$totalBiaya}}">
                            <input type="hidden" name="nama_barang" value="{{$data->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->barang->kode_barang}}">
                            <input type="hidden" name="pajak" value="{{$pajak}}">
                            <input type="hidden" name="biaya_admin" value="{{$biayaAdmin}}">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Nama Barang</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="nama"><h6>{{$data->barang->nama_barang}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Harga Barang</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->harga_barang,0,',','.')}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Dari Gudang</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="penjual"><h6>{{$data->gudang->nama}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>Total Biaya Pemesanan <br /> <small class="text-primary"> * dengan pajak = Rp {{number_format($pajak,0,',','.')}} dan biaya admin = Rp {{number_format($biayaAdmin,0,',','.')}}</small></span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="penjual"><h6>Rp. {{ number_format($totalBiaya,0,',','.')}} </h6></div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="satuanAppend">{{ $data->satuan }}</span>
                                                </div>
                                            </div>
                                            @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Nomor Telepon <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="number" min="1" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Alamat<small class="text-success">*Harus diisi</small></label>
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
                    <div class="col-md-6 mt-2">
                        <button type="submit" class="btn btn-sm bg-my-primary btn-block">Pesan Langsung</button>
                    </div>
                    <div class="col-md-6 mt-2">
                        <button type="button" id="postKeranjang" class="btn btn-sm bg-my-primary btn-block">Masukan Ke Keranjang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@elseif(Auth::user()->pembeli_id != null)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('shop.pesanan.action',$id)}}" name="keranjang" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pemesanan Barang</h4>
                            </div>
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->pelanggan->nama}}">
                            <input type="hidden" name="nama_pemesan" id="pemesan" value="{{Auth::user()->pembeli->nama}}">
                            <input type="hidden" name="pembeli_id" value="{{Auth::user()->pembeli_id}}">
                            <input type="hidden" name="pelanggan_id" value="{{$data->pelanggan->id}}">
                            <input type="hidden" name="harga" id="harga" value="{{$totalBiayaPembeli}}">
                            <input type="hidden" name="nama_barang" value="{{$data->storageOut->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->storageOut->barang->kode_barang}}">
                            <input type="hidden" name="pajak" value="{{$pajakPembeli}}">
                            <input type="hidden" name="biaya_admin" value="{{$biayaAdmin}}">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Nama Barang</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="nama"><h6>{{$data->storageOut->barang->nama_barang}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Harga Barang</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->harga_barang,0,',','.')}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Dari</h6>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="penjual"><h6>{{$data->pelanggan->nama}}</h6></div>
                                    </div>
                                    <div class="col-md-4">
                                        <span>Total Biaya Pemesanan <br /> <small class="text-primary"> * dengan pajak = Rp {{number_format($pajakPembeli,0,',','.')}} dan biaya admin = Rp {{number_format($biayaAdmin,0,',','.')}}</small></span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="penjual"><h6>Rp. {{ number_format($totalBiayaPembeli,0,',','.')}} </h6></div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="satuanAppend">{{ $data->satuan }}</span>
                                                </div>
                                            </div>
                                            @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Nomor Telepon <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="number" min="1" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Alamat<small class="text-success">*Harus diisi</small></label>
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
                        <button type="submit" class="btn btn-sm bg-my-primary btn-block">Pesan Langsung</button>
                    </div>
                    {{-- <div class="col-md-6 mt-2">
                        <button type="button" id="postKeranjang" class="btn btn-sm bg-my-primary btn-block">Masukan Ke Keranjang</button>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
@push('script')
<script type="text/javascript">
    $('#postKeranjang').click(function(){
        $('form[name=keranjang]').attr('action',"{{route('keranjang.store',$id)}}");
        $('form[name=keranjang]').submit();
    })

    $('#selectPembayaran').change(function(){
        pembayaran = $(this).val()
        if (pembayaran == 'now') {
            $('#pilihMetode').removeClass('d-none')
        } else {
            $('#pilihMetode').addClass('d-none')
        }
    })
</script>
@endpush
