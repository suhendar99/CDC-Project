@php
  $icon = "dashboard";
  $pageTitle = 'Dashboard Pemasok';
//   $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
  $dashboard = true;
  $barang = App\Models\Barang::all();
  $gudang = App\Models\GudangBulky::all();
  $bulky = App\Models\PengurusGudangBulky::all();
  $kat = App\Models\Kategori::all();
  $ketegori = [];
  $jumlahBarang = [];
  foreach ($kat as $key => $value) {
      $kategori[] =$value->nama;
  }
  $bulan = array(
        ['no'=>'1','val' => 'Januari'],
        ['no'=>'2','val' => 'Februari'],
        ['no'=>'3','val' => 'Maret'],
        ['no'=>'4','val' => 'April'],
        ['no'=>'5','val' => 'Mei'],
        ['no'=>'6','val' => 'Juni'],
        ['no'=>'7','val' => 'Juli'],
        ['no'=>'8','val' => 'Agustus'],
        ['no'=>'9','val' => 'September'],
        ['no'=>'10','val' => 'Oktober'],
        ['no'=>'11','val' => 'November'],
        ['no'=>'12','val' => 'Desember'],
    );
    $bul = [];
    foreach ($bulan as $key => $value) {
        $bul[] = $value;
    }
        //
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
            <a href="#" class="text-14">Pemasok</a>
          </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col">
        <div class="card my-3 shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-primary">work</i>
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
    <div class="col">
        <div class="card my-3 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-warning">house_siding</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">{{$gudang->count()}} Unit</span><br>
                        <span class="text-my-subtitle">Gudang</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card my-3 shadow">
            <div class="line-strip bg-my-success"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="material-icons md-48 text-my-success">user</i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-success">{{$bulky->count()}} Orang</span><br>
                        <span class="text-my-subtitle">Pemasok</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
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
    <div class="col-md-12 col-sm-12 mt-4">
        <div class="card shadow" style="height: auto">
            <div class="line-strip bg-my-warning"></div>
            <div class="row p-3">
              <div class="col-12 valign-center">
                <i class="material-icons md-24 text-my-warning mr-1">auto_graph</i><span style="font-size: 14px">Grafik Jumlah Komoditi</span>
              </div>
              <div class="col-12">
                <div id="chartKomoditi"></div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 mt-4">
        <div class="card shadow" style="height: 260px">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-6 border-right">
                  <center>
                    <div id="calendar"></div>
                  </center>
                </div>
                <div class="col-6" style="font-size: .8rem;">
                  <span style="font-size: 1rem">Hari Ini</span><br><hr class="mb-1">
                  <div class="float-left">
                    Item Terjual
                  </div>
                  <div class="float-right">
                    20 Item
                  </div>
                  <br>
                  <hr class="my-1">
                  <div class="float-left">
                    Barang Dikirim
                  </div>
                  <div class="float-right">
                    10 Item
                  </div>
                  <br>
                  <hr class="my-1">
                  <div class="float-left">
                    Barang Diterima
                  </div>
                  <div class="float-right">
                    10 Item
                  </div>
                  <br>
                  <hr class="my-1">
                  <div class="float-left">
                    Pesanan Lunas
                  </div>
                  <div class="float-right">
                    18 Item
                  </div>
                  <br>
                  <hr class="my-1">
                  <div class="float-left">
                    Pesanan Belum Lunas
                  </div>
                  <div class="float-right">
                    2 Item
                  </div>
                  <br>
                  <hr class="my-1">
                  <div class="float-left">
                    Total Pendapatan
                  </div>
                  <div class="float-right">
                    Rp. 200.000
                  </div>
                  <br>
                  <hr class="my-1">
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col-md-12 valign-center">
      <i class="material-icons md-24 text-my-warning mr-1">work</i><span style="font-size: 14px">Daftar Barang Saya</span>
    </div>
    <div class="col-12">
        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
                @foreach($barang as $d)
                <div class="item px-1">
                    <div class="card shadow">
                        <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_176acb1444e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_176acb1444e%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.1171875%22%20y%3D%2296.3%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                        <div class="card-body text-left">
                            <span class="carousel-card-title">{{$d->nama_barang}}</span><br>
                            <span class="carousel-card-title">{{$d->jumlah}} {{$d->satuan}}</span><br>
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
<script type="text/javascript">
var komoditi = JSON.parse('{!! json_encode($kategori) !!}')
console.log(komoditi);
var optionsKomoditi = {
          series: [{
          data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: komoditi,
        }
        };

    var charts = new ApexCharts(document.querySelector("#chartKomoditi"), optionsKomoditi);
charts.render();

var bulan = JSON.parse('{!! json_encode($bul) !!}')
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
        show: false,
      }
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
