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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5>Data Barang</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <form action="{{route('get-barang')}}" method="get" class="form-inline d-flex justify-content-center">
                                    @csrf
                                    <!-- Search form -->
                                    <input class="form-control form-control-sm mr-3 W-500" type="text" name="search" placeholder="Search" aria-label="Search">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($barang as $item)
                            <div class="col-md-3 col-sm-6">
                                <div class="col-md-12">
                                    <div class="card shadow" style="width: 18rem;">
                                        <a data-toggle="modal" data-target="#exampleModal" onclick="detail({{$item->id}})" data-id="{{$item->id}}" style="cursor: pointer;" title="Detail">
                                        <img class="card-img-top" style="width: 100%; height: 150px;" src="{{asset($item->foto)}}" alt="Card image cap">
                                        <div class="card-body">
                                        <center><p class="card-text">{{$item->nama_barang}}</p></center>
                                        {{-- <center><p class="card-text">{{$item->kategori->nama}}</p></center> --}}
                                        <center><p class="card-text">Rp {{$item->harga_barang}}</p></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <center>== Tidak Ada Data {{$else}} ==</center>
                            </div>
                        @endforelse
                        <div class="col-12 d-flex justify-content-center">
                            <center>
                                {{$barang->links()}}
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <div class="col-12 text-center">
                <span>Foto Barang</span><br>
                <div id="foto" class="my-4"></div>
            </div>
              <div class="col-12">
                  <table class="table">
                      <tbody>
                        <tr>
                            <th scope="row">Nama Supplier</th>
                            <td class="pemasok"></td>
                        </tr>
                        <tr>
                          <th scope="row">Nama Barang</th>
                          <td class="nama"></td>
                        </tr>
                        <tr>
                          <th scope="row">Kategori Barang</th>
                          <td class="kategori"></td>
                        </tr>
                        <tr>
                          <th scope="row">harga Barang</th>
                          <td class="harga"></td>
                        </tr>
                        <tr>
                          <th scope="row">Satuan</th>
                          <td class="satuan"></td>
                        </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
        {{-- <div class="modal-footer">
          <a href="#" class="btn btn-warning btn-progress" id="btn-edit">Edit</a>
          <button type="submit" class="btn btn-danger btn-progress" id="btn-delete">Delete</button>
        </div> --}}
      </div>
    </div>
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
    function detail(id){
        $('#foto').text("Mendapatkan Data Dari Server.......")
        $('.pemasok').text("Mendapatkan Data Dari Server.......")
        $('.nama').text("Mendapatkan Data Dari Server.......")
        $('.kategori').text("Mendapatkan Data Dari Server.......")
        $('.harga').text("Mendapatkan Data Dari Server.......")
        $('.satuan').text("Mendapatkan Data Dari Server.......")
        $.ajax({
            url: "/api/v1/getBarang/"+id,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                console.log(response.data)
                $.each(response.data, function (a, b) {
                    // $('#btn-edit').attr('href', '/v1/saranaPrasaranaUPTD/'+b.id+'/edit').removeClass('btn-progress');
                    // $('#btn-delete').attr('onclick', 'sweet('+b.id+')').removeClass('btn-progress');
                        $('.pemasok').text(b.pemasok.nama)
                        $('.nama').text(b.nama_barang)
                        $('.kategori').text(b.kategori.nama)
                        $('.harga').text(b.harga_barang)
                        $('.satuan').text(b.satuan)
                    if (b.foto == null) {
                        $("#foto").text('- Tidak Ada Foto Barang -');
                    }else{
                        $("#foto").html(`<img class="foto" src="{{asset('${b.foto}')}}">`);
                    }
                });
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
            }
        });
    }
</script>
{{--  --}}
@endpush
