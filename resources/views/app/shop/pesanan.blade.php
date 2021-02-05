 @php
    $icon = 'receipt_long';
    $pageTitle = 'Pemesanan';
    // $nosidebar = true;
    $shop = true;
    $detail = true;
    $biayaAdmin = $biaya->biaya_admin;
    $biayaMerchant = $biaya->biaya_merchant;
    if (Auth::user()->pembeli_id != null) {
        $hargaBarang = $data->harga_barang;
        // $pajakPembeli = $biaya->pajak * $hargaBarangPembeli/100;
        $totalBiayaPembeli = $hargaBarang + $biayaAdmin;
    } elseif (Auth::user()->pelanggan_id != null) {
        $hargaBarang = $data->harga_barang;
        // $pajak = $biaya->pajak * $hargaBarang/100;
        $totalBiaya = $hargaBarang + $biayaAdmin;
    }else{
        $hargaBarang = $data->harga_barang;
        // $pajak = $biaya->pajak * $hargaBarang/100;
        $totalBiaya = $hargaBarang + $biayaAdmin;
    }
    $satuan = $data->satuan;
@endphp
@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="container" style="min-height: 0;">
@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-success">check_circle</i>
    {{ session()->get('success') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    {{ session()->get('error') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('failed'))
<div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    {{ session()->get('failed') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('sukses'))
<script>
    alert("{{ session()->get('sukses') }}");
</script>
@endif
</div>
<div class="container">
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
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('shop.pesanan.action',$id)}}" name="keranjang" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                @if (Auth::user()->keanggotaan == 1)
                                    <h4 class="card-title">Pemesanan Barang {{Auth::user()->pelanggan->nama}} Sebagai Anggota {{Auth::user()->koperasi->nama_koperasi}}</h4>
                                @else
                                    <h4 class="card-title">Pemesanan Barang {{Auth::user()->pelanggan->nama}}</h4>
                                @endif
                            </div>
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->gudang->pemilik}}">
                            <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pelanggan_id}}">
                            <input type="hidden" name="gudang_id" value="{{$data->gudang->id}}">
                            <input type="hidden" name="harga" id="harga" value="">
                            <input type="hidden" name="nama_barang" value="{{$data->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->barang->kode_barang}}">
                            {{-- <input type="hidden" name="pajak" value="{{$pajak}}"> --}}
                            <input type="hidden" name="biaya_admin" value="{{$biayaAdmin}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-6">
                                                <h6>Nama Barang</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="nama"><h6>{{$data->barang->nama_barang}}</h6></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <h6>Harga Barang</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->harga_barang,0,',','.')}}</h6></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <h6>Dari Gudang</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><h6>{{$data->gudang->nama}}</h6></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-6">
                                                <span>Harga Barang</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="harga"><span>Rp. {{ number_format($data->harga_barang,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Biaya Admin</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaAdmin,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Biaya Merchant</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaMerchant,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Barang</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="jumlahBarang"><span>0</span></div>
                                                <hr style="border-bottom: solid 1px black;">
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Total Biaya Pemesanan</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="totBiaya"><span>Rp. 0</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <input type="number" id="jumlah" min="1" max="{{ ($data->satuan == 'Kwintal') ? ($data->jumlah * 100) : $data->jumlah }}" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="" aria-describedby="satuanAppend">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="satuanAppend">{{ ($data->satuan == 'Kwintal') ? 'Kg' : $data->satuan }}</span>
                                                </div>
                                            </div>
                                            @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
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
                                    <div id="pilihMetode" class="col-md-4 col-12">
                                        <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran"  >
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
                                    <div id="pilihMetode" class="col-md-4 col-12">
                                        <label>Metode Pengiriman <small class="text-success">*Harus dipilih</small></label>
                                        <select class="form-control @error('pengiriman') is-invalid @enderror" name="pengiriman"  >
                                            {{-- <option value=""> Pilih Metode </option> --}}
                                            <option value="kirim">Barang Dikirim</option>
                                            <option value="ambil">Barang Diambil</option>
                                        </select>
                                        @error('pengiriman')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Pembeli <small class="text-success">*Harus diisi</small></label>
                                            <input id="nama_pemesan" type="text" class="form-control @error('nama_pemesan') is-invalid @enderror" name="nama_pemesan" value="{{ Auth::user()->pelanggan->nama }}" >
                                            @error('nama_pemesan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nomor Telepon <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="number" min="1" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ Auth::user()->pelanggan->telepon }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alamat<small class="text-success">*Harus diisi</small></label>
                                            <textarea id="alamat" class="form-control @error('alamat_pemesan') is-invalid @enderror" name="alamat_pemesan" value="{{ Auth::user()->pelanggan->alamat }}">{{ Auth::user()->pelanggan->alamat }}</textarea>
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
                    <div class="col-md-12 col mt-2">
                        <button type="submit" class="btn btn-sm bg-my-primary btn-block">Pesan Langsung</button>
                    </div>
                    {{-- <div class="col-md-6 col mt-2">
                        <button type="button" id="postKeranjang" class="btn btn-sm bg-my-primary btn-block">Masukan Ke Keranjang</button>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
    @elseif(Auth::user()->pembeli_id != null)
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('shop.pesanan.action',$id)}}" name="keranjang" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->pelanggan->nama}}">
                            <input type="hidden" name="pembeli_id" value="{{Auth::user()->pembeli_id}}">
                            <input type="hidden" name="pelanggan_id" value="{{$data->pelanggan->id}}">
                            <input type="hidden" name="harga" id="harga" value="{{$totalBiayaPembeli}}">
                            <input type="hidden" name="nama_barang" value="{{$data->storageOut->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->storageOut->barang->kode_barang}}">
                            <input type="hidden" name="barang_warung_kode" value="{{$data->kode}}">
                            {{-- <input type="hidden" name="pajak" value="{{$pajakPembeli}}"> --}}
                            <input type="hidden" name="biaya_admin" value="{{$biayaAdmin}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-6">
                                                <h6>Nama Barang</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="nama"><h6>{{$data->storageOut->barang->nama_barang}}</h6></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <h6>Harga Barang</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->harga_barang,0,',','.')}}</h6></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <h6>Dari</h6>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><h6>{{$data->pelanggan->nama}}</h6></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-6">
                                                <span>Harga Barang</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="harga"><span>Rp. {{ number_format($data->harga_barang,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Biaya Admin</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaAdmin,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Biaya Merchant</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaMerchant,0,',','.')}}</span></div>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Jumlah Barang</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="jumlahBarang"><span>0</span></div>
                                                <hr style="border-bottom: solid 1px black;">
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <span>Total Biaya Pemesanan</span>
                                            </div>
                                            <div class="col-md-7 col-6">
                                                <div class="float-left">:</div>
                                                <div class="float-left ml-2" id="totBiaya"><span>Rp. 0</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <input type="number" id="jumlah" min="1" max="{{$data->jumlah}}" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="" aria-describedby="satuanAppend">
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
                                    <div class="col-md-4 col-12">
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
                                    <div id="pilihMetode" class="col-md-4 col-12">
                                        <label>Metode Pembayaran <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran"  >
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
                                    <div id="pilihMetode" class="col-md-4 col-12">
                                        <label>Metode Pengiriman <small class="text-success">*Harus dipilih</small></label>
                                        <select class="form-control @error('pengiriman') is-invalid @enderror" name="pengiriman"  >
                                            {{-- <option value="">-- Pilih Metode --</option> --}}
                                            <option value="kirim">Barang Dikirim</option>
                                            <option value="ambil">Barang Diambil</option>
                                        </select>
                                        @error('pengiriman')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Pemesan <small class="text-success">*Harus diisi</small></label>
                                            <input id="nama_pemesan" type="text" class="form-control @error('nama_pemesan') is-invalid @enderror" name="nama_pemesan" value="{{ Auth::user()->pembeli->nama }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nomor Telepon <small class="text-success">*Harus diisi</small></label>
                                            <input id="telepon" type="number" min="1" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ Auth::user()->pembeli->telepon }}" >
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alamat<small class="text-success">*Harus diisi</small></label>
                                            <textarea id="alamat" class="form-control @error('alamat_pemesan') is-invalid @enderror" name="alamat_pemesan" value="{{ Auth::user()->pembeli->alamat }}">{{ Auth::user()->pembeli->alamat }}</textarea>
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
    @elseif(Auth::user()->pengurus_gudang_id)
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('shop.pesanan.action',$id)}}" name="keranjang" method="post" id="form-action">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- {{dd($data)}} --}}
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->bulky->pemilik}}">
                            <input type="hidden" name="nama_pemesan" id="pemesan" value="{{Auth::user()->pengurusGudang->nama}}">
                            <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pengurus_gudang_id}}">
                            <input type="hidden" name="bulky_id" value="{{$data->bulky->id}}">
                            <input type="hidden" name="harga" id="harga" value="">
                            <input type="hidden" name="nama_barang" value="{{$data->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->barang->kode_barang}}">
                            {{-- <input type="hidden" name="pajak" value="{{$pajak}}"> --}}
                            <input type="hidden" name="biaya_admin" value="{{$biayaAdmin}}">
                            <div class="container-fluid mt-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-5 col-6">
                                                    <h6>Nama Barang</h6>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="nama"><h6>{{$data->barang->nama_barang}}</h6></div>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <h6>Harga Barang</h6>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->harga_barang,0,',','.')}}</h6></div>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <h6>Dari Gudang</h6>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="penjual"><h6>{{$data->bulky->nama}}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-5 col-6">
                                                    <span>Harga Barang</span>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="harga"><span>Rp. {{ number_format($data->harga_barang,0,',','.')}}</span></div>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <span>Jumlah Biaya Admin</span>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaAdmin,0,',','.')}}</span></div>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <span>Jumlah Biaya Merchant</span>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="penjual"><span>Rp. {{ number_format($biayaMerchant,0,',','.')}}</span></div>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <span>Jumlah Barang</span>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="jumlahBarang"><span>0</span></div>
                                                    <hr style="border-bottom: solid 1px black;">
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <span>Total Biaya Pemesanan</span>
                                                </div>
                                                <div class="col-md-7 col-6">
                                                    <div class="float-left">:</div>
                                                    <div class="float-left ml-2" id="totBiaya"><span>Rp. 0</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                                <div class="input-group">
                                                    <input type="number" id="jumlah" min="1" max="{{ ($data->satuan == 'Ton') ? ($data->jumlah * 10) : $data->jumlah }}" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="" aria-describedby="satuanAppend">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="satuanAppend">{{ ($data->satuan == 'Ton') ? 'Kwintal' : $data->satuan }}</span>
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
                                        <div id="pilihMetode" class="col-md-4 col-12">
                                            <label>Metode Pengiriman <small class="text-success">*Harus dipilih</small></label>
                                            <select class="form-control @error('pengiriman') is-invalid @enderror" name="pengiriman"  >
                                                {{-- <option value="">-- Pilih Metode --</option> --}}
                                                <option value="kirim">Barang Dikirim</option>
                                                <option value="ambil">Barang Diambil</option>
                                            </select>
                                            @error('pengiriman')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nomor Telepon <small class="text-success">*Harus diisi</small></label>
                                                <input id="telepon" type="number" min="1" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ Auth::user()->pengurusGudang->telepon }}" >
                                                @error('telepon')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                    </div>
                    <div class="col-md-12 mt-2">
                        @if(Auth::user()->pengurusGudang->status == 1)
                        <input type="hidden" name="gudang_id" id="id-gudang">
                        <button type="button" onclick="barang({{ Auth::user()->id }})" class="btn btn-sm bg-my-primary btn-block" data-toggle="modal" data-target="#exampleModal">Pesan Langsung</button>
                        @else
                        <button type="submit" class="btn btn-sm bg-my-primary btn-block">Pesan Langsung</button>
                        @endif
                    </div>
                    {{-- <div class="col-md-6 mt-2">
                        <button type="button" id="postKeranjang" class="btn btn-sm bg-my-primary btn-block">Masukan Ke Keranjang</button>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Harap Pilih Gudang Anda</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      {{-- <div class="form-group"> --}}
                          {{-- <label>Pilih Gudang Anda <small class="text-success">*Harus diisi</small></label> --}}
                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran" id="select-gudang">
                            <option value="">-- Pilih Gudang --</option>
                        </select>
                        @error('metode_pembayaran')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      {{-- </div> --}}
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    @endif
</div>
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
    // var jumlah = ;
    var biayaAdmin = '{{$biayaAdmin}}';
    var biayaMerchant = '{{$biayaMerchant}}';
    var hargaTotal = '{{$hargaBarang}}';
    var satuan = '{{ ($satuan == 'Ton') ? 'Kwintal' : (($satuan == 'Kwintal') ? 'Kg' : $satuan) }}';
    $('#jumlah').on('keyup', function () {
        // var biayaAdm = biayaAdmin * hargaTotal /100;
        var tot = $('#jumlah').val() * hargaTotal;
        var total = parseInt(tot) + parseInt(biayaAdmin)+parseInt(biayaMerchant);
        $('#jumlahBarang').text($('#jumlah').val()+` `+satuan)
        $('#totBiaya').text('Rp. '+(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")));
        $('#harga').val(total);
    });

    function barang(id){
        $('#select-gudang').html(``);
        $.ajax({
            url: "/api/v1/getGudang/"+id+"/user",
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                console.log(response.data)

                $('#select-gudang').append(`<option value="">-- Pilih Gudang --</option>`);

                $.each(response.data, function(index, val) {
                     /* iterate through array or object */
                     $('#select-gudang').append(`<option value="${val.id}">${val.nama}</option>`);
                });
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
            }
        });
    }

    $('#select-gudang').change(function(event) {
        /* Act on the event */
        $('#id-gudang').val($('#select-gudang').val());
        $('#form-action').submit();
    });
</script>
@endpush
