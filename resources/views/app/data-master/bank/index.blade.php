@php
        $icon = 'storage';
        $pageTitle = 'Data Bank';
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
            <a href="#" class="text-14">Data Bank</a>
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
                                <a href="{{route('bank.create')}}" class="btn btn-primary btn-sm">Tambah Bank</a>
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
                                <th>Tahun Berdiri</th>
                                <th>Telepon</th>
                                <th>Foto</th>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labe   lledby="exampleModalLabel" aria-hidden="true">
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
            ajax : "{{ route('bank.index') }}",
            columns : [
                {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'nama', name: 'nama'},
                {
                    data : 'tahun_berdiri', render:function(data,a,b,c){
                        if (data == null) {
                            return ""
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data : 'telepon', render:function(data,a,b,c){
                        if (data == null) {
                            return ""
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data : 'foto', render:function(data,a,b,c){
                        if (data == null) {
                            return "";
                        } else {
                            return `<img src="{{ asset('') }}${data}" height=\"50px\"width=\"50px\">`;

                        }
                    }
                },
                {data : 'action', name: 'action'}
            ]
        });

        function detail(id){
            $('.namaBank').text('LOADING...')
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
            formDelete.action = '/v1/bank/'+id

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
