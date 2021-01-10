@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Barang';
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
            <a href="#" class="text-14">Data Barang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Edit Data</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('barang.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('barang.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" name="kode_barang" value="{{ $data->kode_barang }}" placeholder="Enter nama barang">
                                        @error('kode_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Nama Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ $data->nama_barang }}" placeholder="Enter nama barang">
                                        @error('nama_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Harga Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="satuan" class="form-control @error('harga_barang') is-invalid @enderror" name="harga_barang" value="{{  $data->harga_barang }}" placeholder="Enter harga barang">
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ $data->jumlah }}" placeholder="Enter jumlah barang">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Total harga <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" min="0" id="hasil" class="form-control @error('harga_total') is-invalid @enderror" name="harga_total" value="{{ $data->harga_total }}" placeholder="Enter total harga barang">
                                        @error('harga_total')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kategori Barang <small class="text-success">*Harus diisi</small></label>
                                        <select name="kategori_id" id="" class="form-control">
                                            <option value="0">--Pilih Kategori--</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{$item->id}}" {{ $data->kategori_id == $item->id ? 'selected' : ''}}>{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Berat Per Item <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('berat_satuan') is-invalid @enderror" name="berat_satuan" value="{{ $data->berat_satuan }}" placeholder="Enter Berat Satuan">
                                        @error('berat_satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <select class="form-control @error('satuan') is-invalid @enderror" name="satuan"  placeholder="Enter satuan">
                                            <option value="kg">kg</option>
                                            <option value="ons">ons</option>
                                            <option value="gram">gram</option>
                                            <option value="ml">ml</option>
                                            <option value="m3">m<sup>3</sup></option>
                                            <option value="m2">m<sup>2</sup></option>
                                            <option value="m">m</option>
                                            <option value="gram">cm</option>
                                        </select>
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="float-left">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-right">
                                                <a href="{{route('create.barang',$data->id)}}" class="btn btn-primary btn-sm">Tambah Foto Barang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                @if ($foto->count() > 1)
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                        </div>
                                      </div>
                                  </div>
                            </form>
                        </div>
                    </div>
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
        var count = JSON.parse('{!!json_encode($foto)!!}')
        console.log(count);
        let counter = 0;
        for (let i = 0; i < count.length; i++) {
            counter++;
            // console.log(count[i].length);
        }
        console.log(counter);
        let columns = [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'foto', render: function (data, type, full, meta) {
                        if(data == null){
                            return "Foto Tidak Ada !"
                        }else{
                            return "<img style='object-fit: scale-down;' src=\"{{ asset('') }}" + data + "\" height=\"50px\"width=\"50px\">";
                        }
                    }
                },
            ]
            if (counter > 1) {
                columns.push({data : 'action', name: 'action'})
            }
        let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('barang.edit',$data->id) }}",
            columns : columns
        });

        function sweet(id){
            const formDelete = document.getElementById('formDelete')
            formDelete.action = '/v1/delete-foto-barang/'+id

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
        $('#jumlah').on('keyup',(value) => {
            console.log($('#jumlah').val() * $('#satuan').val())
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
        $('#satuan').on('keyup',(value) => {
            console.log($('#jumlah').val() * $('#satuan').val())
            $('#hasil').val($('#jumlah').val() * $('#satuan').val())
        })
</script>
{{--  --}}
@endpush
