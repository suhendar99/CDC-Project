@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5>Data Gudang</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('in.create')}}" class="btn btn-primary btn-sm">Buat Storage In</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Gudang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
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
@push('script')
    <script>
        let table = $('#data_table').DataTable({
            processing : true,
            serverSide : true,
            responsive: true,
            ordering : false,
            pageLength : 10,
            ajax : "{{ route('in.index') }}",
            columns : [
                // {data : 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
                {data : 'kode', name: 'kode'},
                {
                    data : 'gudang', render:function(data,a,b,c){
                        return data.nama;
                    }
                },
                {data : 'barang', render:function(data,a,b,c){
                        return data.nama_barang;
                    }
                },
                {
                    data: function (data, type, row, meta) {
                        return data.jumlah + " " + data.satuan;
                    },
                    name: 'jumlah'
                },
                {data : 'action', name: 'action'}
            ]
        });
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
                            $('.kapasitas').text(b.kapasitas+'Kg')
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
@endpush
@endsection
