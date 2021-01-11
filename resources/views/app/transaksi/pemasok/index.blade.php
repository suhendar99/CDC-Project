@php
    $icon = 'attach_money';
    $pageTitle = 'Data Transaksi';
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
            <a href="#" class="text-14">Data Transaksi</a>
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
                                <a href="{{route('transaksiPemasok.create')}}" class="btn btn-primary btn-sm">Tambah Transaksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
            </div>
        </div>
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
{{-- Chart Section --}}
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
{{--  --}}
@endpush
