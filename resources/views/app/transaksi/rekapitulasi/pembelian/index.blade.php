@php
        $icon = 'book';
        $pageTitle = 'Rekapitulasi Pembelian Barang';
        $dashboard = true;
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
            <a href="#" class="text-14">Data Master</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Rekapitulasi Pembelian Barang</a>
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
                                <h5>Total Pembelian : Rp. {{Number_format($total,0,',','.')}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('rekapPembelian.download.pdf')}}" class="btn btn-primary btn-sm" target="__blank"><i class="far fa-file-pdf"></i> Download PDF</a>
                                <a href="{{route('rekapPembelian.download.excel')}}" class="btn btn-primary btn-sm" target="__blank"><i class="far fa-file-excel"></i> Download EXCEL</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pembelian</th>
                                <th>No Pembelian</th>
                                {{-- <th>No Kwitansi</th>
                                <th>No Surat Jalan</th> --}}
                                <th>Nama penjual</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Barang</th>
                                <th>Total Harga</th>
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
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
    let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('rekapitulasiPembelian.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'tanggal_pembelian', name: 'tanggal_pembelian'},
                {data : 'no_pembelian', name: 'no_pembelian'},
                // {data : 'no_kwitansi', name: 'no_kwitansi'},
                // {data : 'no_surat_jalan', name: 'no_surat_jalan'},
                {data : 'nama_penjual', name: 'nama_penjual'},
                {data : 'barang', name: 'barang'},
                {data : 'jumlah', name: 'jumlah'},
                {data : 'harga', name: 'harga'},
                {data : 'total', name: 'total'},
                // {data : 'action', name: 'action'}
            ]
        });

        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/rekapitulasiPembelian/'+id

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
{{--  --}}
@endpush
