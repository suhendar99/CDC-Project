@php
    $log = [1,1,1,1,1,1,1,1,1];
@endphp
<nav id="rightbar">
    <div class="rightbar-content shadow">
        <div class="rightbar-header">
            <div class=" row"> 
                <div class="col-12">    
                    <div class="float-left">
                        <div class="d-flex justify-content-center">
                            @if(isset($admin))
                            <i class="material-icons md-24 pointer">receipt</i>
                            <span class="text-white ml-2">Log Aktivitas</span>
                            @elseif(isset($karyawan))
                            <i class="material-icons md-24 pointer">pie_chart</i>
                            <span class="text-white ml-2">Grafik Barang Keluar Masuk</span>
                            @elseif(isset($pemasok))
                            <i class="material-icons md-24 pointer">pie_chart</i>
                            <span class="text-white ml-2">Grafik Penjualan Saya</span>
                            @endif
                        </div>
                    </div>
                    <div class=" float-right"> 
                        <i id="rightbarCollapsed" class="material-icons md-24 pointer">close</i>
                    </div>
                </div>
                @if(isset($admin))
                <div class=" col-12 p-2"> 
                    <div class=" card"> 
                        <div class=" card-body" style="height: 85vh; overflow-y:  scroll; "> 
                            @foreach($log as $d)
                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left h-30">
                                        <span class="log-title text-my-primary">
                                            <div class="strip-primary"></div>
                                            Pembayaran
                                        </span>
                                    </div>
                                    <div class="float-right">
                                        
                                    </div>
                                </div>
                                <div class="col-12 border-bottom mb-2">
                                    <span class="log-things">Pak Pembeli, Login</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @elseif(isset($karyawan))
                <div class=" col-12 p-2"> 
                    <div class=" card"> 
                        <div class=" card-body" style="height: 40vh"> 
                            <div id="piechart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">    
                    <div class="float-left">
                        <div class="d-flex justify-content-center">
                            <i class="material-icons md-24 pointer">receipt</i>
                            <span class="text-white ml-2">Log Barang Masuk/Keluar</span>
                        </div>
                    </div>
                </div>
                <div class=" col-12 p-2"> 
                    <div class=" card"> 
                        <div class=" card-body" style="height: 40vh; overflow-y:  scroll; "> 
                            @foreach($log as $d)
                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left h-30">
                                        <span class="log-title text-my-primary">
                                            <div class="strip-primary"></div>
                                            Barang Masuk
                                        </span>
                                    </div>
                                    <div class="float-right">
                                        <a href="#" class="btn bg-my-warning-outline log-detail">Detail</a>
                                    </div>
                                </div>
                                <div class="col-12 border-bottom mb-2">
                                    <span class="log-things">Beras Super 1, 200 Kg</span>
                                    <br>
                                    <span class="log-buyer">Pak Tani, Sumedang</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @elseif(isset($pemasok))
                <div class=" col-12 p-2"> 
                    <div class=" card"> 
                        <div class=" card-body" style="height: 40vh"> 
                            <div id="piechart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">    
                    <div class="float-left">
                        <div class="d-flex justify-content-center">
                            <i class="material-icons md-24 pointer">receipt</i>
                            <span class="text-white ml-2">Log Transaksi</span>
                        </div>
                    </div>
                </div>
                <div class=" col-12 p-2"> 
                    <div class=" card"> 
                        <div class=" card-body" style="height: 40vh; overflow-y:  scroll; "> 
                            @foreach($log as $d)
                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left h-30">
                                        <span class="log-title text-my-primary">
                                            <div class="strip-primary"></div>
                                            Pembayaran
                                        </span>
                                    </div>
                                    <div class="float-right">
                                        <a href="#" class="btn bg-my-warning-outline log-detail">Detail</a>
                                    </div>
                                </div>
                                <div class="col-12 border-bottom mb-2">
                                    <span class="log-things">Beras Super 1, 200 Kg</span>
                                    <br>
                                    <span class="log-price">Rp. 1.000.000</span>
                                    <br>
                                    <span class="log-buyer">Pak Pembeli, Sumedang</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>
@push('script')
<script type="text/javascript">
    @if(!isset($admin))
    var options = {
        series: [44, 55, 41, 17, 15],
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

    var chart = new ApexCharts(document.querySelector("#piechart"), options);
    chart.render();
    @endif
</script>
@endpush