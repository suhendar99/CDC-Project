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
                                <th>Timestamp</th>
                                <th>No Pemesanan (Invoice)</th>
                                <th>Nama Pemesan</th>
                                <th>Jumlah Barang</th>
                                <th>Status Pembayaran</th>
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
                        <div class="col-md-8">: HIii</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Nomor Pemesanan</div>
                        <div class="col-md-8">: HIii</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Nama Pemesan</div>
                        <div class="col-md-8">: HIii</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Telepon Pemesan</div>
                        <div class="col-md-8">: HIii</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Alamat Pemesan</div>
                        <div class="col-md-8">: HIii</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Metode Pembayaran</div>
                        <div class="col-md-8">: HIii</div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
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
            ajax : "{{ route('pemesanan.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'pesanan.tanggal_pemesanan', name: 'tanggal_pemesanan'},
                {data : 'pesanan.nomor_pemesanan', name: 'nomor_pemesanan'},
                {data : 'pesanan.nama_pemesan', name: 'nama_pemesan'},
                {data : 'jumlah_barang', name: 'jumlah_barang'},
                {data : 'status_pembayaran', name: 'status_pembayaran'},
                {data : 'status_pemesanan', name: 'status_pemesanan'},
                {data : 'action', name: 'action'}
            ],
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
