@php
        $pageTitle = 'Dashboard Gudang';
        $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
        $dashboard = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row my-2">
    <div class="col-md-3 col-sm-6">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row"> 
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-primary">work</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">20 Jenis</span><br>
                        <span class="text-my-subtitle">Barang</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row"> 
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-warning">archive</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">200 Kali</span><br>
                        <span class="text-my-subtitle">Barang Masuk</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-danger"></div>
            <div class="card-body dashboard">
                <div class="row"> 
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-danger">unarchive</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-danger">100 Kali</span><br>
                        <span class="text-my-subtitle">Barang Keluar</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-success"></div>
            <div class="card-body dashboard">
                <div class="row"> 
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-success">extension</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-success">10 Orang</span><br>
                        <span class="text-my-subtitle">Pemasok Barang</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
  <div class="col-md-12">
    <div style="height: 350px; width: 100%;" id="mapid"></div>
  </div>
</div>
<div class="row my-4">
    <div class="col-md-12 col-sm-12">
      <div class="valign-center">
        <i class="material-icons md-24 text-my-warning mr-1">work</i><span style="font-size: 18px">Daftar Barang Bulky</span>
      </div>
      <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
          <div class="MultiCarousel-inner">
              @foreach($data as $d)
              <div class="item px-1">
                  <div class="card shadow">
                      <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_176acb1444e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_176acb1444e%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.1171875%22%20y%3D%2296.3%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                      <div class="card-body text-left">
                          <span class="carousel-card-title">Beras Super {{$d}}</span><br>
                          <span class="carousel-card-subtitle">Tersedia {{$d}}00 Ton</span><br>
                          {{-- <div class="row border-top pt-1">
                              <div class="col-12 d-flex justify-content-center">
                                  <a class="btn bg-transparent" href="#" title="Edit" tooltip="Edit">
                                      <i class="material-icons text-my-warning md-18 ">edit</i>
                                  </a>
                                  <a class="btn bg-transparent" href="#" title="Hapus" tooltip="Hapus">
                                      <i class="material-icons text-my-danger md-18 ">delete</i>
                                  </a>
                              </div>
                          </div> --}}
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
          <button class="btn leftLst"><</button>
          <button class="btn rightLst">></button>
      </div>
    </div>
    <div class="col-md-12 col-sm-12">
      <div class="valign-center">
        <i class="material-icons md-24 text-my-warning mr-1">work</i><span style="font-size: 18px">Daftar Barang Retail</span>
      </div>
      <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
          <div class="MultiCarousel-inner">
              @foreach($data as $d)
              <div class="item">
                  <div class="card shadow">
                      <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_176acb1444e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_176acb1444e%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.1171875%22%20y%3D%2296.3%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                      <div class="card-body text-left">
                          <span class="carousel-card-title">Beras Premium {{$d}}</span><br>
                          <span class="carousel-card-subtitle">Tersedia {{$d}} Ton</span><br>
                          {{-- <div class="row border-top pt-1">
                              <div class="col-12 d-flex justify-content-center">
                                  <a class="btn bg-transparent" href="#" title="Edit" tooltip="Edit">
                                      <i class="material-icons text-my-warning md-18 ">edit</i>
                                  </a>
                                  <a class="btn bg-transparent" href="#" title="Hapus" tooltip="Hapus">
                                      <i class="material-icons text-my-danger md-18 ">delete</i>
                                  </a>
                              </div>
                          </div> --}}
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
          <button class="btn leftLst"><</button>
          <button class="btn rightLst">></button>
      </div>
    </div>
</div>
@endsection
@push('script')

{{-- Map Section --}}
<script>
    var osm     = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="">Badan Perencanaan Pembangunan Daerah Kabupaten Bekasi</a>',
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
            zoom: 10,
            layers: [ghybrid]
    });
    L.control.layers(baseLayers).addTo(map);
</script>
{{--  --}}
<script type="text/javascript">
</script>
@endpush
