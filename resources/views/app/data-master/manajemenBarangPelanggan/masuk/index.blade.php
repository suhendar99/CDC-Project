@php
        $icon = 'storage';
        $pageTitle = 'Data Penyimpanan Masuk';
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
            <a href="#" class="text-14">Manajemen Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Penyimpanan Masuk</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('barangMasukPelanggan.create')}}" class="btn btn-primary btn-sm">Buat Data Penyimpanan Masuk</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Waktu Barang Masuk</th>
                                <th>Kode Penyimpanan / Barcode</th>
                                <th>Nama Gudang Pengirim</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang Masuk</th>
                                <th>Harga Beli</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12 mb-3">
                  <h3 id="kode"></h3>
              </div>
          </div>
          <div class="row">
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Kode Barang</th>
                            <td class="kodeBarang"></td>
                        </tr>
                        <tr>
                          <th scope="row">Nama Barang</th>
                          <td class="nama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Harga Beli Barang</th>
                          <td class="harga"></td>
                        </tr>
                        <tr>
                          <th scope="row">Satuan Barang</th>
                          <td class="satuan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jumlah Barang</th>
                          <td class="jumlah"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Gudang</th>
                            <td class="gudang"></td>
                        </tr>
                        {{-- <tr>
                          <th scope="row">Pengurus Gudang</th>
                          <td class="karyawan"></td>
                        </tr> --}}
                        <tr>
                          <th scope="row">Waktu Masuk</th>
                          <td class="waktu"></td>
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
@push('script')
    <script>
        let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('barangMasukPelanggan.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'waktu', name: 'waktu'},
                {data : 'kode', name: 'kode'},
                {data : 'nama_gudang', name: 'nama_gudang'},
                {data : 'storage_out.stock_barang_retail.nama_barang', name: 'nama_barang'},
                {data : 'jumlah_barang', name: 'jumlah_barang'},
                {data : 'harga_beli', name: 'harga_beli'},
                {data : 'action', name: 'action'}
            ]
        });

        function detail(id){
            $('.kodeBarang').text('LOADING...')
            $('.nama').text('LOADING...')
            $('.harga').text('LOADING...')
            $('.satuan').text('LOADING...')
            $('.jumlah').text('LOADING...')
            $('.gudang').text('LOADING...')
            // $('.karyawan').text('LOADING...')
            $('.waktu').text('LOADING...')
            $.ajax({
                url: "/api/v1/detail/barang/masuk/pelanggan/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    let storage = response.data;

                    $('#kode').text("Kode Storage: " + storage.kode)
                    $('.kodeBarang').text(storage.storage_out.barang_kode)
                    $('.nama').text(storage.storage_out.barang.nama_barang)
                    $('.harga').text(storage.harga_beli)
                    $('.satuan').text(storage.satuan)
                    $('.jumlah').text(storage.jumlah)
                    $('.gudang').text(storage.storage_out.gudang.nama)
                    // $('.karyawan').text(storage.user.pelanggan.nama)
                    $('.waktu').text(storage.waktu)
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }
        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/barangMasukPelanggan/'+id

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
    </script>
@endpush
@endsection
