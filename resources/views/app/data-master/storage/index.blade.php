@php
        $icon = 'storage';
        $pageTitle = 'Data Penyimpanan (Stok)';
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
            <a href="#" class="text-14">Data Penyimpanan</a>
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
                        <div class="col-md-9">
                            <div class="float-left">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a href="#pills-second" class="nav-link" id="pills-second-tab" data-toggle="pill" role="tab" aria-controls="pills-second" aria-selected="false" onclick="storageIn()">Pengelolaan Barang Masuk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pills-home" class="nav-link active" id="pills-home-tab" data-toggle="pill" role="tab" aria-controls="pills-home" aria-selected="true" onclick="cleanBtn()">Pengelolaan Penyimpanan Barang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pills-keluar" class="nav-link" id="pills-keluar-tab" data-toggle="pill" role="tab" aria-controls="pills-keluar" aria-selected="false" onclick="storageOut()">Pengelolaan Barang Keluar</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                                                <th>Waktu Penyimpanan Barang</th>
                                                <th>Nama Gudang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok Barang</th>
                                                <th>Penyimpanan Stok Barang</th>
                                                <th>Harga Jual Barang</th>
                                                <th>Diskon Barang</th>
                                                <th>Foto Stock Barang</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                                    <table id="table_masuk" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Waktu Barang Masuk</th>
                                                <th>Kode Penyimpanan</th>
                                                <th>Nama Gudang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang Masuk</th>
                                                <th>Harga Beli</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="pills-keluar" role="tabpanel" aria-labelledby="pills-keluar-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav nav-pills" id="sub-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a href="#sub-keluar" class="nav-link active rounded" id="sub-second-tab" data-toggle="pill" role="tab" aria-controls="sub-second" aria-selected="false" >Barang Keluar</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#sub-kwitansi" class="nav-link rounded" id="sub-home-tab" data-toggle="pill" role="tab" aria-controls="sub-home" aria-selected="true" >Kwitansi</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#sub-surat-jalan" class="nav-link rounded" id="sub-keluar-tab" data-toggle="pill" role="tab" aria-controls="sub-keluar" aria-selected="false" >Surat Jalan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#sub-surat-piutang" class="nav-link rounded" id="sub-piutang-tab" data-toggle="pill" role="tab" aria-controls="sub-keluar" aria-selected="false" >Surat Piutang</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-12 pt-4">
                                            <div class="tab-content" id="sub-tabContent">
                                                <div class="tab-pane fade show active" id="sub-keluar" role="tabpanel" aria-labelledby="sub-home-tab">
                                                    <h4>Barang Keluar (Barang Yang Sudah Dikirim Kepada Pembeli)</h4>
                                                    <table id="table_keluar" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Waktu Barang Keluar</th>
                                                                <th>Kode Penyimpanan</th>
                                                                <th>Nama Gudang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Jumlah Barang Keluar</th>
                                                                <th>No Pemesanan</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="sub-kwitansi" role="tabpanel" aria-labelledby="sub-home-tab">
                                                    <h4>Kwitansi</h4>
                                                    <table id="table_kwitansi" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Waktu Pembuatan Kwitansi</th>
                                                                <th>Pembayar</th>
                                                                <th>Jumlah Uang</th>
                                                                <th>No Pemesanan</th>
                                                                <th>Gudang</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="sub-surat-jalan" role="tabpanel" aria-labelledby="sub-home-tab">
                                                    <h4>Surat Jalan</h4>
                                                    <table id="table_surat_jalan" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Waktu Pembuatan Surat Jalan</th>
                                                                <th>Pengirim</th>
                                                                <th>Penerima</th>
                                                                <th>Tempat</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="sub-surat-piutang" role="tabpanel" aria-labelledby="sub-home-tab">
                                                    <h4>Surat Piutang</h4>
                                                    <table id="table_surat_piutang" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tanggal Pembuatan Surat Piutang</th>
                                                                <th>No Pemesanan (Invoice)</th>
                                                                <th>Pihak Pertama</th>
                                                                <th>Pihak Kedua</th>
                                                                <th>Tempat</th>
                                                                <th>Action</th>
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
            </div>
        </div>
    </div>
