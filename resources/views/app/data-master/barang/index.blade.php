@php
        $icon = 'storage';
        $pageTitle = 'Data Penyimpanan (Stok)';
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
                                <a href="{{route('barang.create')}}" class="btn btn-success btn-sm">+ Data Barang Masuk</a>
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
                                                <th>Tanggal Barang Masuk</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Beli Barang</th>
                                                <th>Harga Jual Barang</th>
                                                <th>Stok Barang</th>
                                                <th>Satuan</th>
                                                <th>Foto Barang</th>
                                                <th>Atur Harga Barang</th>
                                                {{-- <th>Action</th> --}}
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
                                                    <h4>Barang Keluar <span class="h6">(Barang Yang Sudah Dikirim Kepada Pembeli)</span></h4>
                                                    <table id="table_keluar" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal Pengeluaran</th>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Pemasok</th>
                                                                <th>Nama Barang</th>
                                                                <th>Jumlah Barang</th>
                                                                <th>Satuan</th>
                                                                <th>No Pemesanan</th>
                                                                {{-- <th>Action</th> --}}
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
                                                                <th>Tanggal Pembuatan Kwitansi</th>
                                                                <th>Pembayar</th>
                                                                <th>Jumlah Uang</th>
                                                                <th>Pemesanan</th>
                                                                <th>Pemasok</th>
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
                                                                <th>Tanggal Pembuatan Surat Jalan</th>
                                                                <th>Kode Surat Jalan</th>
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
{{-- Modal Atur Harga Barang --}}
<div class="modal fade" id="modalAturHarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Atur Harga Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="formHarga">
        <div class="modal-body" id="loading">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-form-label" style="font-size: 13px;">Harga Beli Barang<small class="text-success">*Harus diisi</small></label>
                <div class="input-group mb-3">
                <div class="input-group-append">
                    <span class="input-group-text">Rp </span>
                </div>
                  <input type="number" type="number" id="harga" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" value="{{ old('harga_beli') }}" aria-describedby="satAppend">
                  <div class="input-group-append">
                    <span class="input-group-text" id="satAppend">/</span>
                  </div>
                  @error('harga_beli')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
            </div>
            <input type="hidden" name="jumlah" id="jumlah">
            {{-- <div class="form-group">
                <label class="col-form-label" style="font-size: 13px;">Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                <div class="input-group mb-3">
                    <input type="number" type="number" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" aria-describedby="satuanAppend">
                    <div class="input-group-append">
                    <span class="input-group-text" id="satuanAppend"></span>
                    </div>
                    @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}
            <div class="form-group">
                <label class="col-form-label" style="font-size: 13px;">Keuntungan <small class="text-success">*Harus diisi</small></label>
                <div class="input-group mb-3">
                  <input type="number" type="number" id="keuntungan" class="form-control @error('jumlah') is-invalid @enderror" name="keuntungan" value="{{ old('keuntungan') }}">
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                  @error('keuntungan')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label" style="font-size: 13px;">Total Harga Jual Barang <small class="text-success">*Harus diisi</small></label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text">Rp </span>
                    </div>
                    <input type="number" min="0" id="hasil" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{ old('harga_barang') }}" placeholder="Total harga barang" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text" id="satuaAppend">/</span>
                    </div>
                    @error('harga_barang')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" id="saveHarga">Atur Harga</button>
        </div>
        </form>
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
            ajax : "{{ route('barang.index') }}",
            columns : [
                {data : 'created_at', name: 'created_at'},
                {data : 'kode_barang', name: 'kode_barang'},
                {data : 'nama_barang', name: 'nama_barang'},
                {data : function(data,a,b,c){
                        if (data.harga_beli !== null) {
                            return 'Rp. '+ (data.harga_beli.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                        } else {
                            return 'Harga belum diatur.';
                        }
                    }, name: 'harga_beli'
                },
                {data : function(data,a,b,c){
                        if (data.harga_barang !== null) {
                            return 'Rp. '+ (data.harga_barang.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")) + ' per ' + data.satuan;
                        } else {
                            return 'Harga belum diatur.';
                        }
                    }, name: 'harga_barang'
                },
                {data : 'jumlah', name: 'jumlah'},
                {data : 'satuan', name: 'satuan'},
                {data : 'foto', name: 'foto'},
                {data : 'atur_harga', name: 'atur_harga'},
                // {data : 'action', name: 'action'}
            ]
        });


        let table_kwitansi = $('#table_kwitansi').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('kwitansi-pemasok.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'waktu', name: 'waktu'},
                {data : 'terima_dari', name: 'pembayar'},
                {data : 'jumlah_uang', name: 'jumlah_uang'},
                {data : 'pemesanan', name: 'pemesanan'},
                {data : 'pemasok.nama', name: 'pemasok'},
                {data : 'action', name: 'action'}
            ]
        });

        let table_surat_jalan = $('#table_surat_jalan').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('surat-jalan-pemasok.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'created_at', name: 'created_at'},
                {data : 'kode', name: 'kode'},
                {data : 'pengirim', name: 'pengirim'},
                {data : 'penerima', name: 'penerima'},
                {data : 'tempat', name: 'tempat'},
                {data : 'action', name: 'action'}
            ]
        });

        let table_surat_piutang = $('#table_surat_piutang').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('surat-piutang-bulky-pemasok.index') }}",
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
            ajax : "{{ route('storage-keluar-pemasok.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'waktu', name: 'waktu'},
                {data : 'barang.kode_barang', name: 'kode'},
                {
                    data : 'pemasok', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'barang', render:function(data,a,b,c){
                        return data.nama_barang;
                    }
                },
                {data : 'jumlah', name: 'jumlah'},
                {data : 'satuan.satuan', name: 'satuan'},
                {data : 'pemesanan', name: 'pemesanan'},
                // {data : 'action', name: 'action'}
            ]
        });

        function foto(id){
            $('#foto-load').html(``);
            $('#tempat-foto').html('LOADING...')
            $('#form-foto').attr('action', '{{ asset('') }}v1/pemasok/storage/stock/'+id+'/foto');

            $.ajax({
                url: "/api/v1/pemasok/stock/"+id+"/foto",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)

                    // let foto = response.data[0].foto;
                    let data = response.data;
                    console.log(foto);

                    if (data.length < 1) {
                        $('#tempat-foto').html(`<img src="{{ asset('/images/image-not-found.jpg') }}" alt="" width="100%">`)
                    } else {
                        $('#tempat-foto').html(`<img src="{{ asset('') }}${data[0].foto}" alt="" width="100%">`);
                    }

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }

        function penyimpanan(id, gudangId, barangKode){
            $('#dataPenyimpanan').html(`<tr><td colspan="5" class="text-center">LOADING</td></tr>`);

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
                    let storageIn = response.data.barang.storage_in;

                    for (var i = storageIn.length - 1; i >= 0; i--) {
                        let space = `<tr style="font-size: .8rem;">
                            <td id="waktu">${storageIn[i].waktu}</td>
                            <td id="kodeBarang">${storageIn[i].kode}</td>
                            <td id="jumlahBarang">${storageIn[i].storage.jumlah}&nbsp;${storageIn[i].storage.satuan}</td>
                            <td id="rak">${(storageIn[i].storage.tingkat != null) ? (storageIn[i].storage.tingkat.rak.nama) : ('Belum Diatur')}</td>
                            <td id="tingkatRak">${(storageIn[i].storage.tingkat != null) ? (storageIn[i].storage.tingkat.nama) : ('Belum Diatur')}</td>
                            <td id="aksi"><a href="/v1/storage/penyimpanan/${storageIn[i].storage.id}" class="btn btn-primary btn-sm">Atur Penyimpanan</a></td>
                        </tr>`;

                        van += space;
                    }

                    $('#dataPenyimpanan').append(van);
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    $('#dataPenyimpanan').html(`<tr><td colspan="5" class="text-center">Tidak Ada Data</td></tr>`);
                    console.log(res)
                }
            });
        }
        function aturHarga(id){
            // $('#loading').html(`
            //     <div class="hehe">
            //         <center>
            //             <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            //                 <span class="sr-only">Loading...</span>
            //             </div>
            //         </center>
            //     </div>
            // `)
            $('#formHarga').attr('action','/v1/update-harga-barang/'+id+'/pemasok')
            $('#saveHarga').attr('type','submit')
            $('#hasil').val(0)
            $('#harga').val(0)
            $('#keuntungan').val(0)
            $.ajax({
                url: "/api/v1/getBarang/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    var data = response.data;
                    console.log(data.harga_beli);
                    console.log(data.jumlah);
                    $('#jumlah').val(data.jumlah);
                    $('#harga').val(data.harga_beli);
                    $('#keuntungan').val(data.keuntungan);
                    $('#hasil').val(data.harga_barang);
                    $('#satuanAppend').text(data.satuan);
                    $('#satAppend').text('Per-'+data.satuan);
                    $('#satuaAppend').text('Per-'+data.satuan);

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });

        }
        function inputed(){
        var hasil = $('#hasil').val(Math.round($('#harga').val()) * Math.round($('#jumlah').val()) * Math.round($('#keuntungan').val())/100)
        console.log(hasil);
        }
        $('#jumlah').on('keyup',(value) => {
            $('#hasil').val(Math.round($('#harga').val()) * Math.round($('#jumlah').val()) * Math.round($('#keuntungan').val())/100)
        })
        $('#harga').on('keyup',(value) => {
            console.log()
            $('#hasil').val(Math.round($('#harga').val()) * Math.round($('#jumlah').val()) * Math.round($('#keuntungan').val())/100)
        })
        $('#keuntungan').on('keyup',(value) => {
            console.log()
            $('#hasil').val(Math.round($('#harga').val()) * Math.round($('#jumlah').val()) * Math.round($('#keuntungan').val())/100)
        })

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

        function cleanBtn() {
            $('#btn-action').html(`<a href="{{route('barang.create')}}" class="btn btn-success btn-sm">+ Data Barang Masuk</a>`);
        }
        function storageOut() {
            table_keluar.draw();
            table_surat_piutang.draw();
            $('#btn-action').html(``);
            // $('#btn-action').html(`<a href="/v1/storage-keluar-pemasok/create?id=0" class="btn btn-success btn-sm">+ Data Barang Keluar</a>`);
        }
    </script>
@endpush
@endsection
