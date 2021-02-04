@php
        $icon = 'storage';
        $pageTitle = 'Data Gudang';
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
                                <form action="{{route('gudang.search')}}" method="post" style="width: 100%;">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="nama" class=" form-control" placeholder=" Cari gudang Retail..." aria-label="Cari gudang..." aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-secondary">search</button>
                                        </div>
                                    </div>
                                </form>
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
                @if(count($data) > 0)
                @foreach($data as $gudang)
                <div class="col-4">
                    <div class="card">
                        <img src="{{ ($gudang->foto == null) ? asset('images/image-not-found.jpg') : asset($gudang->foto) }}" alt="Card Image" class="card-img-top" style="height: 150px;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5>{{ $gudang->nama }}</h5>
                                    <span>{{ $gudang->nomor_gudang }}</span>
                                    @php
                                        $status = 0;
                                        foreach ($gudang->rak as $value) {
                                            if ($value->status == 1) {
                                                $status++;
                                            }
                                        }

                                        if ($gudang->rak_count != 0 && $status == $gudang->rak_count) {
                                            echo '<span class="text-danger">Gudang Penuh</span>';
                                        } else {
                                            echo "";
                                        }

                                    @endphp
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="dropdown">
                                                <a href="#" title="Menu" class="dropdown-toggle p-2 float-right" id="dropmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropmenu">
                                                    <a href="{{ route('gudang.edit', $gudang->id) }}" class="dropdown-item">Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal" onclick="detail({{ $gudang->id }})" data-id="{{ $gudang->id }}">Detail</a>
                                                    <a href="{{ route('rak.index', $gudang->id) }}" class="dropdown-item">Rak Gudang</a>
                                                    <a href="#" class="dropdown-item" onclick="sweet({{ $gudang->id }})">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-outline-info btn-sm float-right statusGudang" style="font-size: .7rem;margin-top: 1px;" data-status="{{ $gudang->status }}" data-gudang-id="{{ $gudang->id }}" title="Status Gudang">Loading</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nama Pemilik: {{ $gudang->pemilik }}</li>
                            <li class="list-group-item">Jumlah Rak: {{ $gudang->rak_count }} <a href="{{ route('rak.index', $gudang->id) }}" class="text-primary">Detail</a></li>
                            <li class="list-group-item">Hari Kerja: {{ $gudang->hari }}</li>
                            <li class="list-group-item" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">Jam Kerja: {{ $gudang->jam_buka }} - {{ $gudang->jam_tutup }}</li>
                        </ul>
                        <div class="card-body" style="border-bottom: 5px solid #ffa723;">
                            <h6>Alamat</h5>
                            <p class="card-text">{{ $gudang->alamat }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="footer-copyright text-center pt-4 text-dark fixed">
                        ~ Tidak Ada Data Gudang ~
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            {{ $data->links() }}
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
                <span>Foto Gudang</span><br>
                <div id="foto" class="my-4"></div>
            </div>
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Gudang</th>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kontak</th>
                          <td id="kontak"></td>
                        </tr>
                        <tr>
                          <th scope="row">hari Kerja</th>
                          <td id="hari"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jam Buka</th>
                          <td id="buka"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jam Tutup</th>
                          <td id="tutup"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kapasitas Luas</th>
                          <td id="kapasitas_meter"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kapasitas Berat</th>
                          <td id="kapasitas_berat"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-6">
                  <table class="table">
                      <tbody>
                        <tr>
                          <th scope="row">Provinsi</th>
                          <td id="provinsi"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kabupaten</th>
                          <td id="kabupaten"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kecamatan</th>
                          <td id="kecamatan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Desa</th>
                          <td id="desa"></td>
                        </tr>
                        <tr>
                          <th scope="row">Alamat</th>
                          <td id="alamat"></td>
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

        $(document).ready(function() {
            $.each($('.statusGudang'), function(index, val) {
                if ($(this).data('status') != 0) {
                    $(this).removeClass('btn-outline-info');
                    $(this).addClass('btn-info').text('Aktif');
                    $(this).attr('title', 'Status Gudang Aktif');
                } else {
                    $(this).removeClass('btn-info');
                    $(this).addClass('btn-outline-info').text('Tidak Aktif');
                    $(this).attr('title', 'Status Gudang Tidak Aktif');
                }
                 /* iterate through array or object */
                $(this).click(function(event) {
                    /* Act on the event */
                    let id = $(this).data('gudangId');
                    let status = $(this).data('status');
                    $(this).text('Loading');

                    $.ajax({
                        url: "/api/v1/gudang/"+id+"/status",
                        method: "GET",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: (response)=>{
                            let result = response.data.status;

                            if (result != 0) {
                                $(this).removeClass('btn-outline-info');
                                $(this).addClass('btn-info').text('Aktif');
                                $(this).attr('data-status', 1);
                                $(this).attr('title', 'Status Gudang Aktif');
                            } else {
                                $(this).removeClass('btn-info');
                                $(this).addClass('btn-outline-info').text('Tidak Aktif');
                                $(this).attr('data-status', 0);
                                $(this).attr('title', 'Status Gudang Tidak  Aktif');
                            }
                        },
                        error: (xhr)=>{
                            let res = xhr.responseJSON;
                            console.log(res)
                        }
                    });
                });
            });

        });

        function detail(id){
            $('#foto').text("Mendapatkan Data.......")
            $('#nama').text("Mendapatkan Data.......")
            $('#kontak').text("Mendapatkan Data.......")
            $('#alamat').text("Mendapatkan Data.......")
            $('#hari').text("Mendapatkan Data.......")
            $('#buka').text("Mendapatkan Data.......")
            $('#tutup').text("Mendapatkan Data.......")
            $('#kapasitas_meter').text("Mendapatkan Data.......")
            $('#kapasitas_berat').text("Mendapatkan Data.......")
            $('#provinsi').text("Mendapatkan Data.......")
            $('#kabupaten').text("Mendapatkan Data.......")
            $('#kecamatan').text("Mendapatkan Data.......")
            $('#desa').text("Mendapatkan Data.......")
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
                        $('#nama').text(b.nama)
                        $('#kontak').text(b.kontak)
                        $('#alamat').text(b.alamat)
                        $('#hari').text(b.hari)
                        $('#buka').text(b.jam_buka)
                        $('#tutup').text(b.jam_tutup)
                        $('#kapasitas_meter').text(b.kapasitas_meter+' \u33A1')
                        $('#kapasitas_berat').text(b.kapasitas_berat+' Ton')
                        $('#provinsi').text(b.desa.kecamatan.kabupaten.provinsi.nama)
                        $('#kabupaten').text(b.desa.kecamatan.kabupaten.nama)
                        $('#kecamatan').text(b.desa.kecamatan.nama)
                        $('#desa').text(b.desa.nama)

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
