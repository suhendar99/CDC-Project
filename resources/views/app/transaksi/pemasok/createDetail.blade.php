@php
    $icon = 'attach_money';
    $pageTitle = 'Tambah Transaksi';
@endphp

@extends('layouts.dashboard.header')

@section('content')

@error('gudang_id')
    <div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    Pastikan Anda Sudah memilih gudang tujuan
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@enderror

<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Tambah Transaksi</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="text-18">Detail Tambah Transaksi</span>
                </div>
                <div class="card-body">
                    <form action="{{route('transaksiPemasok.surat')}}" method="get">
                                          
                    @csrf                                          
                    <input type="hidden" name="barang_id" value="{{$barang->id}}">
                    <input type="hidden" name="gudang_id" id="gudang_id">
                    <input type="hidden" name="satuan" value="{{$barang->satuan}}">
                    <input type="hidden" name="max" value="{{$barang->jumlah}}">
                    <div class="row mh-50vh">
                        <div class="col-md-5 col-12 h-100">
                            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @forelse($barang->foto as $keyFoto => $val)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$keyFoto}}"></li>
                                    @empty
                                    @endforelse
                                </ol>
                                <div class="carousel-inner mh-50vh" style="border-radius: 0;">
                                    @forelse($barang->foto as $keyFoto => $val)
                                    <div class="carousel-item {{ $keyFoto == 0 ? 'active' : ''}} ">
                                        <img class="d-block barang-img cover " height="100%" src="{{asset($val->foto)}}" alt="First slide">
                                    </div>
                                    @empty
                                    <div class="carousel-item active">
                                        <div class="d-flex justify-content-center valign-center" style="height: 150px; background-color: #c6c6c6; color: #fff">
                                            Gambar Belum Diisi!
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                @if(count($barang->foto) >= 1)
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Next</span>
                                </a>
                                @endif
                            </div>
                            <div class="card mt-2">
                              <div class="card-header">
                                <span class="text-18">Detail Barang</span>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-12">
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                            <th scope="row">Nama Barang</th>
                                            <td>{{$barang->nama_barang}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kategori</th>
                                            <td>{{$barang->kategori->nama}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Harga</th>
                                            <td>{{$barang->harga_barang}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Tersedia</th>
                                            <td>{{$barang->jumlah}} {{$barang->satuan}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="col-md-12">
                                      <label>Jumlah Kirim <small class="text-primary">*Harus diisi</small></label>
                                      <div class="input-group mb-3">
                                        <input id="jumlah" type="number" type="number" name="jumlah" min="1" max="{{$barang->jumlah}}" class="form-control @error('jumlah') is-invalid @enderror" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2">{{$barang->satuan}}</span>
                                        </div>
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12 h-100">
                            <div class="row">
                              <div class="col-12">
                                  <div id="mapid" style="height: 200px; width: 100%"></div>
                                  <button type="button" class="btn btn-sm btn-primary btn-block mt-1" onclick="myLocation()">Lokasi Saya</button>
                              </div>
                              <div class="col-12 my-2">
                                  <table id="data_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%; height: 240px; overflow-y: auto;">
                                      <thead>
                                          <tr>
                                              <th>Nama Gudang</th>
                                              <th>Kabupaten</th>
                                              {{-- <th>Alamat</th> --}}
                                              <th>Pemilik</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                  </table>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div id="detailGudang" class="row mb-2 d-none">
                      <div class="col-md-12">
                        <div class="card mt-2">
                          <div class="card-header">
                            <span class="text-18">Detail Gudang</span>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4 col-12">
                                <div id="foto"></div>
                              </div>
                              <div class="col-md-4 col-12">
                                <table class="table">
                                  <tbody>
                                    <tr>
                                        <th scope="row">Nama Gudang</th>
                                        <td id="nama"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pemilik</th>
                                        <td id="pemilik"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kapasitas</th>
                                        <td id="kapasitas"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Alamat Lengkap</th>
                                        <td id="alamat"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <div class="col-md-4 col-12">
                                <table class="table">
                                  <tbody>
                                    <tr>
                                        <th scope="row">Kontak</th>
                                        <td id="kontak"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Hari Buka</th>
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
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                               <button id="next" type="button" class="btn btn-success btn-sm" disabled>Next</button> 
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    let pemasok = JSON.parse('{!! json_encode(Auth::user()->pemasok)!!}')
    let barang = JSON.parse('{!! json_encode($barang)!!}')
    let gudang = JSON.parse('{!! json_encode($gudang)!!}')
    let table = $('#data_table').DataTable({
        processing : true,
        lengthChange: false,
        serverSide : true,
        responsive: true,
        ordering : false,
        pageLength : 3,
        ajax : "{{ route('select.gudang') }}",
        columns : [
            {data : 'nama', name: 'nama'},
            {data : 'desa.kecamatan.kabupaten.nama', name: 'desa.kecamatan.kabupaten.nama'},
            // {data : 'alamat', name: 'alamat'},
            {data : 'pemilik', name: 'pemilik'},
            {data : 'action', name: 'action'},
        ]
    });


    var osm     = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'OSM',
                        maxZoom:20, }),
    gstreet     = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        attribution: 'Google',
                        maxZoom: 20, }),
    gterrain    = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, }),
    gsatelite   = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, }),
    ghybrid     = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, });
    var baseLayers = {
        "OSM": osm,
        "Google Street"     : gstreet,
        "Google Terrain"    : gterrain,
        "Google Satelite"   : gsatelite,
        "Google Hybrid"     : ghybrid
    };

    var map = L.map('mapid', {
            center: [-6.241586, 106.992416],
            zoom: 5,
            layers: [ghybrid]
    });

    var gudangIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

    $.each(gudang,function(index, value){
      var markerGudang = L.marker([value.lat, value.long], {icon: gudangIcon}).addTo(map).bindPopup(`${value.nama}<br>${value.pemilik}<br><center><button type="button" class="btn btn-sm btn-danger btn-block mt-1" onclick="select(${value.id})">Pilih</button></center>`);
    });
    var marker = L.marker([-6.241586, 106.992416],{
        draggable: true
    }).addTo(map);

    function myLocation(){
        var getPosition = {
          enableHighAccuracy: false,
          timeout: 9000,
          maximumAge: 0
        };
        function success(gotPosition) {
          var uLat = gotPosition.coords.latitude;
          var uLon = gotPosition.coords.longitude;
          // console.log(uLat,uLon);
          // document.getElementById('latitude').value = uLat;
          // document.getElementById('longitude').value = uLon;
          map.setView(new L.LatLng(uLat, uLon), 10);
          map.removeLayer(marker);
          marker = L.marker([uLat, uLon],{
            draggable: true
          }).addTo(map);
          // marker.on('dragend', function (e) {
          //   document.getElementById('latitude').value = marker.getLatLng().lat;
          //   document.getElementById('longitude').value = marker.getLatLng().lng;
          // });
          // console.log(`${uLat}`, `${uLon}`);
        };
        function error(err) {
          console.warn(`ERROR(${err.code}): ${err.message}`);
        };
        navigator.geolocation.getCurrentPosition(success, error, getPosition);
    }

    function select(id){
        $('#next').removeAttr('disabled')
        $('#next').attr('type','submit')
        $('#detailGudang').removeClass('d-none')
        $('#detailGudang').addClass('loading')
        $.ajax({
            method: "GET",
            url: '/api/v1/detailGudang/'+id,
        }).done(function(response){
            $('#detailGudang').removeClass('loading')
            let data = response.data
            // console.log(data)
            if(data.foto != null){
              $('#foto').html(`
                  <img src="/`+data.foto+`" class="img-gudang">
              `)
            } else {
              $('#foto').html(`
                  <center class="mt-100 text-18">Foto Belum Diisi</center>
              `)
            }

            $('#nama').text(data.nama)
            $('#gudang_id').val(data.id)
            $('#pemilik').text(data.pemilik)
            $('#kontak').text(data.kontak)
            $('#kapasitas').html(parseInt(data.kapasitas).toLocaleString()+' m<sup>2</sup>')
            $('#hari').text(data.hari)
            $('#buka').text(data.jam_buka)
            $('#tutup').text(data.jam_tutup)
            $('#alamat').html(`${data.alamat}, ${data.desa.nama}, ${data.desa.kecamatan.nama}, ${data.desa.kecamatan.kabupaten.nama}, ${data.desa.kecamatan.kabupaten.provinsi.nama}`)
        });
    }

    $('#jumlah').on('keyup',(value) => {
        var jumlah = $('#jumlah').val()
        if(jumlah >= barang.jumlah){
          $('#jumlah').val(barang.jumlah)
        }
    })
    // L.control.layers(baseLayers).addTo(map);

</script>
@endpush
