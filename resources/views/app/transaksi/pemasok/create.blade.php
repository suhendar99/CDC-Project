@php
    $icon = 'attach_money';
    $pageTitle = 'Tambah Transaksi';
@endphp

@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="row valign-center mb-2">
    <div class="col-md-8 col-sm-12 valign-center py-2">
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
    <div class="col-md-4 col-sm-12 valign-center py-2">
        {{-- @include('layouts.dashboard.search') --}}
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <a href="{{route('barang.create')}}" class="btn btn-primary btn-sm">Tambah Data Barang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @forelse($barang as $key => $value)
                <div class="col-md-3 col-4 my-2">
                    <div class="card">
                        <div class="row">
                            <div class="col-12">
                                <div id="carouselExampleIndicators{{$key}}" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @forelse($value->foto as $keyFoto => $val)
                                        <li data-target="#carouselExampleIndicators{{$key}}" data-slide-to="{{$keyFoto}}"></li>
                                        @empty
                                        @endforelse
                                    </ol>
                                    <div class="carousel-inner carousel-barang">
                                        @forelse($value->foto as $keyFoto => $val)
                                        <div class="carousel-item {{ $keyFoto == 0 ? 'active' : ''}}">
                                            <img class="d-block w-100 cover " height="150" src="{{asset($val->foto)}}" alt="First slide">
                                        </div>
                                        @empty
                                        <div class="carousel-item active">
                                            <div class="d-flex justify-content-center valign-center" style="height: 150px; background-color: #c6c6c6; color: #fff">
                                                Gambar Belum Diisi!
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                    @if(count($value->foto) >= 1)
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators{{$key}}" role="button" data-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators{{$key}}" role="button" data-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Next</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row my-2">
                                <div class="col-md-12 pr-4">
                                    <div class="float-left">
                                        <span class="barang-title">{{ $value->nama_barang }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <span>Tersedia {{ $value->jumlah.' '.$value->satuan }}</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="harga-title">Rp. {{ number_format($value->harga_barang,0,',','.') }}</span>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <a href="{{route('create.detail',$value->id)}}" class="btn btn-outline-primary btn-block btn-sm">Pilih Barang</a>
                                </div>
                                <div class="float-right" style="position: absolute; right: 1rem;">
                                    <div class="dropdown">
                                        <a href="#" title="Menu" class="dropdown-toggle p-2" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropmenu">
                                            {{-- <a href="{{ route('barang.edit', $value->id) }}" class="dropdown-item">Edit</a> --}}
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail({{ $value->id }})" data-id="{{ $value->id }}">Detail</a>
                                            {{-- <a href="#" class="dropdown-item" onclick="sweet({{ $value->id }})">Delete</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12 my-4 py-4 d-flex justify-content-center valign-center" style="height: 300px">
                    <center>
                        <span class="oops">Oops!</span>
                        <p class="not-found">Tidak ada data</p>
                    </center>
                </div>
                @endforelse
                <div class="col-md-12 d-flex justify-content-center">
                    {{$barang->links()}}
                </div>
            </div>
        </div>
        {{-- <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang / Barcode</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Total harga</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table> --}}
    </div>
</div>
<form action="" id="formDelete" method="POST">
    @csrf
    @method('DELETE')
</form>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Data Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                  <h4 id="nama"></h4>
              </div>
          </div>
          <div class="row">
            <div class="col-12 text-center">
                {{-- <span>Foto Barang</span><br> --}}
                <div id="foto" class="my-4 d-flex justify-content-center">
                </div>
            </div>
            <div class="col-12">
                <table class="table">
                  <tbody>
                    <tr>
                        <th scope="row">Pemasok</th>
                        <td id="pemasok"></td>
                    </tr>
                    <tr>
                        <th scope="row">Kategori</th>
                        <td id="kategori"></td>
                    </tr>
                    <tr>
                        <th scope="row">Harga</th>
                        <td id="harga"></td>
                    </tr>
                    <tr>
                        <th scope="row">Jumlah</th>
                        <td id="jumlah"></td>
                    </tr>
                    <tr>
                        <th scope="row">Total Harga</th>
                        <td id="harga_total"></td>
                    </tr>
                    <tr>
                        <th scope="row">Deskripsi</th>
                        <td id="deskripsi"></td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function sweet(id){
        const formDelete = document.getElementById('formDelete')
        formDelete.action = '/v1/barang/'+id

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        })
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                formDelete.submit();
                Toast.fire({
                    icon: 'success',
                    title: 'Your file has been deleted,wait a minute !'
                })
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
        })
    }

    function detail(id){
        $.ajax({
            method: "GET",
            url: '/api/v1/detailBarang/'+id,
        }).done(function(response){
            // console.log(response)
            let data = response.data
            let foto = response.foto

            $('#nama').text(data.nama_barang)
            $('#pemasok').text(data.pemasok.nama)
            $('#kategori').text(data.kategori.nama)
            $('#harga').text('Rp. '+parseInt(data.harga_barang).toLocaleString())
            $('#harga_total').text('Rp. '+parseInt(data.harga_total).toLocaleString())
            $('#jumlah').text(parseInt(data.jumlah).toLocaleString()+' '+data.satuan)
            $('#deskripsi').text(data.deskripsi)
            $.each(foto, function( index, value ) {
                $('#foto').append(`
                    <img src="/`+value+`" class="detail-foto">
                `)
            });
        });
    }
</script>
@endpush
