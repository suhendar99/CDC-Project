@php
  $icon = 'dashboard';
  $pageTitle = 'Dashboard Pelanggan Warung';
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
    <div class="col-md-12 col-sm-12 mt-4">
        <div class="card shadow" style="height: auto">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-4 border-right">
                <i class="ri-folder-open-line text-my-primary h4"></i><span style="font-size: 14px"> Rekapitulasi Transaksi hari Ini</span><br><hr class="mb-2">
                  <center>
                    <div id="calendarLog"></div>
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
@endsection
@push('script')
{{-- Calendar Log Section --}}
<script type="text/javascript">
    $('#calendarLog').datepicker({
      format: "yyyy-mm-dd",
      language: "de",
      calendarWeeks: false,
      todayHighlight: true
    }).on('changeDate', ()=>{
        // let value = $('#calendarLog').datepicker('getFormattedDate');
        // updateChart(value)
        let value = $('#calendarLog').datepicker('getFormattedDate');
        $.ajax({
            url: "/api/v1/logTransaksi/warung/date/"+value,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: (response)=>{
                let value = $('#calendarLog').datepicker('getFormattedDate');
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
