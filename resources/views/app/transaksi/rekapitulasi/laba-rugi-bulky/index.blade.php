@php
        $icon = 'storage';
        $pageTitle = 'Data Laba Rugi Bulky';
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
            <a href="#" class="text-14">Data Rekapitulasi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Laba Rugi Bulky</a>
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
                                <a href="{{route('bulky.laba-rugi.create')}}" class="btn btn-primary btn-sm">Buat Data Laba Rugi</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu Pencatatan</th>
                                <th>Bulan</th>
                                <th>Laba Kotor</th>
                                <th>Penjualan</th>
                                <th>Pembelian</th>
                                <th>Biaya Operasional</th>
                                <th>Laba Bersih</th>
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
@push('script')
    <script>
        let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('bulky.laba-rugi.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : function(data){
                        let current_datetime = new Date(data.created_at);
                        return current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();

                    }, name: 'waktu'},
                {
                    data : 'bulan', render:function(data,a,b,c){
                        if (data == 1) {
                            return 'Januari';
                        } else if (data == 2) {
                            return 'Februari'
                        } else if (data == 3) {
                            return 'Maret'
                        } else if (data == 4) {
                            return 'April'
                        } else if (data == 5) {
                            return 'Mei'
                        } else if (data == 6) {
                            return 'Juni'
                        } else if (data == 7) {
                            return 'Juli'
                        } else if (data == 8) {
                            return 'Agustus'
                        } else if (data == 9) {
                            return 'September'
                        } else if (data == 10) {
                            return 'Oktober'
                        } else if (data == 11) {
                            return 'November'
                        } else if (data == 12) {
                            return 'Desember'
                        }
                    }
                },
                {
                    data : 'laba_kotor', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {
                    data : 'penjualan', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {
                    data : 'pembelian', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {
                    data : 'biaya_operasional', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {
                    data : 'laba_bersih', render:function(data,a,b,c){
                        return 'Rp. '+ (data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    }
                },
                {data : 'action', name: 'action'}
            ]
        });

        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/bulky/laba-rugi/'+id

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
