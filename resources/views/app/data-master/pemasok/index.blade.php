@php
        $icon = 'dashboard';
        $pageTitle = 'Dashboard Admin';
        $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
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
            <a href="#" class="text-14"></a>
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
                                <h5>Data Pemasok</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('pemasok.create')}}" class="btn btn-primary btn-sm">Tambah Data Pemasok</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pemasok</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
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
                <span>Foto Pemasok</span><br>
                <div id="foto" class="my-4"></div>
            </div>
              <div class="col-12">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Pemasok</th>
                            <td class="nama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Tempat/Tanggal Lahir</th>
                          <td class="ttl"></td>
                        </tr>
                        <tr>
                          <th scope="row">Jenis Kelamin</th>
                          <td class="jk"></td>
                        </tr>
                        <tr>
                          <th scope="row" rowspan="4">Alamat</th>
                          <td class="alamat"></td>
                        </tr>
                        <tr>
                            <td class="desa"></td>
                        </tr>
                        <tr>
                            <td class="kecamatan"></td>
                        </tr>
                        <tr>
                            <td class="kabupaten"></td>
                        </tr>
                        <tr>
                          <th scope="row">Agama</th>
                          <td class="agama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Status Perkawinan</th>
                          <td class="sp"></td>
                        </tr>
                        <tr>
                          <th scope="row">Pekerjaan</th>
                          <td class="pekerjaan"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kewarganegaraan</th>
                          <td class="kewarganegaraan"></td>
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
    let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('pemasok.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'kode_pemasok', name: 'kode_pemasok'},
                {data : 'nama', name: 'nama'},
                {data : 'alamat', render:function(data,a,b,c){
                        return (data == null || data == "") ? "Mohon Lengkapi Data !" : data;
                    }
                },
                {data : 'telepon', render:function(data,a,b,c){
                        return (data == null || data == "") ? "Mohon Lengkapi Data !" : data;
                    }
                },
                {data : 'action', name: 'action'}
            ]
        });
        function detail(id){
            $('#foto').text("Mendapatkan Data.......")
            $('.nama').text("Mendapatkan Data.......")
            $('.ttl').text("Mendapatkan Data.......")
            $('.jk').text("Mendapatkan Data.......")
            $('.alamat').text("Mendapatkan Data.......")
            $('.desa').text("Mendapatkan Data.......")
            $('.kecamatan').text("Mendapatkan Data.......")
            $('.kabupaten').text("Mendapatkan Data.......")
            $('.agama').text("Mendapatkan Data.......")
            $('.sp').text("Mendapatkan Data.......")
            $('.pekerjaan').text("Mendapatkan Data.......")
            $('.kewarganegaraan').text("Mendapatkan Data.......")
            $.ajax({
                url: "/api/v1/getPemasok/"+id,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $.each(response.data, function (a, b) {
                        console.log(b.kabupaten.nama);
                        // $('#btn-edit').attr('href', '/v1/saranaPrasaranaUPTD/'+b.id+'/edit').removeClass('btn-progress');
                        // $('#btn-delete').attr('onclick', 'sweet('+b.id+')').removeClass('btn-progress');
                            $('.nama').text(b.nama)
                            $('.ttl').text(b.tempat_lahir+`,`+b.tgl_lahir)
                            $('.jk').text(b.jenis_kelamin)
                            $('.alamat').text(b.alamat)
                            $('.desa').text(`Desa `+b.desa.nama)
                            $('.kecamatan').text(`Kec. `+b.kecamatan.nama)
                            $('.kabupaten').text(b.kabupaten.nama)
                            $('.agama').text(b.agama)
                            $('.sp').text(b.status_perkawinan)
                            $('.pekerjaan').text(b.pekerjaan)
                            $('.kewarganegaraan').text(b.kewarganegaraan)
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
            formDelete.action = '/v1/pemasok/'+id

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
