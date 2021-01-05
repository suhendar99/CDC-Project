<div id="sidebar">
    <nav>
        <div class="sidebar-content shadow">
            <div class="sidebar-header">
                <center>
                    <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle mx-auto d-block avatar my-3">
                    <div class="btn-group dropright">
                      <span type="button" class="text-white avatar-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</span>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Profil</a>
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
                </center>
            </div>
            <ul class="list-unstyled components">
                @if(isset($admin))
                <li>
                    <a href="#">
                        <div class="sidebar card shadow mx-auto active d-flex justify-content-center">
                            <i class="material-icons md-14">dashboard</i>
                            <span class="sidebar span">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">people</i>
                            <span class="text-white f-9">Pengguna</span>
                        </div>
                    </a>
                </li>
                @elseif(isset($pemasok))
                <li>
                    <a href="#">
                        <div class="sidebar card shadow mx-auto active d-flex justify-content-center">
                            <i class="material-icons md-36">dashboard</i>
                            <span class="sidebar span">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">unarchive</i>
                            <span class="text-white f-9">Tambah Barang</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">local_shipping</i>
                            <span class="text-white f-9">Barang Dikirim</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">work</i>
                            <span class="text-white f-9">Data Barang</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">archive</i>
                            <span class="text-white f-9">Pesanan Masuk</span>
                        </div>
                    </a>
                </li>
                @elseif(isset($karyawan))
                <li>
                    <a href="#">
                        <div class="sidebar card shadow mx-auto active d-flex justify-content-center">
                            <i class="material-icons md-36">dashboard</i>
                            <span class="sidebar span">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">archive</i>
                            <span class="text-white f-9">Barang Masuk</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">work</i>
                            <span class="text-white f-9">Data Barang</span>
                        </div>
                    </a>
                </li>
                @endif
                <li>
                    <a href="#">
                        <div class="sidebar card mx-auto d-flex justify-content-center">
                            <i class="material-icons md-36">settings</i>
                            <span class="text-white f-9">Settings</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>