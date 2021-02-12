@php
        $icon = 'storage';
        $pageTitle = 'Data Pemilik Gudang Bulky';
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
            <a href="#" class="text-14">Data Master</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Pemilik Gudang Bulky</a>
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
                                {{-- <a href="{{route('pemilik-gudang-bulky.create')}}" class="btn btn-primary btn-sm">Tambah Pemilik Gudang Bulky</a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Agama</th>
                                <th>Pekerjaan</th>
                                <th>ALamat</th>
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
@push('script')
    <script>
        let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('pemilik-gudang-bulky.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'nama', name: 'nama'},
                {data : 'telepon', name: 'telepon'},
                {data : 'ttl', name: 'ttl'},
                {data : 'agama', name: 'agama'},
                {data : 'pekerjaan', name: 'pekerjaan'},
                {data : 'alamat', name: 'alamat'},
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
            formDelete.action = '/v1/pemilik-gudang-bulky/'+id

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