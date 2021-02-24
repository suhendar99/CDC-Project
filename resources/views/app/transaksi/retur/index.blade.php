@php
        $icon = 'storage';
        $pageTitle = 'Data Retur Masuk';
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
            <a href="#" class="text-14">Data Retur Masuk</a>
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
                                {{-- <a href="{{route('returIn.create')}}" class="btn btn-primary btn-sm">Buat Retur Masuk</a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Kode Kwitansi</th>
                                <th>Nama Pemesan</th>
                                <th>Barang</th>
                                <th>Keterangan</th>
                                {{-- <th>Action</th> --}}
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
            <div class="col-12 text-center">
                <span>Foto Bank</span><br>
                <div id="foto" class="my-4"></div>
            </div>
          </div>
          <div class="row">
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Bank</th>
                            <td class="namaBank"></td>
                        </tr>
                        <tr>
                          <th scope="row">Tahun Berdiri</th>
                          <td class="tahun"></td>
                        </tr>
                        <tr>
                          <th scope="row">Telepon</th>
                          <td class="telepon"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Akun</th>
                            <td class="namaAkun"></td>
                        </tr>
                        <tr>
                          <th scope="row">Username</th>
                          <td class="username"></td>
                        </tr>
                        <tr>
                          <th scope="row">E-mail</th>
                          <td class="email"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <table class="table">
                      <tbody>
                        <tr>
                          <th>Alamat</th>
                          <td class="alamat"></td>
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
            ajax : "{{ route('returIn.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'tanggal_pengembalian', name: 'tanggal_pengembalian'},
                {data : 'kwitansi.kode', name: 'kode'},
                {data : 'kwitansi.pemesanan.nama_pemesan', name: 'nama_pemesan'},
                {data : 'barang', render:function(data,a,b,c){
                        let van = '';
                        console.log(data)
                        for (var i = data.length - 1; i >= 0; i--) {
                            let col = '<li>( '+data[i].kode_barang+' ) '+data[i].nama_barang+'</li>';
                            van += col;
                        }

                        let o = '<ul>'+ van + '</ul>';
                        return o;
                    }
                },
                {data : 'keterangan', name: 'keterangan'},
                // {data : 'action', name: 'action'}
            ]
        });

        function detail(id){
            $('.namaBank').text('LOADING...')
            $('.namaAkun').text('LOADING...')
            $('.username').text('LOADING...')
            $('.email').text('LOADING...')
            $('.tahun').text('LOADING...')
            $('.telepon').text('LOADING...')
            $('.alamat').text('LOADING...')

            $.ajax({
                url: "/api/v1/detail/bank/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    // console.log(response.data)
                    let bank = response.data;

                    $('.namaBank').text(bank.nama)
                    $('.namaAkun').text(bank.user[0].name)
                    $('.username').text(bank.user[0].username)
                    $('.email').text(bank.user[0].email)
                    $('.tahun').text(bank.tahun_berdiri)
                    $('.telepon').text(bank.telepon)
                    $('.alamat').text(bank.alamat)

                    if (bank.foto == null) {
                        $("#foto").text('- Tidak Ada Foto Bank -');
                    }else{
                        $("#foto").html(`<img class="foto" style="width:100%; height:300px;" src="{{asset('${bank.foto}')}}">`);
                    }
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                }
            });
        }
        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/retur/'+id

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
