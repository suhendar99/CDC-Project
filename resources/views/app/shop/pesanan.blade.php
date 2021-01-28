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
            <form action="{{route('shop.pesanan.action',$id)}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pemesanan Barang</h4>
                            </div>
                            <input type="hidden" name="penerima_po" id="penerima" value="{{$data->storageIn->gudang->pemilik}}">
                            <input type="hidden" name="nama_pemesan" id="pemesan" value="{{Auth::user()->pelanggan->nama}}">
                            <input type="hidden" name="pelanggan_id" value="{{Auth::user()->pelanggan_id}}">
                            <input type="hidden" name="pengurus_gudang_id" value="{{$data->storageIn->gudang->user->pengurus_gudang_id}}">
                            <input type="hidden" name="harga" id="harga" value="{{$data->storageIn->storage->harga_barang}}">
                            <input type="hidden" name="nama_barang" value="{{$data->storageIn->barang->nama_barang}}">
                            <input type="hidden" name="satuan" value="{{$data->storageIn->satuan}}">
                            <input type="hidden" name="barangKode" value="{{$data->storageIn->barang->kode_barang}}">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6>Nama Barang</h6>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="nama"><h6>{{$data->storageIn->barang->nama_barang}}</h6></div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Harga Barang</h6>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="harga"><h6>Rp. {{ number_format($data->storageIn->storage->harga_barang,0,',','.')}}</h6></div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Dari Gudang</h6>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="float-left">:</div>
                                        <div class="float-left ml-2" id="penjual"><h6>{{$data->storageIn->gudang->nama}}</h6></div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <div class="input-group">
                                                <input type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="satuanAppend">{{ $data->storageIn->barang->satuan }}</span>
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
                                            <label>Nomor Telpon <small class="text-success">*Harus diisi</small></label>
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
                        <button type="submit" class="btn btn-sm bg-my-primary btn-block">Buat Pemesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    // var harga = '{{$data->storageIn->barang->harga_barang}}';
    // var penerima = '{{$data->storageIn->gudang->pemilik}}';
    // $('#harga').val(harga);
    // $('#penerima').val(penerima)
</script>
@endpush
