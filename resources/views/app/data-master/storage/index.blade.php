@php
        $icon = 'storage';
        $pageTitle = 'Data Storage';
        // $dashboard = true;
        // $admin = true;
        // $rightbar = true;
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
            <a href="#" class="text-14">Data Storage</a>
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
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a href="#pills-home" class="nav-link active" id="pills-home-tab" data-toggle="pill" role="tab" aria-controls="pills-home" aria-selected="true" onclick="cleanBtn()">Penyimpanan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pills-second" class="nav-link" id="pills-second-tab" data-toggle="pill" role="tab" aria-controls="pills-second" aria-selected="false" onclick="storageIn()">Masuk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pills-keluar" class="nav-link" id="pills-keluar-tab" data-toggle="pill" role="tab" aria-controls="pills-keluar" aria-selected="false" onclick="storageOut()">Keluar</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right" id="btn-action">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kode Storage Masuk</th>
                                                <th>Nama Gudang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                                <th>Rak</th>
                                                <th>Tingkatan Rak</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                                    <table id="table_masuk" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kode Storage / Barcode</th>
                                                <th>Nama Gudang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang Masuk</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-keluar" role="tabpanel" aria-labelledby="pills-keluar-tab">
                                    <h4>Storage Out</h4>
                                    <table id="table_keluar" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kode Storage / Barcode</th>
                                                <th>Nama Gudang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang Keluar</th>
                                                <th>Pemesanan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <br>
                                    <h4>Kwitansi</h4>
                                    <table id="table_kwitansi" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pembayar</th>
                                                <th>Jumlah Uang</th>
                                                <th>Pemesanan</th>
                                                <th>Gudang</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
                          <th scope="row">Harga Barang</th>
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
                        <tr>
                          <th scope="row">Karyawan</th>
                          <td class="karyawan"></td>
                        </tr>
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
            ajax : "{{ route('storage.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'storage_in_kode', name: 'kode'},
                {data : 'storage_in.gudang.nama', name: 'gudang'},
                {data : 'storage_in.barang.nama_barang', name: 'nama_barang'},
                {data : function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan;
                    }, name: 'jumlah'},
                {data : function(data,a,b,c){
                        if (data.tingkat == null) {
                            return 'Belum Diupdate';
                        } else {
                            return data.tingkat.rak.nama;
                        }
                    }, name: 'rak'},
                {data : function(data,a,b,c){
                        if (data.tingkat == null) {
                            return 'Belum Diupdate';
                        } else {
                            return data.tingkat.nama;
                        }
                    }, name: 'tingkat'},
                {data : 'action', name: 'action'}
            ]
        });


        let table_kwitansi = $('#table_kwitansi').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('kwitansi.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'terima_dari', name: 'pembayar'},
                {data : 'jumlah_uang_digits', render:function(data,a,b,c){
                        return 'Rp '+data;
                    }
                },
                {data : function (data, type, row, meta) {
                        return "( "+data.pemesanan.kode + " ) " + data.pemesanan.nama_pemesan;
                    }, name: 'nama_pemesan'},
                {data : 'gudang.nama', name: 'gudang'}
                // {data : 'action', name: 'action'}
            ]
        });

        let table_masuk = $('#table_masuk').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('storage.in.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'kode', name: 'kode'},
                {
                    data : 'gudang', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'barang', render:function(data,a,b,c){
                        return data.nama_barang;
                    }
                },
                {
                    data: function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan;
                    },
                    name: 'jumlah'
                },
                {data : 'action', name: 'action'}
            ]
        });

        let table_keluar = $('#table_keluar').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('storage.out.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'kode', name: 'kode'},
                {
                    data : 'gudang', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'barang', render:function(data,a,b,c){
                        return data.nama_barang;
                    }
                },
                {
                    data: function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan;
                    },
                    name: 'jumlah'
                },
                {data : 'pemesanan', render:function(data,a,b,c){
                        return data.kode+' | '+data.nama_pemesan;
                    }
                },
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
            $('.karyawan').text('LOADING...')
            $('.waktu').text('LOADING...')
            $.ajax({
                url: "/api/v1/detail/storage/in/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    let storage = response.data;

                    $('#kode').text("Kode Storage: " + storage.kode)
                    $('.kodeBarang').text(storage.barang.kode_barang)
                    $('.nama').text(storage.barang.nama_barang)
                    $('.harga').text(storage.barang.harga_barang)
                    $('.satuan').text(storage.barang.satuan)
                    $('.jumlah').text(storage.jumlah)
                    $('.gudang').text(storage.gudang.nama)
                    $('.karyawan').text(storage.user.pengurus_gudang.nama)
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
            formDelete.action = id;

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

        function storageIn() {
            $('#btn-action').html(`<a href="{{route('storage.in.create')}}" class="btn btn-primary btn-sm">Buat Data Storage Masuk</a>`);
        }
        function storageOut() {
            $('#btn-action').html(`<a href="{{route('storage.out.create')}}" class="btn btn-primary btn-sm">Buat Data Storage Keluar</a>`);
        }
        function cleanBtn() {
            $('#btn-action').empty();
        }
    </script>
@endpush
@endsection
