@php
    $icon = 'attach_money';
    $pageTitle = 'Tambah Transaksi';
@endphp

@extends('layouts.dashboard.header')

@section('content')

@error('gudang_id')
    <div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    Pastikan Anda Sudah memilih gudang tujuan
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@enderror

<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Transaksi</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="text-18">Surat Jalan</span>
                </div>
                <div class="card-body">
                    <form action="{{route('transaksiPemasok.store')}}" method="post">
                                          
                    @csrf 
                    <input type="hidden" name="gudang_id" id="gudang_id">
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table">
                          <tr>
                            <td class="bold text-center" width="50%">
                              <div class="float-left ml-4">
                                <span class="text-24">{{$barang->pemasok->nama}}</span><br>
                                {{$barang->pemasok->alamat}}, 
                                {{$barang->pemasok->desa->nama}}, 
                                {{$barang->pemasok->desa->kecamatan->nama}}<br>  
                                {{$barang->pemasok->desa->kecamatan->kabupaten->nama}}, 
                                {{$barang->pemasok->desa->kecamatan->kabupaten->provinsi->nama}}<br>
                                Telp. {{$barang->pemasok->telepon}}
                              </div>
                            </td>

                            <td class="text-18" width="50%">
                              <div class="float-right mr-4">
                                <span class="bold">KEPADA<br>YTH. </span>
                                <span><u>{{$gudang->pemilik}}<br>{{$gudang->nama}}</u></span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center bold text-36" colspan="2"><u>SURAT JALAN</u></td>
                          </tr>
                          <tr>
                            <td class="text-14" colspan="2">Mohon Diterima Barang Barang tersebut dibawah ini : </td>
                          </tr>
                        </table>
                        <table class="table table-bordered">
                          <thead>
                            <th>No</th>
                            <th></th>
                          </thead>
                        </table>
                      </div>
                        <div class="col-md-12">
                            <div class="float-right">
                               <button id="next" type="submit" class="btn btn-success btn-sm">Next</button> 
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
</script>
@endpush
