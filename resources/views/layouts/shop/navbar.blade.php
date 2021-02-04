
<div id="navbar">
	<nav class="navbar navbar-light bg-light shadow px-4 w-100 fixed">
		<button type="button" id="categoryCollapse" class="btn btn-sm btn-transparent mr-auto">
            <i class="material-icons md-24 text-my-primary">dehaze</i>
        </button>
		<a class="navbar-brand pl-2" href="/">
            @if(Auth::user()->pengurus_gudang_id != null)
            <img src="{{asset('images/logo/logo-cdcretail.svg')}}" height="40" class="d-inline-block align-top">
            @elseif(Auth::user()->pengurus_gudang_bulky_id != null)
            <img src="{{asset('images/logo/logo-cdcbulky.svg')}}" height="40" class="d-inline-block align-top">
            @elseif(Auth::user()->pelanggan_id != null) 
            <img src="{{asset('images/logo/Logo-iwarung.svg')}}" height="40" class="d-inline-block align-top">
            @elseif(Auth::user()->pembeli_id != null) 
            <img src="{{asset('images/logo/Logo-imarket.svg')}}" height="40" class="d-inline-block align-top">
            @endif
        </a>
        @guest
            <a class="ml-auto pr-2" href="{{route('login')}}">Login</a>
        @else
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="
                {{ asset(''.
                    isset(Auth::user()->pelanggan->foto) ? Auth::user()->pelanggan->foto :  
                        (isset(Auth::user()->karyawan->foto) ? Auth::user()->karyawan->foto :
                            (isset(Auth::user()->bank->foto) ? Auth::user()->bank->foto : 
                                (isset(Auth::user()->pemasok->foto) ? Auth::user()->pemasok->foto : 
                                    (isset(Auth::user()->pembeli->foto) ? Auth::user()->pembeli->foto : 
                                        'images/logo-user.png' 
                                    )
                                )
                            )
                        )
                    .'') 
                }}
            " class="rounded-circle avatar">
            {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->pengurus_gudang_id) ? Auth::user()->pengurusGudang->nama :(isset(Auth::user()->pembeli_id) ? Auth::user()->pembeli->nama : (isset(Auth::user()->bulky_id) ? Auth::user()->bulky->nama :(isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : (isset(Auth::user()->pengurus_gudang_bulky_id) ? Auth::user()->pengurusGudangBulky->nama : Auth::user()->name))))) }}
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            @if(!Request::is('shop'))
                <a class="dropdown-item" href="{{ route('shop') }}">
                    Belanja
                </a>
            @endif
            @if (Auth::user()->pengurus_gudang_id != null ||Auth::user()->bulky_id != null || Auth::user()->pelanggan_id != null)
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                    {{ __('Dashboard') }}
                </a>
            @elseif(Auth::user()->pembeli_id != null)
                <a class="dropdown-item" href="{{ route('setPembeli.show') }}">
                    Profil Pengguna
                </a>
                <a class="dropdown-item" href="{{ route('setPass.show') }}">
                    Perbarui Password
                </a>

                <a class="dropdown-item" href="{{ route('transaksi.pembeli.riwayat') }}">
                    Riwayat Transaksi
                </a>
            @endif
            {{-- @if (Auth::user()->pembeli_id != null)
                <a class="dropdown-item" href="{{ route('transaksiTerakhirPembeli') }}">
                    {{ __('Transaksi Terakhir') }}
                </a>
            @endif --}}
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endguest
    </nav>
    @if (session()->has('sukses'))
    <script>
        alert("{{ session()->get('sukses') }}");
    </script>
    @endif
</div>
