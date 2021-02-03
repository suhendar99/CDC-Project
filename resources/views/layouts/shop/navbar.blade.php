
<div id="navbar">
	<nav class="navbar navbar-light bg-light shadow px-4 w-100 fixed">
		<button type="button" id="categoryCollapse" class="btn btn-sm btn-transparent mr-auto">
        <i class="material-icons md-24 text-my-primary">dehaze</i>
    </button>
		<a class="navbar-brand pl-2" href="/">
	    <img src="{{asset('images/logo-cdc.png')}}" width="50" class="d-inline-block align-top" alt="">
	    <b class="text-24 text-my-primary">Shop</b>
      </a>
        @guest
            <a class="ml-auto pr-2" href="{{route('login')}}">Login</a>
        @else
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ isset(Auth::user()->pelanggan_id) ? Auth::user()->pelanggan->nama :  (isset(Auth::user()->pengurus_gudang_id) ? Auth::user()->pengurusGudang->nama :(isset(Auth::user()->pembeli_id) ? Auth::user()->pembeli->nama : (isset(Auth::user()->bulky_id) ? Auth::user()->bulky->nama :(isset(Auth::user()->pemasok_id) ? Auth::user()->pemasok->nama : Auth::user()->name)))) }}
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

                <a class="dropdown-item" href="{{ route('dashboard') }}">
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
