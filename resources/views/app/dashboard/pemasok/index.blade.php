@php
  $icon = "dashboard";
  $pageTitle = 'Dashboard Pemasok';
//   $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
  $dashboard = true;
  $gudang = App\Models\GudangBulky::all();
  $bulky = App\Models\PengurusGudangBulky::all();
    $year = Carbon\Carbon::now()->format('Y');
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
    <div class="col">
        <div class="card my-3 shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body dashboard">
                <div class="row">
                  <div class="col-4 valign-center">
                    <i class="ri-exchange-dollar-line text-my-warning display-4"></i>
                  </div>
                  <div class="col-8 valign-center flex-last">
                    <div class="float-right text-right">
                        <span class="text-my-warning">{{$jumakumulasi->count()}} Penjualan</span><br>
                        <span class="text-my-subtitle">Terkirim</span>
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
                <i class="ri-bar-chart-fill text-my-warning mr-1 h5"></i><span style="font-size: 14px">Grafik Penjualan Barang Per-Bulan ({{$year}})</span>
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
                <i class="ri-bar-chart-horizontal-fill text-my-warning mr-1 h5"></i><span style="font-size: 14px">Grafik Jumlah Komoditi</span>
              </div>
              <div class="col-12">
                <div id="chartKomoditi"></div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 mt-4">
        <div class="card shadow" style="height: auto">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-4 border-right">
                <i class="ri-folder-open-line text-my-primary h4"></i><span style="font-size: 14px"> Rekapitulasi Transaksi hari Ini</span><br><hr class="mb-2">
                  <center>
                    <div id="calendar"></div>
                  </center>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12" style="font-size: .7rem;">
                            <i class="ri-currency-line text-my-primary h4"></i><span style="font-size: 14px" class="ml-2">Log Transaksi </span><br><hr class="mb-2">
                            <div id="table_log">
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
                                        <td>{{$value->aktifitas_transaksi}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4"><center>Data Kosong !</center></td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
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
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col-md-12 valign-center">
        <i class="ri-shopping-bag-line text-my-primary h4"></i><span style="font-size: 14px" class="ml-3"> Daftar Barang Yang dimiliki / Tersedia</span>
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
        let value = $('#calendar').datepicker('getFormattedDate');
        $.ajax({
            url: "/api/v1/logTransaksi/date/"+value,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                let value = $('#calendar').datepicker('getFormattedDate');
                var data = response.data;
                console.log(data);
                if (data.length > 0) {
                    $('#table_log').html(`
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam</th>
                            <th scope="col">Aktivitas Transaksi</th>
                        </tr>
                        </thead>
                        <tbody id="isiTable">

                        </tbody>
                    </table>
                `)
                } else if(data.length < 1) {
                    $('#table_log').html(`
                        <table class="table table-striped" id="table_log">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jam</th>
                                <th scope="col">Aktivitas Transaksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="4"><center>Data Kosong !</center></td>
                            </tr>
                            </tbody>
                        </table>
                    `)
                }
                $.each(data, function (a, b) {
                    $('#isiTable').append(`
                        <tr>
                            <th scope="row">${a+1}</th>
                            <td>${b.tanggal}</td>
                            <td>${b.jam}</td>
                            <td>${b.aktifitas_transaksi}</td>
                        </tr>
                    `)
                });
            },
            error: (xhr)=>{
                let res = xhr.responseJSON;
                console.log(res)
            }
        });
    });
</script>
<script type="text/javascript">
var komoditi = JSON.parse('{!! json_encode($kategori) !!}')
var jumlah = JSON.parse('{!! json_encode($jumlahBarang) !!}')
var optionsKomoditi = {
        series: [{
          name: 'Jumlah Barang',
          data: jumlah,
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
          title: {
                text: 'Jumlah Barang',
                rotate: -90,
                offsetX: 0,
                offsetY: 0,
                style: {
                    color: '#373d3f',
                    fontSize: '12px',
                    fontFamily: 'Poppins, sans-serif',
                    fontWeight: 400,
                },
            },
            labels: {
                formatter: function(val) {
                    let vals = val.toFixed(0);
                    if (Number.isInteger(val)) {
                        return vals;
                    } else {
                        return "";
                    }
                }
            }
        }
    };

    var charts = new ApexCharts(document.querySelector("#chartKomoditi"), optionsKomoditi);
charts.render();

var bulan = JSON.parse('{!! json_encode($bul) !!}')
var color = JSON.parse('{!! json_encode($warna) !!}')
var akumulasi = JSON.parse('{!! json_encode($akumulasi) !!}')
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

    legend: {
        show:false,
    },
    fill: {
        colors: color,
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
      name: 'Banyaknya Penjualan Per-Bulan',
      data: akumulasi
    }],
    xaxis: {
      categories: bulan,
      title: {
          text: 'Bulan tahun {{$year}}',
          rotate: -90,
          offsetX: 0,
          offsetY: 0,
          style: {
              color: '#373d3f',
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 400,
          },
      },
      labels: {
        show: true,
      }
    },
    yaxis: {
      show: true,
      title: {
          text: 'Jumlah Barang',
          rotate: -90,
          offsetX: 0,
          offsetY: 0,
          style: {
              color: '#373d3f',
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 400,
          },
      },
      labels: {
            formatter: function(val) {
                let vals = val.toFixed(0);
                if (Number.isInteger(val)) {
                    return vals;
                } else {
                    return "";
                }
            }
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
