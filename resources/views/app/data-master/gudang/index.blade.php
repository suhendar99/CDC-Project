@php
        $icon = 'storage';
        $pageTitle = 'Data Gudang';
        $dashboard = true;
        $admin = true;
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
            <a href="#" class="text-14">Data Gudang</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('gudang.create')}}" class="btn btn-primary btn-sm">Tambah Data Gudang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @foreach($data as $gudang)
                <div class="col-4">
                    <div class="card">
                        <img src="{{ asset($gudang->foto) }}" alt="Card Image" class="card-img-top" style="height: 150px;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <h5>{{ $gudang->nama }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        <div class="dropdown">
                                            <a href="#" title="Menu" class="dropdown-toggle p-2" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropmenu">
                                                <a href="{{ route('gudang.edit', $gudang->id) }}" class="dropdown-item">Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail({{ $gudang->id }})" data-id="{{ $gudang->id }}">Detail</a>
                                                <a href="{{ route('rak.index', $gudang->id) }}" class="dropdown-item">Rak Gudang</a>
                                                <a href="#" class="dropdown-item" onclick="sweet({{ $gudang->id }})">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Hari Kerja: {{ $gudang->hari }}</li>
                            <li class="list-group-item" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">{{ $gudang->jam_buka }} - {{ $gudang->jam_tutup }}</li>
                        </ul>
                        <div class="card-body" style="border-bottom: 5px solid #ffa723;">
                            <h6>Alamat</h5>
                            <p class="card-text">{{ $gudang->alamat }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
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
          <h5 class="modal-title" id="exampleModalLabel">Detail Data Gudang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12 mb-3">
                  <h3 id="nama"></h3>
              </div>
          </div>
          <div class="row">
            <div class="col-12 text-center">
                <span>Foto Barang</span><br>
                <div id="foto" class="my-4"></div>
            </div>
              <div class="col-12">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Gudang</th>
                            <td class="nama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kontak</th>
                          <td class="kontak"></td>
                        </tr>
                        <tr>
                          <th scope="row">Alamat</th>
                          <td class="alamat"></td>
                        </tr>
                        <tr>
                          <th scope="row">hari Kerja</th>
                          <td class="hari"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jam Buka</th>
                          <td class="buka"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jam Tutup</th>
                          <td class="tutup"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kapasitas</th>
                          <td class="kapasitas"></td>
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
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
    // let table = $('#data_table').DataTable({
    //         processing : true,
    //         serverSide : true,
    //         responsive: true,
    //         ordering : false,
    //         pageLength : 10,
    //         ajax : "{{-- route('gudang.index') --}}",
    //         columns : [
    //             {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
    //             {data : 'nama', name: 'nama'},
    //             {data : 'alamat', render:function(data,a,b,c){
    //                     return (data == null || data == "") ? "Mohon Lengkapi Data !" : data;
    //                 }
    //             },
    //             {data : 'kontak', render:function(data,a,b,c){
    //                     return (data == null || data == "") ? "Mohon Lengkapi Data !" : data;
    //                 }
    //             },
    //             {data : 'hari', name: 'hari'},
    //             {data : 'action', name: 'action'}
    //         ]
    //     });

        function detail(id){
            $('#foto').text("Mendapatkan Data.......")
            $('.nama').text("Mendapatkan Data.......")
            $('.kontak').text("Mendapatkan Data.......")
            $('.alamat').text("Mendapatkan Data.......")
            $('.hari').text("Mendapatkan Data.......")
            $('.buka').text("Mendapatkan Data.......")
            $('.tutup').text("Mendapatkan Data.......")
            $('.kapasitas').text("Mendapatkan Data.......")
            $.ajax({
                url: "/api/v1/getGudang/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $.each(response.data, function (a, b) {
                        // $('#btn-edit').attr('href', '/v1/saranaPrasaranaUPTD/'+b.id+'/edit').removeClass('btn-progress');
                        // $('#btn-delete').attr('onclick', 'sweet('+b.id+')').removeClass('btn-progress');
                            $('.nama').text(b.nama)
                            $('.kontak').text(b.kontak)
                            $('.alamat').text(b.alamat)
                            $('.hari').text(b.hari)
                            $('.buka').text(b.jam_buka)
                            $('.tutup').text(b.jam_tutup)
                            $('.kapasitas').text(b.kapasitas+' \u33A1')
                        if (b.foto == null) {
                            $("#foto").text('- Tidak Ada Foto Barang -');
                        }else{
                            $("#foto").html(`<img class="foto" style="width:100%; height:300px;" src="{{asset('${b.foto}')}}">`);
                        }
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
            formDelete.action = '/v1/gudang/'+id

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
