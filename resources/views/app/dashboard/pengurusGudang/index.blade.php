@php
  $icon = 'dashboard';
  $pageTitle = 'Dashboard Pemilik Gudang Retail';
  $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
  $dashboard = true;
  $storage = \App\Models\Storage::all();
  $storageIn = \App\Models\StorageIn::all();
  $storageOut = \App\Models\StorageOut::all();
  $pmsk = \App\Models\Pemasok::all();
  $gudang = App\Models\Gudang::with('rak')->where('user_id',Auth::user()->id)->where('status',1)->get();
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
            <a href="#" class="text-14">Gudang Retail</a>
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
                    <i class="material-icons md-48 text-my-primary">work</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-primary">{{$storage->count()}} Jenis</span><br>
                        <span class="text-my-subtitle">Barang Retail</span>
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
                        <span class="text-my-warning">{{$storageIn->count()}} Kali</span><br>
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
                        <span class="text-my-danger">{{$storageOut->count()}} Kali</span><br>
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
                        <span class="text-my-success">{{$pmsk->count()}} Orang</span><br>
                        <span class="text-my-subtitle">Pemasok Barang</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-md-4 col-sm-12">
        <div class="card shadow" style="height: 400px">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-12" style="font-size: .7rem;">
                  <span style="font-size: 1rem">Log Pemesanan</span><br><hr class="mb-2">
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
                            {{-- @if ($logTransaksi->count() > 1) --}}
                            <center>
                                {{$logTransaksi->links()}}
                            </center>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  <div class="d-none" id="show">
    <div class="card" style="height: 400px;">
      <div class="line-strip bg-my-warning"></div>
      <div class="card-body">
        <div class="valign-center">
          <i class="material-icons md-36 text-my-warning">house_siding</i>
          <span class="text-18" id="titleGudang"></span>
        </div>
        <hr class="p-0">
        <center>
          <img src="{{asset('images/logo-cdc.png')}}" style="height: 120px;" class="scale-down pb-4">
        </center>
        <div class="row">
          <div class="col-md-5">
            No Induk Gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="nig"></div>
          </div>
          <div class="col-md-5">
            Status Gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="status"></div>
          </div>
          <div class="col-md-5">
            Ruang Penyimpanan Gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="statusPenuh"></div>
          </div>
          <div class="col-md-5">
            Nama Gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="namaGudang"></div>
          </div>
          <div class="col-md-5">
            Kontak gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="telepon"></div>
          </div>
          <div class="col-md-5">
            Hari Kerja
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="hariKerja"></div>
          </div>
          <div class="col-md-5">
            Jam Kerja
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="jamKerja"></div>
          </div>
          <div class="col-md-5">
            Alamat Gudang
          </div>
          <div class="col-md-7">
            <div class="float-left">:</div>
            <div class="float-left ml-2" id="alamat"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8" id="mapMap">
    <div style="height: 400px; width: 100%;" id="mapid"></div>
  </div>
</div>
<div class="row my-4">
  <div class="col-md-12">
    <div class="card">
      <div class="line-strip bg-my-success"></div>
      <div class="card-body">
        <div class="valign-center">
          <i class="material-icons md-36 text-my-success">insert_chart</i>
          <span class="text-18">Statistik Gudang</span>
        </div>
        <div class=" row">
          <div class="col-4 border-right">
            <center>
              <div id="calendar"></div>
            </center>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="row">
              <div class="col-12 valign-center">
                <i class="material-icons md-24 text-my-success mr-1">bar_chart</i><span style="font-size: 14px">Grafik Pembelian Hari Ini</span>
              </div>
              <div class="col-12">
                <div id="pembelianChart"></div>
              </div>
            </div>
          </div>
          <div class=" col-md-4 col-sm-12">
            <div class="row">
              <div class="col-12 valign-center">
                <i class="material-icons md-24 text-my-success mr-1">bar_chart</i><span style="font-size: 14px">Grafik Penjualan Hari Ini</span>
              </div>
              <div class="col-12">
                <div id="frekuensichart"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
@push('script')

