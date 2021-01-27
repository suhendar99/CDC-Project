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
        @endguest
    </nav>
    @if (session()->has('sukses'))
    <script>
        alert("{{ session()->get('sukses') }}");
    </script>
    @endif
</div>
