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
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="float-right">
                                <a href="{{route('pemesanan.create')}}" class="btn btn-primary btn-sm">Tambah Pesanan</a>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>DateTime</th>
                                <th>Nomor Pemesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Jumlah Barang</th>
                                <th>Status Pembayaran</th>
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

<!-- Modal Detail Barang Masuk -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Pemesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nomor Pemesanan</th>
                            <td id="noPemesan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Nama Pemesan</th>
                          <td id="namaPemesan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Dari Gudang Retail</th>
                          <td id="gudangPemesan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Tanggal Pemesanan</th>
                          <td id="tglPemesan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Metode Pembayaran</th>
                          <td id="metodeBayar"></td>
                        </tr>
                        <tr>
                          <th scope="row">Status Pembayaran</th>
                          <td id="statusBayar"></td>
                        </tr>
                        <tr>
                          <th scope="row">Alamat Pemesan</th>
                          <td id="alamatPemesan"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Telepon</th>
                            <td id="telepon"></td>
                        </tr>
                        <tr>
                          <th scope="row">Gudang Bulky</th>
                          <td id="bulky"></td>
                        </tr>
                        <tr>
                          <th scope="row">Penerima Pesanan</th>
                          <td id="penerima"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-12">
                <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Kode Barang</th>
                            <th scope="row">Nama Barang</th>
                            <th scope="row">Jumlah Barang</th>
                            <th scope="row">Harga Barang</th>
                            <th scope="row">Biaya Admin</th>
                        </tr>
                        <tr id="barangData">
                            
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
            ajax : "{{ route('bulky.pemesanan.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'tanggal_pemesanan', name: 'tanggal_pemesanan'},
                {data : 'nomor_pemesanan', name: 'no_pemesanan'},
                {data : 'nama_pemesan', name: 'nama_pemesan'},
                {data : function(data, a, b, c) {
                    return data.barang_pesanan_bulky.jumlah_barang+' '+data.barang_pesanan_bulky.satuan;
                }, name: 'jumlagh_barang'},
                {data : function(data, a, b, c) {
                    if (data.status == 0) {
                        return "Pesanan Belum dibayar";
                    } else {
                        return "Sudah dibayar";
                    }
                }, name: 'status_pembayaran'},
                {data : 'action', name: 'action'}
                // {
                //   data : 'pengurus.gudang', render:function(data,a,b,c){
                //         return data[0].nama;
                //   }
                // },
            ]
        });

        function change(id) {
            // console.log($('#status-rak-'+id).get(0))
            $('#status-pesan-'+id).text('Loading');
            
            $.ajax({
                url: "/api/v1/bulky/pemesanan/masuk/"+id+"/status",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    table.ajax.reload();
                    // let result = response.data.status;
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        };

        function detail(id){
            $('#noPemesan').text('LOADING...')
            $('#namaPemesan').text('LOADING...')
            $('#gudangPemesan').text('LOADING...')
            $('#tglPemesan').text('LOADING...')
            $('#metodeBayar').text('LOADING...')
            $('#statusBayar').text('LOADING...')
            $('#alamatPemesan').text('LOADING...')
            $('#telepon').text('LOADING...')
            $('#bulky').text('LOADING...')
            $('#penerima').text('LOADING...')

            $.ajax({
                url: "/api/v1/bulky/detail/pemesanan/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    // console.log(response.data)
                    let pemesanan = response.data;

                    $('#noPemesan').text(pemesanan.nomor_pemesanan)
                    $('#namaPemesan').text(pemesanan.nama_pemesan)
                    $('#gudangPemesan').text(pemesanan.retail.nama)
                    $('#tglPemesan').text(pemesanan.tanggal_pemesanan)
                    $('#metodeBayar').text(pemesanan.metode_pembayaran)
                    $('#statusBayar').text((pemesanan.status == 0) ? 'Belum Dibayar' : 'Sudah Dibayar')
                    $('#alamatPemesan').text(pemesanan.alamat_pemesan)
                    $('#telepon').text(pemesanan.telepon)
                    $('#bulky').text(pemesanan.bulky.nama)
                    $('#penerima').text(pemesanan.penerima_po)

                    $('#barangData').append(`
                        <td>${pemesanan.barang_pesanan_bulky.barang_kode}</td>
                        <td>${pemesanan.barang_pesanan_bulky.nama_barang}</td>
                        <td>${pemesanan.barang_pesanan_bulky.jumlah_barang} ${pemesanan.barang_pesanan_bulky.satuan}</td>
                        <td>Rp. ${(pemesanan.barang_pesanan_bulky.harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."))}</td>
                        <td>Rp. ${(pemesanan.barang_pesanan_bulky.biaya_admin.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."))}</td>
                        `)

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }

        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/pemesanan/'+id

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
