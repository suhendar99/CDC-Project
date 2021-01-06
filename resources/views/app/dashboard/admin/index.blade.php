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
    <div class="col-md-6 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Admin</a>
          </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div>
</div>
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
                    <i class="material-icons md-48 text-my-warning">house_siding</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">20 Unit</span><br>
                        <span class="text-my-subtitle">Gudang</span>
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
                    <i class="material-icons md-48 text-my-danger">people</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-danger">200 Akun</span><br>
                        <span class="text-my-subtitle">Pembeli</span>
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
                        <span class="text-my-success">100 Orang</span><br>
                        <span class="text-my-subtitle">Pemasok</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-8 my-2">
    <div style="width: 100%; height: 350px ;" id="mapid"></div>
  </div>
  <div class="col-md-4 my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Persentase Pengguna</span>
        </div>
        {{-- <hr> --}}
        <div id="chart"></div>
      </div>
    </div>
  </div>
</div>
<div class="row" style="height: 1000px;">
  
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
  var options = {
        series: [44, 55, 41],
        labels: ['Pemasok','Gudang','Pembeli'],
        chart: {
            type: 'donut',
            height: 260
        },
        plotOptions: {
            pie: {
              donut: {
                size: '50%'
              }
            }
        },
        legend: {
          show: true,
          position: 'bottom',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                  width: 300
                },
                legend: {
                  position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
{{--  --}}
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
@endpush