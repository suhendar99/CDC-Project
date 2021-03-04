@php
        $icon = 'storage';
        $pageTitle = 'Data Pemesanan Dari Retail';
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
                                <th>Tanggal Pemesanan</th>
                                <th>No Pemesanan (Invoice)</th>
                                <th>Nama Pemesan</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Satuan</th>
                                <th>Total Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi Pemesanan</th>
                                <th>Aksi</th>
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
                        <tr>
                          <th scope="row">Status Pemesanan</th>
                          <td id="statusPesan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Status Pembayaran</th>
                          <td id="statusBayar"></td>
                        </tr>
                        <tr>
                          <th scope="row">Metode Pembayaran</th>
                          <td id="metodeBayar"></td>
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

<!-- Modal Bukti Pembayaran -->
{{-- <div class="modal fade" id="modalValidasi" tabindex="-1" aria-labelledby="modalNewValidate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNewValidate">Detail Pemesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="form-bukti">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Bukti Pembayaran <small class="text-success">*Harus diisi</small></label>
                        <input type="file" id="foto_bukti" class="form-control-file @error('foto_bukti') is-invalid @enderror" name="foto_bukti">
                        @error('foto_bukti')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm" >Submit</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
                </form>
      </div>
    </div>
</div> --}}
<!-- Modal -->
<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="modalBukti" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <form action="" id="verifikasi" method="get" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBukti">Bukti Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5 id="loader" class="text-center"></h5>
                <div class="row p-2">
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="jumlah_uang" placeholder="Jumlah Uang yang Dibayar">
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="jumlah_dalam_foto" placeholder="Jumlah Uang Dalam Foto">
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="selisih" placeholder="Selisih">
                  </div>
                </div>
            <img src="" class="w-100" id="foto_bukti">
        </div>
        <div class="modal-footer">
            <button type="submit" id="terima" class="btn btn-sm btn-primary">Sesuai</button>
            <a href="" id="tidakSesuai" class="btn btn-sm btn-warning">Tidak Sesuai</a>
        </div>
        </form>
        {{-- <div class="modal-footer">

          Apakah Sudah Sesuai ? <a id="button_accept" href="" class="btn btn-primary btn-sm">Ya</a> <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tidak</button>
        </div> --}}
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
                // {data : 'tanggal_pemesanan', name: 'tanggal_pemesanan'},
                // {data : 'nomor_pemesanan', name: 'no_pemesanan'},
                // {data : 'nama_pemesan', name: 'nama_pemesan'},
                // {data : function(data, a, b, c) {
                //     return data.barang_pesanan_bulky.jumlah_barang+' '+data.barang_pesanan_bulky.satuan;
                // }, name: 'jumlagh_barang'},
                // {data : function(data, a, b, c) {
                //     if (data.status == 0) {
                //         return `<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalValidasi" data-id="" onclick="bukti(${data.id})" style="cursor: pointer;" title="Klik jika pemesan sudah membayar.">Validasi/Pembayaran</a>`;
                //     } else if(data.status == 1) {
                //         return `<a class="btn btn-info btn-sm col-12" data-toggle="modal" data-id="" onclick="proses(${data.id})" style="cursor: pointer;" title="Klik untuk membuat data barang keluar.">Pengemasan</a>`;
                //     }else if(data.status == 2){
                //         return `<button type="button" class="btn btn-info btn-sm col-12" data-id="" title="Pesanan sedang dalam pengiriman">Dikirim</button>`;
                //     }else if(data.status == 3){
                //         return `<button type="button" class="btn btn-success btn-sm col-12" data-id="" title="Pesanan Diterima Pemesan">Pesanan Diterima</button>`;
                //     }
                // }, name: 'status_pembayaran'},
                // {data : 'action', name: 'action'}
                // {
                //   data : 'pengurus.gudang', render:function(data,a,b,c){
                //         return data[0].nama;
                //   }
                // },
                {data : 'pemesanan_bulky.tanggal_pemesanan', name: 'tanggal_pemesanan'},
                {data : 'pemesanan_bulky.nomor_pemesanan', name: 'nomor_pemesanan'},
                {data : 'pemesanan_bulky.nama_pemesan', name: 'nama_pemesan'},
                {data : 'nama_barang', name: 'nama_barang'},
                {data : 'jumlah_barang', name: 'jumlah_barang'},
                {data : 'satuan', name: 'satuan'},
                {data : 'total_pembayaran', name: 'total_pembayaran'},
                {data : 'metode_pembayaran', name: 'metode_pembayaran'},
                {data : 'status_pembayaran', name: 'status_pembayaran'},
                {data : 'status_pemesanan', name: 'status_pemesanan'},
                {data : 'bukti_pembayaran', name: 'bukti_pembayaran'},
                {data : 'aksi_pemesanan', name: 'aksi_pemesanan'},
                {data : 'action', name: 'action'}
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

        // function bukti(id) {
        //     $('#form-bukti').attr('action', '/v1/bulky/validate/bukti/'+id);
        // }
        function bukti(id){
            $('#loader').text('Loading ...');
            $.ajax({
                url: "/api/v1/getDataPemesanan/retail/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data);
                    $('#loader').text('');
                    $('#foto_bukti').attr('src',`${response.data.pemesanan_bulky.foto_bukti}`);

                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }

        function proses(id) {
            window.location.replace('/v1/bulky/storage/keluar/create?pemesanan='+id);
        }

        $('#jumlah_dalam_foto').on('input', function () {
            $('#selisih').val(parseInt($('#jumlah_uang').val()) - parseInt($('#jumlah_dalam_foto').val()))
        });

        function bukti(id){
            $('#loader').text('Loading ...');
            $.ajax({
                url: "/api/v1/getDataPemesanan/retail/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data);
                    $('#loader').text('');
                    $('#foto_bukti').attr('src',`${response.data.pemesanan_bulky.foto_bukti}`);
                    $('#jumlah_uang').val(response.data.harga);
                    $('#verifikasi').attr('action','/v1/validasi/bukti/retail/'+id)
                    $('#tidakSesuai').attr('href','/v1/tidak-sesuai/pesanan/retail/'+id)
                    $('#tolak').attr('href','/v1/tolak/pesanan/bulky/'+id)
                    if (response.data.pemesanan_bulky.status == 2 || response.data.pemesanan_bulky.status == 0 ) {
                      $('#tidakSesuai').addClass('d-none')
                      $('#jumlah_uang').addClass('d-none');
                      $('#jumlah_dalam_foto').addClass('d-none');
                      $('#selisih').addClass('d-none');
                      $('#terima').addClass('d-none');
                    } else if (response.data.pemesanan_bulky.status == 1 || response.data.pemesanan_bulky.status == 7) {
                      $('#tidakSesuai').removeClass('d-none')
                      $('#jumlah_uang').removeClass('d-none');
                      $('#jumlah_dalam_foto').removeClass('d-none');
                      $('#selisih').removeClass('d-none');
                      $('#terima').removeClass('d-none');
                    }
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }

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

            $('#barangData').html(`<td colspan="5">LOADING...</td>`)

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
                    if (pemesanan.status == 0) {
                        $('#statusPesan').text('Menunggu Pembayaran')
                    } else if(pemesanan.status == 1) {
                        $('#statusPesan').text('Proses Pengemasan')
                    } else if(pemesanan.status == 2) {
                        $('#statusPesan').text('Sedang Dikirim')
                    }
                    $('#alamatPemesan').text(pemesanan.alamat_pemesan)
                    $('#telepon').text(pemesanan.telepon)
                    $('#bulky').text(pemesanan.bulky.nama)
                    $('#penerima').text(pemesanan.penerima_po)


                    $('#barangData').html(``)

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
            formDelete.action = '/v1/bulky/pemesanan/masuk/delete/'+id

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
