@php
    if(!isset(Auth::user()->pelanggan_id) && !isset(Auth::user()->karyawan_id) && !isset(Auth::user()->bank_id) && !isset(Auth::user()->pemasok_id) && !isset(Auth::user()->pengurus_gudang_id) && !isset(Auth::user()->pengurus_gudang_bulky_id)) {
        $admin = true;
    } elseif (isset(Auth::user()->karyawan_id)) {
        $karyawan = true;
    } elseif (isset(Auth::user()->bank_id)) {
        $bank = true;
    } elseif (isset(Auth::user()->pemasok_id)) {
        $pemasok = true;
    } elseif (isset(Auth::user()->pelanggan_id)) {
        $pelanggan = true;
    } elseif (isset(Auth::user()->pengurus_gudang_id)) {
        $pengurusGudang = true;
    } elseif (isset(Auth::user()->pengurus_gudang_bulky_id)) {
        $pengurusGudangBulky = true;
    }

    $jeruk = 'Jeruk';

    $set = App\Models\PengaturanAplikasi::find(1);
    $tahun = Carbon\Carbon::now()->format('Y');
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset($set->logo_tab)}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $set->nama_tab }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/mdi.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}">
    <link rel="stylesheet" href="{{ asset('css/switch.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('css/rightbar.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/carousel.css')}}">
    @if(isset($shop))
    <link rel="stylesheet" href="{{ asset('css/shop.css')}}">
    @endif

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    @if(!isset($rightbar))
    <link rel="stylesheet" href="{{ asset('css/norightbar.css')}}">
    @endif

    @if(isset($nosidebar))
    <link rel="stylesheet" href="{{ asset('css/nosidebar.css')}}">
    @endif

    @if(isset($cart))
        <link rel="stylesheet" href="{{ asset('css/cart.css')}}">
    @endif
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>



    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
    integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
    crossorigin="">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <style type="text/css" media="screen">
        .dropdown-toggle::after{
            content: "";
            border: 0em solid;
        },
        .list-group-flush > .list-group-item::last-child{
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        #detail{
            width: 100%;
        }
    </style>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.5/css/unicons.css">

    @stack('style')
</head>
<body>
    @if(isset($shop))
    @include('layouts.shop.navbar')
    <div class="container-fluid">
        <div class="wrapper">
            @if(!isset($detail))

            @include('layouts.shop.category')
            <div id="content">

            @else
            <div id="detail">
            @endif
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                        <div class="row">
                            <div class="col-12 justify-content-center">
                                <div class="footer-copyright text-center pt-4 text-dark">
                                    <div class="copyright">
                                        <span>© Copyright </span>
                                        <a href="{{$set->copyright_link}}" class="text-dark"> {{$set->copyright_text}} {{$tahun}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($cart))
                @include('layouts.shop.cart')
            @endif
        </div>
    </div>
    @else
    <div id="app">
        <div class="wrapper">
            @if(!isset($nosidebar))
            @include('layouts.dashboard.sidebar')
            @endif

            <div id="content">
                <!-- Page Content  -->
                <div class="container-fluid">
                    @include('layouts.dashboard.navbar')
                    <div class=" row">
                        <div class=" col-12">
                            @yield('content')
                        </div>
                    </div>
                    <div class=" row">
                        <div class=" col-12">
                            <!-- Copyright -->
                            <div class="footer-copyright text-center pt-4 text-dark fixed">
                                <div class="copyright">
                                    <span>© Copyright </span>
                                    <a href="{{$set->copyright_link}}" class="text-dark"> {{$set->copyright_text}} {{$tahun}}</a>
                                </div>
                            </div>
                            <!-- Copyright -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</body>


<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

@if(isset($cart))
    <script src="{{ asset('js/cart.js') }}"></script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js"
integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js" integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
<script src="https://leaflet.github.io/Leaflet.Editable/src/Leaflet.Editable.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->

<script type="text/javascript">
    // $('.material-icons').css('display','none')
    $(document).ready(function () {
        // $('.material-icons').css('display','block')
        $('select').select2()
        $('.card').delay(1000).addClass('stop');
        $('.alert').delay(1000).fadeOut(1000, function () {
           $('.alert').remove();
        });
        // $('.alert').delay(5000).remove();
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#sidebarCollapsed').on('click', function () {
            $('#sidebar').toggleClass('active');
            if($('#sidebar').hasClass('active')){
                // alert('Active');
                $('#content').css({"width": "100%"})
            }
        });

        $('#rightbarCollapse').on('click', function () {
            $('#rightbar').toggleClass('active');
        });

        $('#rightbarCollapsed').on('click', function () {
            $('#rightbar').toggleClass('active');
        });

        $('#categoryCollapse').on('click', function () {
            $('#category').toggleClass('active');
        });

        var satuan = $('#selectSatuan').val()
        $('#satuanAppend').text(satuan)

        $('#selectSatuan').change(function(){
            satuan = $('#selectSatuan').val()
            $('#satuanAppend').text(satuan)
        })
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.nl.min.js"></script>
@stack('script')
<script src="{{ asset('js/carousel.js') }}"></script>
</html>
