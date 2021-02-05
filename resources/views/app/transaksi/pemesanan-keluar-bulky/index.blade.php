@php
        $icon = 'storage';
        $pageTitle = 'Data Pembelian ke Pemasok';
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
            <a href="#" class="text-14">Data Pembelian ke Pemasok</a>
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
                                <a href="{{ route('bulky.pemesanan.keluar.create') }}" class="btn btn-primary btn-sm">Buat Data Pemesanan Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nomor Pemesanan</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Satuan</th>
                                <th>Pemasok</th>
                                <th>Nama Gudang Bulky</th>
                                <th>Alamat</th>
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
              <div class="col-12">
                  <table class="table">
                      <thead>
                          <tr>
                              <th scope="row">Tingkat Rak</th>
                              <th scope="row">Nama Barang</th>
                              <th scope="row">Stok Barang</th>
                          </tr>
                      </thead>
                      <tbody id="inputBarang">
                        {{-- <tr>
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
                        </tr> --}}
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
          var table = $('#data_table').DataTable({
              processing : true,
              serverSide : true,
              responsive: true,
              ordering : false,
              pageLength : 10,
              ajax : "{{ route('bulky.pemesanan.keluar.index') }}",
              columns : [
                  // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                  {data : 'nomor_pemesanan', name: 'kode'},
                  {data : 'tanggal_pemesanan', name: 'tgl'},
                  {data : 'barang_kode', name: 'barang_kode'},
                  {data : 'barang.nama_barang', name: 'nama_barang'},
                  {data : 'jumlah', name: 'jumlah'},
                  {data : 'satuan', name: 'satuan'},
                  {data : 'barang.pemasok.nama', name: 'nama_pemasok'},
                  {data : 'bulky.nama', name: 'nama'},
                  {data : 'alamat_pemesan', name: 'alamat'},
                  {data : 'action', name: 'action'},
              ]
          });

        function change(id) {
            // console.log($('#status-rak-'+id).get(0))
            $('#status-rak-'+id).text('Loading');

            $.ajax({
                url: "/api/v1/rak/"+id+"/status",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    table.ajax.reload();
                    let result = response.data.status;

                    if (result != 0) {
                        $('#status-rak-'+id).removeClass('btn-outline-dark');
                        $('#status-rak-'+id).addClass('btn-success').text('Penuh');
                        // $('#status-rak-'+id).attr('data-status', 1);
                    } else {
                        $('#status-rak-'+id).removeClass('btn-success');
                        $('#status-rak-'+id).addClass('btn-outline-dark').text('Tidak Penuh');
                        // $('#status-rak-'+id).attr('data-status', 0);
                    }
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
          };

        function detail(id){
            $('#inputBarang').html(``);
            $.ajax({
                url: "/api/v1/rak/"+id+"/barang",
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    let storage = response.data;
                    let array = [];
                    let tingkat = ``;

                    $.each(response.data.tingkat, function(index, val) {
                         /* iterate through array or object */
                          let store = ``;
                         $.each(val.storage, function(i, b) {
                              /* iterate through array or object */
                              $('#inputBarang').append(`<tr>
                                <td>${val.nama}</td>
                                <td>${b.storage_in.barang.nama_barang}</td>
                                <td>${b.jumlah + b.satuan}</td>
                                </tr>`);
                             // array.push(b.storageIn.barang.nama)
                         });

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
            formDelete.action = '/v1/bulky/pemesanan/keluar/'+id

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
