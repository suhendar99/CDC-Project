<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-sm bg-my-primary">
            <i class="material-icons md-24">format_align_left</i>
        </button>
        @if(isset($admin) || isset($pemasok) || isset($karyawan))
        <button type="button" id="rightbarCollapse" class="btn btn-sm bg-my-warning d-inline-block ml-auto">
            <i class="material-icons md-24">format_align_right</i>
        </button>                   
        @endif 
    </div>
</nav>
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