{{-- Map Section --}}
<script>
    var group = []
    var gudang = JSON.parse('{!! json_encode($gudang) !!}')
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
    gudang.forEach(async function (element) {
        let hitungan = 0;

        $.each(element.rak, function(index, val) {
           if (val.status == 1) {
              hitungan++
           }
        });
        let rak = 'btn-primary';

        if (element.rak.length == 0) {
          rak = 'btn-dark';
        } else if (hitungan == element.rak.length) {
          rak = 'btn-danger';
        }else{
          rak = 'btn-primary';
        }

        var hehe = group.push(L.marker([element.lat, element.long]).bindPopup(`
        <b>Gudang : ${element.nama}</b><br />
        Milik : ${element.pemilik}<br />
        <a href="#" class="btn ${rak} btn-sm btn-block text-white" onclick="detailGudang(${element.id})">Lihat Detail</a>
        `))
        // console.log(element.id);
    })
    let gudangGudang = L.layerGroup(group)

    var map = L.map('mapid', {
        center: [-6.967647303787534, 107.65589059670471],
        zoom: 10,
        layers: [ghybrid, gudangGudang]
    });
    // var Me = L.marker([latMe, longMe],{title:"lokasi_saya"}).addTo(map).bindPopup("Lokasi Gudang Yang Dimiliki");
    // markers.push(Me);
    L.control.layers(baseLayers).addTo(map);
</script>

{{-- Detail Gudang Section --}}
<script>
    function detailGudang(id) {
        $('#mapMap').removeClass('col-md-8');
        $('#mapMap').addClass('col-md-4');
        $('#show').removeClass('d-none');
        $('#show').addClass('col-md-4');

        $('#titleGudang').text(`Tunggu.......`);
        $('#nig').text(`Tunggu.......`);
        $('#status').text(`Tunggu.......`)
        $('#statusPenuh').text('Tunggu.......');
        $('#namaGudang').text(`Tunggu.......`);
        $('#telepon').text(`Tunggu.......`);
        $('#hariKerja').text(`Tunggu.......`);
        $('#jamKerja').text(`Tunggu.......`);
        $('#alamat').text(`Tunggu.......`);
        $.ajax({
            type: "get",
            url: "/api/v1/getGudang/"+id,
            dataType: "json",
            success: function (response) {
                var data = response.data;
                $.each(data, function (a, b) {
                    let hitungan = 0;
                    $('#titleGudang').text(`Detail Gudang `+b.nama);
                    $('#nig').text(b.nomor_gudang);
                    $('#status').text((b.status == 0) ? 'Tidak Aktif' : 'Aktif');
                    $.each(b.rak, function(index, val) {
                       if (val.status == 1) {
                          hitungan++
                       }
                    });
                    if (b.rak.length == 0) {
                      $('#statusPenuh').text('Belum ada rak');
                    } else if (hitungan == b.rak.length) {
                      $('#statusPenuh').html('<span class="text-danger">Gudang sudah penuh</span>')
                    }else{
                      $('#statusPenuh').text('Masih ada ruang')
                    }
                    $('#namaGudang').text(b.nama);
                    $('#telepon').text(b.kontak);
                    $('#hariKerja').text(b.hari);
                    $('#jamKerja').text(b.jam_buka+` - `+b.jam_tutup);
                    $('#alamat').text(b.alamat);
                });
            }
        });
    }
</script>

{{-- Calendar Section --}}
<script type="text/javascript">
    $('#calendar').datepicker({
      format: "yyyy-mm-dd",
      language: "de",
      calendarWeeks: false,
      todayHighlight: true
    }).on('changeDate', ()=>{
        // let value = $('#calendar').datepicker('getFormattedDate');
        // updateChart(value)
        console.log($('#calendar').datepicker('getFormattedDate'));
    });
</script>
{{--  --}}

{{-- Chart Section --}}
<script type="text/javascript">
  var options = {
    chart: {
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
    markers: {
      size: 0,
    },
    series: [{
      name: 'Penjualan Bulanan',
      data: [30,40,35,50]
    }],
    xaxis: {
      categories: ['Beras','Jagung','Bawang Merah','Apel']
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

  var chart = new ApexCharts(document.querySelector("#frekuensichart"), options);

  chart.render();

  var options = {
    chart: {
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
    markers: {
      size: 0,
    },
    series: [{
      name: 'Penjualan Bulanan',
      data: [30,40,35,50]
    }],
    xaxis: {
      categories: ['Beras','Jagung','Bawang Merah','Apel']
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

  var pembelian = new ApexCharts(document.querySelector("#pembelianChart"), options);

  pembelian.render();
</script>
{{--  --}}
@endpush
