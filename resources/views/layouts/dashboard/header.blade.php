<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('images/logo-cdc.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CDC') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/mdi.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}">
    <link rel="stylesheet" href="{{ asset('css/rightbar.css')}}">
    <link rel="stylesheet" href="{{ asset('css/carousel.css')}}">

    @if(!isset($rightbar))
    <link rel="stylesheet" href="{{ asset('css/norightbar.css')}}">
    @endif
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        <div class="wrapper">
            <!-- Sidebar  -->
            @include('layouts.dashboard.sidebar')
            <!-- Page Content  -->
            @include('layouts.dashboard.navbar')

            <div id="content">
                <div class="container-fluid mt-3">
                    <div class=" row"> 
                        <div class=" col-12"> 
                            <div class=" row"> 
                                <div class=" col-md-8 col-sm-12"> 
                                    <div class=" row">  
                                        <div class="col-md-2 col-sm-4 text-md-left text-sm-center">
                                            <img src=" {{asset('images/logo-cdc.png')}}" class=" h-40 scale-down">
                                        </div>
                                        <div class=" col-md-10 col-sm-8 text-md-left text-sm-center"> 
                                            <h4 class="pl-2 py-1"> {{$pageTitle}}</h4>
                                        </div>
                                    </div>
                                </div>
                                @if(!isset($admin))
                                <div class=" col-md-4 col-sm-12">  
                                    <div class=" row"> 
                                        <div class=" col-md-12 col-sm-12"> 
                                            <div class=" form-group"> 
                                                <i class="material-icons md-24 icon-search">search</i>
                                                <input type=" text" name="search" class=" form-control rounded-40" placeholder=" Cari Barang ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>  
                    <div class=" row"> 
                        <div class=" col-12"> 
                            @yield('content')
                        </div>
                    </div>   
                </div>
            </div>
            @if(isset($rightbar))
            @include('layouts.dashboard.rightbar')
            @endif
        </div>
    </div>
</body>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#rightbarCollapse').on('click', function () {
            $('#rightbar').toggleClass('active');
        });

        $('#rightbarCollapsed').on('click', function () {
            $('#rightbar').toggleClass('active');
        });


    });
</script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@stack('script')
<script src="{{ asset('js/carousel.js') }}"></script>
</html>
