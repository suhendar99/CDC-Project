@php
  $icon = 'dashboard';
  $pageTitle = 'Dashboard Pelanggan Warung';
  $dashboard = true;
  $logTransaksi = App\Models\LogTransaksi::orderBy('jam','desc')->paginate(3);
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
            <a href="#" class="text-14">Pelanggan Warung</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="row my-2">
    <div class="col-md-3 col-sm-6">
        <div class="card my-2 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="ri-shopping-bag-line text-my-primary display-4"></i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">{{$barang->count()}} Jenis</span><br>
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
                    <i class="ri-inbox-archive-line text-my-warning display-4"></i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">{{$barangMasuk->count()}} Kali</span><br>
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
                    <i class="ri-inbox-unarchive-line text-my-danger display-4"></i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-danger">{{$barangKeluar->count()}} Kali</span><br>
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
                    <i class="ri-shopping-cart-line text-my-success display-4"></i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-success">{{$jumlahPemesanan->count()}} Pemesanan</span><br>
                        <span class="text-my-subtitle"> Barang</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="card shadow" style="height: auto">
            <div class="line-strip bg-my-warning"></div>
            <div class="row p-3">
              <div class="col-12 valign-center">
                <i class="material-icons md-24 text-my-warning mr-1">auto_graph</i><span style="font-size: 14px">Grafik Penjualan Bulanan</span>
              </div>
              <div class="col-12">
                <div id="chartBulanan"></div>
              </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="card shadow" style="height: 400px">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-12" style="font-size: .7rem;">
                  <span style="font-size: 1rem">Log Transaksi </span><br><hr class="mb-2">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jam</th>
                        <th scope="col">Aktivitas Transaksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($logTransaksi as $key => $value)
                      <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{\Carbon\Carbon::parse($value->tanggal)->translatedFormat('d F Y')}}</td>
                        <td>{{\Carbon\Carbon::parse($value->jam)->translatedFormat('H:i:s')}}</td>
                        <td>{{$value->Aktifitas_transaksi}}</td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4"><center>Data Kosong !</center></td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                    <div class="col-12 d-flex">
                        <div class="ml-auto p-2">
                            <center>
                                {{$logTransaksi->links()}}
                            </center>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div style="height: 400px; width: 100%;" id="mapid"></div>
    </div> --}}
</div>
@endsection
@push('script')
<script type="text/javascript">
    // var group = []
    // var gudang = JSON.parse('{! json_encode($gudang) !!}')
    // var osm     = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //                     attribution: '&copy; <a href="">Badan Perencanaan Pembangunan Daerah Kabupaten Bekasi</a>',
    //                     maxZoom:20, }),
    // gstreet     = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    //                     subdomains:['mt0','mt1','mt2','mt3'],
    //                     attribution: 'Google',
    //                     maxZoom: 20, }),
    // gterrain    = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
    //                     subdomains:['mt0','mt1','mt2','mt3'],
    //                     maxZoom: 20, }),
    // gsatelite   = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    //                     subdomains:['mt0','mt1','mt2','mt3'],
    //                     maxZoom: 20, }),
    // ghybrid     = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    //                     subdomains:['mt0','mt1','mt2','mt3'],
    //                     maxZoom: 20, });
    // var baseLayers = {
    //     "OSM": osm,
    //     "Google Street"     : gstreet,
    //     "Google Terrain"    : gterrain,
    //     "Google Satelite"   : gsatelite,
    //     "Google Hybrid"     : ghybrid
    // };
    // gudang.forEach(async function (element) {
    //     var hehe = group.push(L.marker([element.lat, element.long]).bindPopup(`
    //             <b>Gudang : ${element.nama}</b><br />
    //             Milik : ${element.pemilik}<br />
    //     `))
    // })
    // let gudangGudang = L.layerGroup(group)

    // var map = L.map('mapid', {
    //     center: [-6.967647303787534, 107.65589059670471],
    //     zoom: 10,
    //     layers: [ghybrid, gudangGudang]
    // });
    // // var Me = L.marker([latMe, longMe],{title:"lokasi_saya"}).addTo(map).bindPopup("Lokasi Gudang Yang Dimiliki");
    // // markers.push(Me);
    // L.control.layers(baseLayers).addTo(map);
    var options = {
    chart: {
      type: 'bar',
      height: '200px',
      colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63'],
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

    plotOptions: {
      bar: {
          distributed: true,
      }
    },
    markers: {
      size: 0,
    },
    series: [{
      name: 'Penjualan Bulanan',
      data: [30,40,35,50]
    }],
    xaxis: {
      categories: ['Januari','Februari','Maret','April'],
      labels: {
        show: true,
      }
    },
    legend: {
        show:false,
    },
    yaxis: {
      show: true,
      title: {
          text: 'Jumlah Item',
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

  var pembelian = new ApexCharts(document.querySelector("#chartBulanan"), options);

  pembelian.render();
</script>
@endpush
