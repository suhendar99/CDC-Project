@php
        $icon = 'storage';
        $pageTitle = 'Data Pemesanan Masuk';
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
            <a href="#" class="text-14">Data Transaksi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Pemesanan Masuk</a>
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
                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>No Pemesanan (Invoice)</th>
                                <th>Nama Pemesan</th>
                                <th>Jumlah Barang</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Pemesanan</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Detail Data Pemesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">Tanggal Pemesanan</div>
                        <div class="col-md-8" id="tanggalPemesanan">:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Nomor Pemesanan</div>
                        <div class="col-md-8" id="noPemesanan">:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Nama Pemesan</div>
                        <div class="col-md-8" id="nama">:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Telepon Pemesan</div>
                        <div class="col-md-8" id="telepon">:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Alamat Pemesan</div>
                        <div class="col-md-8" id="alamat">:</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Metode Pembayaran</div>
                        <div class="col-md-8" id="metode">:</div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Biaya Admin</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" id="no"></th>
                        <td id="kode"></td>
                        <td id="namaBarang"></td>
                        <td id="jumlah"></td>
                        <td id="biayaAdmin"></td>
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

<!-- Modal -->
<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="modalBukti" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBukti">Bukti Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <img src="" class="w-100" id="foto_bukti">
        </div>
        <div class="modal-footer">

          Apakah Sudah Sesuai ? <a id="button_accept" href="" class="btn btn-primary btn-sm">Ya</a> <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tidak</button>
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
            ajax : "{{ route('pemesananMasukWarung.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'pemesanan_pembeli.tanggal_pemesanan', name: 'tanggal_pemesanan'},
                {data : 'pemesanan_pembeli.nomor_pemesanan', name: 'nomor_pemesanan'},
                {data : 'pemesanan_pembeli.nama_pemesan', name: 'nama_pemesan'},
                {data : 'jumlah_barang', name: 'jumlah_barang'},
                {data : 'status_pembayaran', name: 'status_pembayaran'},
                {data : 'status_pemesanan', name: 'status_pemesanan'},
                {data : 'action', name: 'action'}
            ],
        });

        function detail(id){
            $('#tanggalPemesanan').text('LOADING...')
            $('#noPemesanan').text('LOADING...')
            $('#nama').text('LOADING...')
            $('#telepon').text('LOADING...')
            $('#alamat').text('LOADING...')
            $('#metode').text('LOADING...')

            $('#no').html(`<center><tr><td colspan="5" class="text-center">LOADING...</td></tr></center>`);

            $.ajax({
                url: "/api/v1/getDataPemesananPembeli/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    let data = response.data;
                    console.log(data)
                    $.each(data, function (a, b) {
                        $('#tanggalPemesanan').text(`: `+b.pemesanan_pembeli.tanggal_pemesanan)
                        $('#noPemesanan').text(`: `+b.pemesanan_pembeli.nomor_pemesanan)
                        $('#nama').text(`: `+b.pemesanan_pembeli.nama_pemesan)
                        $('#telepon').text(`: `+b.pemesanan_pembeli.telepon)
                        $('#alamat').text(`: `+b.pemesanan_pembeli.alamat_pemesan)
                        if (b.pemesanan_pembeli.metode_pembayaran == null) {
                            $('#metode').text(`: Berhutang`)
                        } else {
                            $('#metode').text(`: `+b.pemesanan_pembeli.metode_pembayaran)
                        }
                    });
                    $.each(data, function (key, value) {
                        $('#no').text(key+1)
                        $('#kode').text(value.barang_kode)
                        $('#namaBarang').text(value.nama_barang)
                        $('#jumlah').text(value.jumlah_barang)
                        $('#biayaAdmin').text(value.biaya_admin)
                    });

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }
        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/pemesananPembeli/'+id

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

        function bukti(id){

            $.ajax({
                url: "/api/v1/getDataPemesananPembeli/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data[0]);
                    $('#foto_bukti').attr('src',`${response.data[0].pemesanan_pembeli.foto_bukti}`);
                    $('#button_accept').attr('href','/v1/validasi/bukti/pembeli/'+response.data[0].pemesanan_pembeli.id);

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }
    </script>
@endpush
@endsection
