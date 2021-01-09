@php
    if(!isset(Auth::user()->pelanggan_id) && !isset(Auth::user()->karyawan_id) && !isset(Auth::user()->bank_id) && !isset(Auth::user()->pemasok_id) && !isset(Auth::user()->pengurus_gudang_id)) {
        $admin = true;
    } elseif (isset(Auth::user()->karyawan_id)) {
        $karyawan = true;
    } elseif (isset(Auth::user()->bank_id)) {
        $bank = true;
    } elseif (isset(Auth::user()->pemasok_id)) {
        $pemasok = true;
    } elseif (isset(Auth::user()->pelanggan_id)) {
        $pelanggan = true;
    } elseif (isset(Auth::user()->petugas_gudang_id)) {
        $petugasGudang = true;
    }

    $set = App\Models\PengaturanAplikasi::find(1);
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/mdi.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}">
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
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <style type="text/css" media="screen">
        .dropdown-toggle::after{
            content: "";
            border: 0em solid;
        },
        .list-group-flush > .list-group-item::last-child{
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
</head>
<body>
    @if(isset($shop))
    @yield('content')
    <!-- Copyright -->
    <div class="footer-copyright text-center pt-4 text-dark fixed">
        <div class="copyright">
            <span>© 2020 Copyright:</span>
            <a href="{{$set->copyright_link}}" class="text-dark"> {{$set->copyright_text}}</a>
        </div>
    </div>
    <!-- Copyright -->
    @else
    <div id="app">
        <div class="wrapper">
            @if(!isset($nosidebar))
            <!-- Sidebar  -->
            @include('layouts.dashboard.sidebar')
            @endif

            <div id="content">
                <!-- Page Content  -->
                <div class="container-fluid">
                    @include('layouts.dashboard.navbar')
                    <div class=" row">
                        <div class=" col-12">
                            @yield('content')
                            <!-- Copyright -->
                            <div class="footer-copyright text-center pt-4 text-dark fixed">
                                <div class="copyright">
                                    <span>© 2020 Copyright:</span>
                                    <a href="{{$set->copyright_link}}" class="text-dark"> {{$set->copyright_text}}</a>
                                </div>
                            </div>
                            <!-- Copyright -->
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($rightbar))
            @include('layouts.dashboard.rightbar')
            @endif
        </div>
    </div>
    @endif
</body>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script><script src="https://leaflet.github.io/Leaflet.Editable/src/Leaflet.Editable.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->

<script type="text/javascript">
    $(document).ready(function () {
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


    });
</script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.nl.min.js"></script>
@stack('script')
<script src="{{ asset('js/carousel.js') }}"></script>
</html>
