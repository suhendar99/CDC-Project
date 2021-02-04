@php
        $icon = 'dashboard';
        $pageTitle = 'Dashboard Admin';
        $dashboard = true;
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
            <a href="#" class="text-14">Admin</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="row my-2">
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-primary">shopping_bag</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">20 Jenis</span><br>
                        <span class="text-my-subtitle">Komoditi</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-primary">house_siding</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">20 Unit</span><br>
                        <span class="text-my-subtitle">Gudang Bulky</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-primary">house_siding</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">50 Unit</span><br>
                        <span class="text-my-subtitle">Gudang Retail</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-warning">store</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">200 Akun</span><br>
                        <span class="text-my-subtitle">Warung</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-warning">people</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">1000 Akun</span><br>
                        <span class="text-my-subtitle">Pembeli</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-warning">store</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">50 Unit</span><br>
                        <span class="text-my-subtitle">Koperasi</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-12 my-2">
    <div style="width: 100%; height: 350px ;" id="mapid"></div>
  </div>
  <div class="col my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Persentase Pengguna</span>
        </div>
        {{-- <hr> --}}
        <div id="chartPengguna"></div>
      </div>
    </div>
  </div>
  <div class="col my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Persentase Anggota Koperasi</span>
        </div>
        {{-- <hr> --}}
        <div id="chartAnggota"></div>
      </div>
    </div>
  </div>
  {{-- <div class="col my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Persentase Gudang Bulky dengan Retail</span>
        </div>
        <div id="chartGudang"></div>
      </div>
    </div>
  </div> --}}
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
  var optionsPengguna = {
        series: [44, 55, 41, 30, 29],
        labels: ['Pemasok','Gudang Bulky','Gudang Retail','Warung','Pembeli'],
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

    var chartPengguna = new ApexCharts(document.querySelector("#chartPengguna"), optionsPengguna);
    chartPengguna.render();

  var optionsAnggota = {
        series: [44, 55],
        labels: ['Anggota Koperasi','Umum'],
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

    var chartAnggota = new ApexCharts(document.querySelector("#chartAnggota"), optionsAnggota);
    chartAnggota.render();

  // var optionsGudang = {
  //       series: [44, 29],
  //       labels: ['Gudang Bulky','Gudang Retail'],
  //       chart: {
  //           type: 'donut',
  //           height: 260
  //       },
  //       plotOptions: {
  //           pie: {
  //             donut: {
  //               size: '50%'
  //             }
  //           }
  //       },
  //       legend: {
  //         show: true,
  //         position: 'bottom',
  //       },
  //       responsive: [{
  //           breakpoint: 480,
  //           options: {
  //               chart: {
  //                 width: 300
  //               },
  //               legend: {
  //                 position: 'bottom'
  //               }
  //           }
  //       }]
  //   };

  //   var chartGudang = new ApexCharts(document.querySelector("#chartGudang"), optionsGudang);
  //   chartGudang.render();
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
