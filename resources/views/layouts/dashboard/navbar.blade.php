<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-sm btn-info bg-my-primary">
            <i class="material-icons md-24">format_align_left</i>
        </button>
        <div class="d-inline-block float-right valign-center">
            <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle avatar"> 
            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->karyawan_id) ? Auth::user()->karyawan->nama :(isset(Auth::user()->bank_id) ? Auth::user()->bank->nama : (isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name))) }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="d-my-none">
    <div class=" row valign-center mb-4"> 
        <div class="col-md-6 col-sm-12 valign-center">
            <button type="button" id="sidebarCollapsed" class="btn btn-sm btn-info bg-my-primary">
                <i class="material-icons md-24">format_align_left</i>
            </button> 
        </div>
        <div class="col-md-6">
            <div class="d-inline-block float-right valign-center">
                <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle avatar"> 
                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->karyawan_id) ? Auth::user()->karyawan->nama :(isset(Auth::user()->bank_id) ? Auth::user()->bank->nama : (isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name))) }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

