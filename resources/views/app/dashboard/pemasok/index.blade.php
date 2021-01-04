@php
        $pageTitle = 'Dashboard Petani';
        $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
        $dashboard = true;
        $pemasok = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row my-2">
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body pb-2">
                <div class="row"> 
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-primary">work</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-primary">20 Jenis</div>
                      </div>
                      <div class="col-12"> 
                        <div class="float-right text-my-subtitle">Barang</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body pb-2">
                <div class="row"> 
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-warning">local_shipping</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-warning">200 Kali</div>
                      </div>
                      <div class="col-12"> 
                        <div class="float-right text-my-subtitle">Pengiriman</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-danger"></div>
            <div class="card-body pb-2">
                <div class="row"> 
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-danger">receipt_long</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-danger">200 Kali</div>
                      </div>
                      <div class="col-12"> 
                        <div class="float-right text-my-subtitle">Transaksi</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-success"></div>
            <div class="card-body pb-2">
                <div class="row"> 
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-success">move_to_inbox</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-success">10.000.000</div>
                      </div>
                      <div class="col-12"> 
                        <div class="float-right text-my-subtitle">Pemasukan (Rp)</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-12 d-flex">
      <i class="material-icons md-24 text-my-warning mr-2">work</i><span style="font-size: 18px">Daftar Barang Saya</span>
    </div>
    <div class="col-12">
        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
                @foreach($data as $d)
                <div class="item">
                    <div class="card shadow">
                        <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_176acb1444e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_176acb1444e%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.1171875%22%20y%3D%2296.3%22%3EImage%20cap%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                        <div class="card-body text-left">
                            <span class="carousel-card-title">Beras Super {{$d}}</span><br>
                            <span class="carousel-card-subtitle">Tersedia {{$d}} Ton</span><br>
                            <div class="row border-top pt-1">
                                <div class="col-12 d-flex justify-content-center">
                                    <a class="btn bg-transparent" href="#" title="Edit" tooltip="Edit">
                                        <i class="material-icons text-my-warning md-18 ">edit</i>{{-- <span class="text-10 text-my-warning">Perbarui</span> --}}
                                    </a>
                                    <a class="btn bg-transparent" href="#" title="Hapus" tooltip="Hapus">
                                        <i class="material-icons text-my-danger md-18 ">delete</i>{{-- <span class="text-10 text-my-danger ">Hapus</span> --}}
                                    </a>
                                </div>
                            </div>
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
<div class="row my-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 d-flex">
                  <i class="material-icons md-24 text-my-warning mr-2">auto_graph</i><span style="font-size: 18px">Frekuensi Penjualan Barang</span>
                </div>
                <div class="col-12">
                  <div id="frekuensichart"></div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
var options = {
  chart: {
    type: 'area',
    height: '200px',
    toolbar: {
        show: false,
    },
    animations: {
        enabled: true,
        easing: 'easeinout',
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
    name: 'sales',
    data: [30,40,35,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
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
</script>
@endpush
