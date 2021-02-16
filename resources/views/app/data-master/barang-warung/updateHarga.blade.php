@php
        $icon = 'storage';
        $pageTitle = 'Atur Harga Barang';
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
            <a href="#" class="text-14">Daftar Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Atuh Harga Barang</a>
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
                                <a href="{{route('barangWarung.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                          <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Dasar Per-{{ $base_harga->satuan }}</th>
                                    <th>Keuntungan</th>
                                    <th>Harga Jual Per-{{ $base_harga->satuan }}</th>
                                </tr>
                            </thead>
                              <tbody id="dataPenyimpanan">
                                <tr>
                                    <td>{{ $base_harga->storageOut->stockBarangRetail->nama_barang }}</td>
                                    <td>{{ $base_harga->jumlah }} {{ $base_harga->satuan }}</td>
                                    <td>Rp. {{ number_format($base_harga->harga_beli,0,',','.') }}</td>
                                    <td>Rp. {{ number_format(($base_harga->harga_beli / $base_harga->jumlah),0,',','.') }}</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" min="1" max="100" id="keuntungan" class="form-control @error('keuntungan') is-invalid @enderror" name="keuntungan" oninput="inputed(this)" value="" aria-describedby="satuanAppend">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend">%</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span id="sugest">0</span>
                                    </td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('barangWarung.update', $id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Harga Barang Per-{{ $satuan }} <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="satuanAppend">RP.</span>
                                            </div>
                                            <input type="number" id="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{ $harga }}" aria-describedby="satuanAppend">
                                        </div>
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Diskon Barang <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <input type="numeric" min="0" max="100" id="diskon" class="form-control @error('diskon') is-invalid @enderror" name="diskon" value="0" aria-describedby="diskonR" placeholder="00.00">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="diskonR">%</span>
                                            </div>
                                        </div>
                                        @error('diskon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                        <div class="float-right">
                                            <button id="btn-save" type="button" class="btn btn-success btn-sm disabled">Simpan</button>
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

    let hargaBeli = '{{ $base_harga->harga_beli }}';
    let jumlahBarang = '{{ $base_harga->jumlah }}';
    let hargaSatuan = 0;
    let untung = 0;
    let akhir = 0;
    $('#keuntungan').keyup(function(event) {
        $('#btn-save').removeClass('disabled');
        $('#btn-save').attr('type','sumbit');
        /* Act on the event */
        hargaSatuan = (parseInt(hargaBeli) / parseInt(jumlahBarang));
        untung = hargaSatuan * ($(this).val() / 100);
        akhir = hargaSatuan + untung;

        $('#sugest').text('Rp. '+(akhir.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")));
        $('#harga_barang').val(akhir.toFixed(0));
    });
</script>
@endpush
