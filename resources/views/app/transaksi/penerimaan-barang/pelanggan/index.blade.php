@php
        $icon = 'receipt_long';
        $pageTitle = 'Penerimaan Barang';
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
            <a href="#" class="text-14">Transaksi</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Penerimaan Barang</a>
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
            @forelse ($data as $item)
                {{-- {{dd($item->barang->foto != null)}} --}}
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="float-left">
                                    <h5>Penerimaaan Barang Dari {{$item->pemasok->nama}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <form method="POST" action="{{ route('penerimaan.destroy',$item->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-default"><i class="material-icons text-danger">delete_forever</i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 garis">
                                @if ($item->barang->foto != null)
                                    <div class="card shadow card-image">
                                        <img src="{{asset($item->barang->foto)}}" width="100" height="100" alt="Image-Penerimaan-Barang" class="img-border">
                                    </div>
                                @else
                                    <div class="card shadow card-image">
                                        <center><i class="material-icons icon-large">broken_image</i></center>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 valign-center">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{$item->barang->nama_barang}}
                                    </div>
                                    <div class="col-md-12">
                                        Rp {{$item->barang->harga_barang}}   1 {{$item->barang->satuan}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 valign-center">
                                <div class="row">
                                    <div class="col-md-12">
                                        Total Harga
                                    </div>
                                    <div class="col-md-12">
                                        Rp. 800000
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 valign-center">
                                <a href="#" class="btn btn-success btn-sm">Beli Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <center>Tidak Ada Transaksi</center>
            @endforelse
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
            ajax : "{{ route('barang.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'barcode', name: 'barcode'},
                {data : 'nama_barang', name: 'nama_barang'},
                {data : 'harga_barang', name: 'harga_barang'},
                {data : 'kategori.nama', render:function(data,a,b,c){
                        return (data == null || data == "") ? "Kosong !" : data;
                    }
                },
                {data : 'satuan', name: 'satuan'},
                {data : 'foto', render: function (data, type, full, meta) {
                        if(data == null){
                            return "Foto Tidak Ada !"
                        }else{
                            return "<img src=\"{{ asset('') }}" + data + "\" height=\"50px\"width=\"50px\">";
                        }
                    }
                },
                {data : 'action', name: 'action'},
            ]
        });

        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/barang/'+id

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