</div>
<form action="" id="formDelete" method="POST">
    @csrf
    @method('DELETE')
</form>
<!-- Modal Detail Barang Masuk -->
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

<!-- Modal Penyimpanan Stok Barang -->
<div class="modal fade" id="modalPenyimapanStok" tabindex="-1" aria-labelledby="penyimpananStok" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="penyimpananStok">Detail Penyimpanan Stok</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-12">
                  <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Waktu Penyimpanan Barang</th>
                            <th>Kode Masuk Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Rak</th>
                            <th>Tingkat Rak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                      <tbody id="dataPenyimpanan">
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
        <div class="modal-footer" style="border-bottom: 5px solid #ffa723;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- END --}}

<!-- Modal Penyimpanan Stok Barang -->
<div class="modal fade" id="modalFotoBarang" tabindex="-1" aria-labelledby="fotoBarang" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fotoBarang">Foto Stock Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-12" id="foto">
                <div class="row">
                    <div class="col-12" id="tempat-foto">

                    </div>
                    <div class="col-12 mt-3">
                        <form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="form-foto">
                            @csrf
                            @method('PUT')
                            <input type="file" class="form-control-file" name="foto" onchange="document.querySelector('#foto-load').innerHTML = 'Loading...';this.form.submit();" id="file-foto">
                        </form>
                    </div>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer" style="border-bottom: 5px solid #ffa723;">
            <div class="float-left" id="foto-load">

            </div>
          <button type="button" class="btn btn-secondary btn-sm float-rigth" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- END --}}
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
                {data : function(data,a,b,c){
                        return data.created_at;

                    }, name: 'waktu'},
                {data : 'gudang.nama', name: 'gudang'},
                {data : 'nama_barang', name: 'nama_barang'},
                {data : function(data,a,b,c){
                        return data.jumlah + " " + data.satuan;
                    }, name: 'jumlah'
                },
                {data : function (data, type, row, meta) {
                        let van = '';
                        // console.log(data)
                        let storageIn = data.storage.storage_in;

                        return `<a class="btn btn-info btn-sm col-md-12" data-toggle="modal" data-target="#modalPenyimapanStok" onclick="penyimpanan(${data.id})" data-id="${data.id}" style="cursor: pointer;" title="Detail">Detail</a>`;

                    }, name: 'penyimpanan'},
                {data : function(data,a,b,c){
                        if (data.harga_barang !== null) {
                            return 'Rp. '+ (data.harga_barang.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")) + ' per ' + data.satuan;
                        } else {
                            return 'Harga belum diatur.';
                        }
                    }, name: 'harga_barang'
                },
                {data : function(data,a,b,c){
                        if (data.diskon !== null) {
                            // return 'Rp. '+ (data.harga_barang.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")) + ' per ' + data.satuan;
                            return data.diskon+" %";
                        } else {
                            return 'Diskon belum diatur.';
                        }
                    }, name: 'diskon'
                },
                {data : function (data, type, row, meta) {
                        return `<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFotoBarang" onclick="foto(${data.id})" data-id="${data.id}" style="cursor: pointer;" title="Foto Stock Barang">Foto Stock Barang</a>`;
                    }, name: 'foto'},
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
                {data : function(data){
                        let current_datetime = new Date(data.created_at);
                        return current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();

                    }, name: 'waktu'},
                {data : 'terima_dari', name: 'pembayar'},
                {data : 'jumlah_uang_digits', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {data : function (data, type, row, meta) {
                        return "( "+data.pemesanan.kode + " ) " + data.pemesanan.nama_pemesan;
                    }, name: 'nama_pemesan'},
                {data : 'gudang.nama', name: 'gudang'},
                {data : 'action', name: 'action'}
            ]
        });

        let table_surat_jalan = $('#table_surat_jalan').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('surat-jalan.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : function(data){
                        let current_datetime = new Date(data.created_at);
                        return current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();

                    }, name: 'waktu'},
                {data : 'kode', name: 'kode'},
                {data : 'pengirim', name: 'pengirim'},
                {data : 'penerima', name: 'penerima'},
                {data : 'tempat', name: 'tempat'},
                {data : 'action', name: 'action'}
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
                {data : 'waktu', name: 'waktu'},
                {data : 'kode', name: 'kode'},
                {
                    data : 'gudang', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'nama_barang', name: 'nama_barang'},
                {
                    data: function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan.satuan;
                    },
                    name: 'jumlah'
                },
                {data : 'harga_beli', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {data : 'action', name: 'action'}
            ]
        });

        let table_surat_piutang = $('#table_surat_piutang').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('surat-piutang-warung-retail.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'created_at', name: 'created_at'},
                {data : 'invoice', name: 'invoice'},
                {data : 'pihak_pertama', name: 'pihak_pertama'},
                {data : 'pihak_kedua', name: 'pihak_kedua'},
                {data : 'tempat', name: 'tempat'},
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
                {data : 'waktu', name: 'waktu'},
                {data : 'kode', name: 'kode'},
                {
                    data : 'gudang', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'stock_barang_retail', render:function(data,a,b,c){
                        return data.nama_barang;
                    }
                },
                {
                    data: function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan.satuan;
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
                    $('.kodeBarang').text(storage.barang_bulky.barang_kode)
                    $('.nama').text(storage.nama_barang)
                    $('.harga').text(storage.harga_beli)
                    $('.satuan').text(storage.satuan.satuan)
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

        function foto(id){
            $('#foto-load').html(``);
            $('#tempat-foto').html('LOADING...')
            $('#form-foto').attr('action', '{{ asset('') }}v1/retail/storage/stock/'+id+'/foto');

            $.ajax({
                url: "/api/v1/retail/stock/"+id+"/foto",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    // console.log(response.data)

                    let foto = response.data.foto_barang;

                    if (foto !== null) {
                      $('#tempat-foto').html(`<img src="{{ asset('') }}${foto}" alt="" width="100%">`);
                    } else {
                      $('#tempat-foto').html(`<img src="{{ asset('/images/image-not-found.jpg') }}" alt="" width="100%">`)
                    }

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }

        function penyimpanan(id){
            $('#dataPenyimpanan').html(`<tr><td colspan="6" class="text-center">LOADING</td></tr>`);

            $.ajax({
                url: "/api/v1/detail/penyimpanan/stock?id="+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    $('#dataPenyimpanan').html(``);
                    let van = '';
                    // console.log(response.data)
                    let storageIn = response.data.storage;

                    for (var i = storageIn.length - 1; i >= 0; i--) {
                        let space = `<tr style="font-size: .8rem;">
                            <td id="waktu">${storageIn[i].waktu}</td>
                            <td id="kodeBarang">${storageIn[i].storage_in.kode}</td>
                            <td id="jumlahBarang">${storageIn[i].jumlah}&nbsp;${storageIn[i].satuan}</td>
                            <td id="rak">${(storageIn[i].tingkat != null) ? (storageIn[i].tingkat.rak.nama) : ('Belum Diatur')}</td>
                            <td id="tingkatRak">${(storageIn[i].tingkat != null) ? (storageIn[i].tingkat.nama) : ('Belum Diatur')}</td>
                            <td id="aksi"><a href="/v1/storage/penyimpanan/${storageIn[i].id}" class="btn btn-primary btn-sm">Atur Penyimpanan</a></td>
                        </tr>`;

                        van += space;
                    }

                    $('#dataPenyimpanan').append(van);
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    $('#dataPenyimpanan').html(`<tr><td colspan="6" class="text-center">Tidak Ada Data</td></tr>`);
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
            $('#btn-action').html(`<a href="{{route('storage.in.create')}}" class="btn btn-success btn-sm">+ Data Barang Masuk</a>`);
        }
        function storageOut() {
            $('#btn-action').html(`<a href="/v1/storage/out/create?id=0" class="btn btn-success btn-sm">+ Data Barang Keluar</a>`);
        }
        function cleanBtn() {
            $('#btn-action').empty();
        }
    </script>
@endpush
@endsection
