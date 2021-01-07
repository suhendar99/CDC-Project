<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-sm btn-transparent">
            <i class="material-icons md-24 text-my-primary">dehaze</i>
        </button>
        <div class="d-inline-block float-right valign-center">
            <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle avatar">
            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->karyawan_id) ? Auth::user()->karyawan->nama :(isset(Auth::user()->bank_id) ? Auth::user()->bank->nama : (isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name))) }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @if (Auth::user()->pelanggan_id != null)
                <a class="dropdown-item" href="{{route('setPelanggan.show')}}">Perbaharui Akun</a>
                @elseif(Auth::user()->pemasok_id != null)
                    <a class="dropdown-item" href="{{route('setPemasok.show')}}">Perbaharui Akun</a>
                @elseif(Auth::user()->karyawan_id != null)
                    <a class="dropdown-item" href="{{route('setKaryawan.show')}}">Perbaharui Akun</a>
                @elseif(Auth::user()->pengurus_gudang_id != null)
                    <a class="dropdown-item" href="{{route('setPengurusGudang.show')}}">Perbaharui Akun</a>
                @elseif(Auth::user()->bank_id != null)
                    <a class="dropdown-item" href="{{route('setBank.show')}}">Perbaharui Akun</a>
                @else
                    <a class="dropdown-item" href="{{route('setAdmin.show')}}">Perbaharui Akun</a>
                @endif
                <a class="dropdown-item" href="{{route('setPass.show')}}">Perbaharui Password</a>
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
    <div class=" row valign-center mb-1">
        <div class="col-md-6 col-sm-12 valign-center">
            <button type="button" id="sidebarCollapsed" class="btn btn-sm btn-transparent">
                <i class="material-icons md-24 text-my-primary">dehaze</i>
            </button>
        </div>
        <div class="col-md-6">
            <div class="d-inline-block float-right valign-center">
                <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle avatar">
                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->karyawan_id) ? Auth::user()->karyawan->nama :(isset(Auth::user()->bank_id) ? Auth::user()->bank->nama : (isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name))) }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->pelanggan_id != null)
                    <a class="dropdown-item" href="{{route('setPelanggan.show')}}">Perbaharui Akun</a>
                    @elseif(Auth::user()->pemasok_id != null)
                        <a class="dropdown-item" href="{{route('setPemasok.show')}}">Perbaharui Akun</a>
                    @elseif(Auth::user()->karyawan_id != null)
                        <a class="dropdown-item" href="{{route('setKaryawan.show')}}">Perbaharui Akun</a>
                    @elseif(Auth::user()->pengurus_gudang_id != null)
                        <a class="dropdown-item" href="{{route('setPengurusGudang.show')}}">Perbaharui Akun</a>
                    @elseif(Auth::user()->bank_id != null)
                        <a class="dropdown-item" href="{{route('setBank.show')}}">Perbaharui Akun</a>
                    @else
                        <a class="dropdown-item" href="{{route('setAdmin.show')}}">Perbaharui Akun</a>
                    @endif
                    <a class="dropdown-item" href="{{route('setPass.show')}}">Perbaharui Password</a>
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
@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="material-icons"></i>
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="material-icons"></i>
    {{ session()->get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


