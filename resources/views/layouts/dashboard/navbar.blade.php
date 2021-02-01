<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-sm btn-transparent">
            <i class="material-icons md-24 text-my-primary">dehaze</i>
        </button>
        <div class="d-inline-block float-right valign-center">
            <img src="
                {{ asset(''.isset(Auth::user()->pelanggan->foto) ? Auth::user()->pelanggan->foto :  (isset(Auth::user()->karyawan->foto) ? Auth::user()->karyawan->foto :(isset(Auth::user()->bank->foto) ? Auth::user()->bank->foto : (isset(Auth::user()->pemasok->foto) ? Auth::user()->pemasok->foto : 'images/logo-user.png' ))).'') }}
            " class="rounded-circle avatar">
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
            @if(!isset($nosidebar))
            <button type="button" id="sidebarCollapsed" class="btn btn-sm btn-transparent">
                <i class="material-icons md-24 text-my-primary">dehaze</i>
            </button>
            @endif
        </div>
        <div class="col-md-6">
            <div class="d-inline-block float-right valign-center">
                <img src="
                    {{ asset(''.isset(Auth::user()->pelanggan->foto) ? Auth::user()->pelanggan->foto :  (isset(Auth::user()->karyawan->foto) ? Auth::user()->karyawan->foto :(isset(Auth::user()->bank->foto) ? Auth::user()->bank->foto : (isset(Auth::user()->pemasok->foto) ? Auth::user()->pemasok->foto : 'images/logo-user.png' ))).'') }}
                " class="rounded-circle avatar">
                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->pengurus_gudang_id) ? Auth::user()->pengurusGudang->nama :(isset(Auth::user()->pembeli_id) ? Auth::user()->pembeli->nama : (isset(Auth::user()->bulky_id) ? Auth::user()->bulky->nama :(isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name)))) }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->name == null)
                        <a class="dropdown-item" href="/shop">Belanja</a>
                    @endif
                    @if(!isset($nosidebar))
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
                    @endif
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
<div class="alert alert-success alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-success">check_circle</i>
    {{ session()->get('success') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    {{ session()->get('error') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('failed'))
<div class="alert alert-danger alert-dismissible fade show valign-center" role="alert">
    <i class="material-icons text-my-danger">cancel</i>
    {{ session()->get('failed') }}
    <button type="button" class="btn btn-transparent fr-absolute" data-dismiss="alert" aria-label="Close">
        <i class="material-icons md-14">close</i>
    </button>
</div>
@elseif (session()->has('sukses'))
<script>
    alert("{{ session()->get('sukses') }}");
</script>
@endif


