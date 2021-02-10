@php
        $icon = 'dashboard';
        $pageTitle = 'Dashboard Admin';
        $dashboard = true;
        $komoditi = App\Models\Kategori::all();
        $gudangBulky = App\Models\GudangBulky::where('status',1)->get();
        $gudangRetail = App\Models\Gudang::where('status',1)->get();
        $warung = App\Models\Pelanggan::all();
        $pembeli = App\Models\Pembeli::all();
        $koperasi = App\Models\Koperasi::all();
        $pmsk = App\Models\Pemasok::all();
        $anggotaKoperasi = App\User::where('keanggotaan',1)->get();
        $bukanAnggotaKoperasi = App\User::where('keanggotaan',0)->get();
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
                        <span class="text-my-primary">{{$komoditi->count()}} Jenis</span><br>
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
                        <span class="text-my-primary">{{$gudangBulky->count()}} Unit</span><br>
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
                        <span class="text-my-primary">{{$gudangRetail->count()}} Unit</span><br>
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
                        <span class="text-my-warning">{{$warung->count()}} Akun</span><br>
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
                        <span class="text-my-warning">{{$pembeli->count()}} Akun</span><br>
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
                        <span class="text-my-warning">{{$koperasi->count()}} Unit</span><br>
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
  <div class="col-md-6 my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Bagaian Pengguna CDC (Consolidated Distribution Center)</span>
        </div>
        {{-- <hr> --}}
        <div id="chartPengguna"></div>
      </div>
    </div>
  </div>
  <div class="col-md-6 my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Persentase Anggota CDC (Consolidated Distribution Center)</span>
        </div>
        {{-- <hr> --}}
        <div id="chartAnggota"></div>
      </div>
    </div>
  </div>
  <div class="col-md-12 my-2">
    <div class="card shadow" style="height: 350px;">
      <div class="card-body">
        <div class="valign-center">
            <i class="material-icons md-36 pointer text-my-warning">people</i>
            <span class="ml-2">Bagaian Pengguna CDC (Consolidated Distribution Center) per-Provinsi</span>
        </div>
        <div id="chartAnggotaPerProvinsi"></div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
  var gudangBulky = JSON.parse('{!! json_encode($gudangBulky->count()) !!}')
  var gudangRetail = JSON.parse('{!! json_encode($gudangRetail->count()) !!}')
  var warung = JSON.parse('{!! json_encode($warung->count()) !!}')
  var pembeli = JSON.parse('{!! json_encode($pembeli->count()) !!}')
  var pemasok = JSON.parse('{!! json_encode($pmsk->count()) !!}')
  var optionsPengguna = {
        series: [pemasok, gudangBulky, gudangRetail, warung, pembeli],
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

    var anggota = JSON.parse('{!! json_encode($anggotaKoperasi->count()) !!}')
    var bukan = JSON.parse('{!! json_encode($bukanAnggotaKoperasi->count()) !!}')
  var optionsAnggota = {
        series: [anggota, bukan],
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

    var provName = JSON.parse('{!! json_encode($provNama) !!}')
    var pengguna = JSON.parse('{!! json_encode($pengguna) !!}')
    console.log(pengguna);
    var chartAnggota = new ApexCharts(document.querySelector("#chartAnggota"), optionsAnggota);
    chartAnggota.render();

    var options = {
    chart: {
      colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63'],
      type: 'bar',
      height: '200px',
      toolbar: {
          show: false,
      },
      animations: {
          enabled: true,
          easing: 'easein',
          speed: 800,
          animateGradually: {
              enabled: true,
              delay: 150
          },
          dynamicAnimation: {
              enabled: true,
              speed: 350
          }
      }
    },
    legend: {
        show:false,
    },
    plotOptions: {
      bar: {
          distributed: true,
      }
    },
    markers: {
      size: 0,
    },
    series: [{
      name: 'Anggota',
      data: pengguna
    }],
    xaxis: {
      categories: provName,
      labels: {
        show: true,
      }
    },
    yaxis: {
      show: true,
      title: {
          text: 'Jumlah Anggota',
          rotate: -90,
          offsetX: 0,
          offsetY: 0,
          style: {
              color: '#373d3f',
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 400,
          },
      }
    },
    dataLabels: {
        enabled: false
    },
    tooltip: {
        enabled: true
    }
  }

  var chart = new ApexCharts(document.querySelector("#chartAnggotaPerProvinsi"), options);

  chart.render();

</script>
{{--  --}}
{{-- Map Section --}}
<script>
    var groupRetail = []
    var groupBulky = []
    var gudangBulky = JSON.parse('{!! json_encode($gudangBulky) !!}')
    var gudangRetail = JSON.parse('{!! json_encode($gudangRetail) !!}')

    var retailMarker = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
    var bulkyMarker = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
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
    gudangRetail.forEach(async function (value) {
        var hehe = groupRetail.push(L.marker([value.lat, value.long], {icon: retailMarker}).bindPopup(`
        <p><center>Gudang Retail</center></p>
        <b>Gudang : ${value.nama}</b><br />
        Milik : ${value.pemilik}<br />
        `))
        // console.log(element.id);
    })
    gudangBulky.forEach(async function (element) {
        var ohoh = groupBulky.push(L.marker([element.lat, element.long], {icon: bulkyMarker}).bindPopup(`
        <p><center>Gudang Bulky</center></p>
        <b>Gudang : ${element.nama}</b><br />
        Milik : ${element.pemilik}<br />
        `))
    })
    let gudangGudangBulky = L.layerGroup(groupBulky)
    let gudangGudang = L.layerGroup(groupRetail)

    var map = L.map('mapid', {
        center: [-6.967647303787534, 107.65589059670471],
        zoom: 10,
        layers: [ghybrid, gudangGudang, gudangGudangBulky]
    });
    // var Me = L.marker([latMe, longMe],{title:"lokasi_saya"}).addTo(map).bindPopup("Lokasi Gudang Yang Dimiliki");
    // markers.push(Me);
    L.control.layers(baseLayers).addTo(map);

    var legend = L.control({ position: "bottomleft" });

    legend.onAdd = function(map) {
    var div = L.DomUtil.create("div", "legend");
    div.innerHTML += "<h4>Tegnforklaring</h4>";
    div.innerHTML += '<i style="background: #477AC2"></i><span>Water</span><br>';
    div.innerHTML += '<i style="background: #448D40"></i><span>Forest</span><br>';
    div.innerHTML += '<i style="background: #E6E696"></i><span>Land</span><br>';
    div.innerHTML += '<i style="background: #E8E6E0"></i><span>Residential</span><br>';
    div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
    div.innerHTML += '<i class="icon" style="background-image: url(https://d30y9cdsu7xlg0.cloudfront.net/png/194515-200.png);background-repeat: no-repeat;"></i><span>Grænse</span><br>';



    return div;
    };

    legend.addTo(map);
</script>
{{--  --}}
@endpush
