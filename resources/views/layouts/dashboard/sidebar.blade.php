<div id="sidebar">
    <div id="sidebar-child" class="shadow">
        <nav>
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <center>
                        @if($set->logo_tab != null)
                        <img src="{{asset($set->logo_app)}}" height="50" class="scale-down my-3">
                        @else
                        <img src="{{asset('images/logo-app.png')}}" height="50" class="scale-down my-3">
                        @endif
                    </center>
                </div>
                <ul class="list-unstyled components">
                    <li class="
                        {{ Request::is('v1/dashboard*') ? 'active' : false }}
                    ">
                        <a href="{{route('dashboard')}}" class="valign-center"><i class="material-icons">dashboard</i>Dashboard</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/user*') ? 'active' : false }}
                        {{ Request::is('v1/pemasok*') ? 'active' : false }}
                        {{ Request::is('v1/barang*') ? 'active' : false }}
                        {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/gudang*') ? 'active' : false }}
                        {{ Request::is('v1/storage/in*') ? 'active' : false }}
                        {{ Request::is('v1/storage/out*') ? 'active' : false }}
                    ">
                        <a href="#dataSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i> Data Master</a>
                        <ul id="dataSubmenu" class="collapse list-unstyled
                            {{ Request::is('v1/user*') ? 'show' : false }}
                            {{ Request::is('v1/pemasok*') ? 'show' : false }}
                            {{ Request::is('v1/barang*') ? 'show' : false }}
                            {{ Request::is('v1/pelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/gudang*') ? 'show' : false }}
                            {{ Request::is('v1/storage/in*') ? 'show' : false }}
                            {{ Request::is('v1/storage/out*') ? 'show' : false }}
                        ">
                            @if(isset($admin))
                            <li class="
                                {{ Request::is('v1/user*') ? 'active' : false }}
                            ">
                                <a href="{{route('user.index')}}">Akun</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemasok*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemasok.index')}}">Pemasok</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/barang*') ? 'active' : false }}
                            ">
                                <a href="{{route('barang.index')}}">Barang</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                            ">
                                <a href="{{route('pelanggan.index')}}">Pembeli</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/gudang*') ? 'active' : false }}
                            ">
                                <a href="{{route('gudang.index')}}">Gudang</a>
                            </li>
                            @endif
                            @if (isset($admin) || isset($pengurusGudang))
                            <li class="
                                {{ Request::is('v1/storage/in*') ? 'active' : false }}
                            ">
                                <a href="{{ route('in.index') }}">Storage Masuk</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/storage/out*') ? 'active' : false }}
                            ">
                                <a href="{{ route('out.index') }}">Storage Keluar</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    {{-- <li>
                        <a href="#transSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">receipt_long</i>Data Transaksi</a>
                        <ul class="collapse list-unstyled" id="transSubmenu">
                            <li>
                                <a href="#">Penerimaan Barang</a>
                            </li>
                            <li>
                                <a href="#">Retur Pembelian</a>
                            </li>
                            <li>
                                <a href="#">Pengiriman Barang</a>
                            </li>
                            <li>
                                <a href="#">Mutasi Barang Gudang</a>
                            </li>
                            <li>
                                <a href="#">Stok Barang</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">text_snippet</i>Laporan</a>
                        <ul class="collapse list-unstyled" id="reportSubmenu">
                            <li>
                                <a href="#">Penerimaan Barang</a>
                            </li>
                            <li>
                                <a href="#">Penerimaan Pembayaran</a>
                            </li>
                            <li>
                                <a href="#">Retur Barang</a>
                            </li>
                            <li>
                                <a href="#">Abolish Barang</a>
                            </li>
                            <li>
                                <a href="#">Pengiriman Barang</a>
                            </li>
                            <li>
                                <a href="#">Mutasi Barang Gudang</a>
                            </li>
                            <li>
                                <a href="#">Stok Barang</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href="#" class="valign-center"><i class="material-icons">info</i>Tentang</a>
                    </li> --}}
                    <li>
                        <a href="{{route('setApp.index')}}" class="valign-center"><i class="material-icons">settings</i>Pengaturan</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
