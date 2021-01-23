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
                {{-- @if(isset($admin)) --}}
                <ul class="list-unstyled components">
                    <li class="
                        {{ Request::is('v1/dashboard*') ? 'active' : false }}
                    ">
                        <a href="{{route('dashboard')}}" class="valign-center"><i class="material-icons">dashboard</i>Dashboard</a>
                    </li>
                    @if (isset($bank))
                        <li class="{{ Request::is('v1/piutang*') ? 'active' : false }}">
                            <a href="{{route('piutang.index')}}" class="valign-center {{ Request::is('v1/piutang*') ? 'active' : false }}"><i class="material-icons">attach_money</i>Data Piutang</a>
                        </li>
                        <li class="{{ Request::is('v1/bungaBank*') ? 'active' : false }}">
                            <a href="{{route('bungaBank.index')}}" class="valign-center {{ Request::is('v1/bungaBank*') ? 'active' : false }}"><i class="material-icons">attach_money</i>Bunga  Bank</a>
                        </li>
                    @endif
                    @if (isset($pemasok))
                        <li class="{{ Request::is('v1/rekeningPemasok*') ? 'active' : false }}">
                            <a href="{{route('rekeningPemasok.index')}}" class="valign-center {{ Request::is('v1/rekeningPemasok*') ? 'active' : false }}"><i class="material-icons">attach_money</i>Rekening Pemasok</a>
                        </li>
                        <li class="{{ Request::is('v1/barang*') ? 'active' : false }}">
                            <a href="{{route('barang.index')}}" class="valign-center {{ Request::is('v1/barang*') ? 'active' : false }}"><i class="material-icons">archive</i>Barang</a>
                        </li>
                        <li class="{{ Request::is('v1/transaksiPemasok*') ? 'active' : false }}">
                            <a href="{{-- {{route('transaksiPemasok.index')}} --}}" class="valign-center {{ Request::is('v1/transaksiPemasok*') ? 'active' : false }}"><i class="material-icons">money</i>Transaksi</a>
                        </li>
                        <li class="{{ Request::is('v1/po-masuk-pemasok*') ? 'active' : false }}">
                            <a href="{{route('po.masuk.pemasok')}}" class="valign-center {{ Request::is('v1/po-masuk-pemasok*') ? 'active' : false }}"><i class="material-icons">money</i>PO Masuk</a>
                        </li>
                        <li class="{{ Request::is('v1/Laporan*') ? 'active' : false }}">
                            <a href="{{-- {{route('transaksiPemasok.index')}} --}}" class="valign-center {{ Request::is('v1/transaksiPemasok*') ? 'active' : false }}"><i class="material-icons">insert_drive_file</i>Laporan</a>
                        </li>
                    @endif
                    @if (isset($admin))
                    <li class="
                        @if (isset($admin))
                        {{ Request::is('v1/user*') ? 'active' : false }}
                        {{ Request::is('v1/bank*') ? 'active' : false }}
                        {{ Request::is('v1/akun-bank*') ? 'active' : false }}
                        {{ Request::is('v1/pemilik-gudang*') ? 'active' : false }}
                        {{ Request::is('v1/pemasok*') ? 'active' : false }}
                        {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/kategoriBarang*') ? 'active' : false }}
                        {{ Request::is('v1/batasPiutang*') ? 'active' : false }}
                        @endif
                    ">
                        @if (isset($admin) || isset($pengurusGudang))
                        <a href="#dataSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i> Data Master</a>
                        <ul id="dataSubmenu" class="collapse list-unstyled
                            @if (isset($admin))
                            {{ Request::is('v1/user*') ? 'show' : false }}
                            {{ Request::is('v1/bank*') ? 'show' : false }}
                            {{ Request::is('v1/akun-bank*') ? 'show' : false }}
                            {{ Request::is('v1/pemilik-gudang*') ? 'show' : false }}
                            {{ Request::is('v1/pemasok*') ? 'show' : false }}
                            {{ Request::is('v1/pelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/kategoriBarang*') ? 'show' : false }}
                            {{ Request::is('v1/batasPiutang*') ? 'show' : false }}
                            @endif
                        ">
                        @endif
                        {{-- {{dd($admin)}} --}}
                            @if(isset($admin))
                            <li class="
                                {{ Request::is('v1/user*') ? 'active' : false }}
                            ">
                                <a href="{{route('user.index')}}">Akun</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/bank*') ? 'active' : false }}
                            ">
                                <a href="{{route('bank.index')}}">Bank</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/akun-bank*') ? 'active' : false }}
                            ">
                                <a href="{{route('akun-bank.index')}}">Bank Account</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemilik-gudang*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemilik-gudang.index')}}">Pemilik Gudang</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemasok*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemasok.index')}}">Pemasok</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                            ">
                                <a href="{{route('pelanggan.index')}}">Pembeli</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/kategoriBarang*') ? 'active' : false }}
                            ">
                                <a href="{{route('kategoriBarang.index')}}">Kategori Induk</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/batasPiutang*') ? 'active' : false }}
                            ">
                                <a href="{{route('batasPiutang.index')}}">Batas Piutang</a>
                            </li>
                            @endif
                            @if(isset($pemasok))
                            <li class="
                                {{ Request::is('v1/barang*') ? 'active' : false }}
                            ">
                                <a href="{{route('barang.index')}}">Barang</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (isset($pengurusGudang))
                    <li class="
                        {{ Request::is('v1/gudang*') ? 'active' : false }}
                        {{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}
                        {{ Request::is('v1/storage*') ? 'active' : false }}
                    ">
                        <a href="#gudangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">house_siding</i>Gudang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/gudang*') ? 'show' : false }}
                            {{ Request::is('v1/pengurus-gudang*') ? 'show' : false }}
                            {{ Request::is('v1/storage*') ? 'show' : false }}
                        " id="gudangSubmenu">
                            <li class="{{ Request::is('v1/gudang*') ? 'active' : false }}">
                                <a href="{{route('gudang.index')}}">Identitas Gudang</a>
                            </li>
                            <li class="{{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}">
                                <a href="{{route('pengurus-gudang.index')}}">Pengurus Gudang</a>
                            </li>
                            <li class="{{ Request::is('v1/storage*') ? 'active' : false }}">
                                <a href="{{route('storage.index')}}">Manajemen Barang</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/po*') ? 'active' : false }}
                        {{ Request::is('v1/retur*') ? 'active' : false }}
                        {{ Request::is('v1/returOut*') ? 'active' : false }}
                        {{ Request::is('v1/pemesanan*') ? 'active' : false }}
                    ">
                        <a href="#transaksiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">attach_money</i>Transaksi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/po*') ? 'show' : false }}
                            {{ Request::is('v1/retur*') ? 'show' : false }}
                            {{ Request::is('v1/returOut*') ? 'show' : false }}
                            {{ Request::is('v1/pemesanan*') ? 'show' : false }}
                        " id="transaksiSubmenu">
                            <li class="{{ Request::is('v1/pemesanan*') ? 'active' : false }}">
                                <a href="{{route('pemesanan.index')}}">Pemesanan Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/po*') ? 'active' : false }}">
                                <a href="{{route('po.index')}}">Pemesanan Keluar</a>
                            </li>
                            <li class="{{ Request::is('v1/retur*') ? 'active' : false }}">
                                <a href="{{route('retur.index')}}">Retur Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/returOut*') ? 'active' : false }}">
                                <a href="{{route('returOut.index')}}">Retur Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{-- {{ Request::is('v1/piutang*') ? 'active' : false }}
                        {{ Request::is('v1/piutangOut*') ? 'active' : false }} --}}
                    ">
                        <a href="#rekapitulasiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">book</i>Rekapitulasi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/rekapitulasiPembelian*') ? 'show' : false }}
                            {{ Request::is('v1/rekapitulasiPenjualan*') ? 'show' : false }}
                        " id="rekapitulasiSubmenu">
                            <li class="{{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPenjualan.index')}}">Penjualan</a>
                            </li>
                            <li class="{{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPembelian.index')}}">Pembelian</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/piutang*') ? 'active' : false }}
                        {{ Request::is('v1/piutangOut*') ? 'active' : false }}
                    ">
                        <a href="#piutangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">money_off</i>Piutang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/piutang*') ? 'show' : false }}
                            {{ Request::is('v1/piutangOut*') ? 'show' : false }}
                        " id="piutangSubmenu">
                            <li class="{{ Request::is('v1/piutang*') ? 'active' : false }}">
                                <a href="{{route('piutang.index')}}">Piutang Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/piutangOut *') ? 'active' : false }}">
                                <a href="{{route('piutangOut.index')}}">Piutang keluar</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    {{-- @endif --}}
                     @if (Auth::user()->pelanggan_id != null)
                    <li class="
                        {{ Request::is('v1/barangs*') ? 'active' : false }}
                    ">
                        <a href="#dataSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i> Data Master</a>
                        <ul id="dataSubmenu" class="collapse list-unstyled
                            {{ Request::is('v1/barangs*') ? 'show' : false }}
                        ">
                            <li class="
                            {{ Request::is('v1/barangs*') ? 'active' : false }}
                            ">
                                <a href="{{route('get-barang')}}">Barang</a>
                            </li>
                        </ul>
                    </li>
                    @endif
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
                    @if (isset($pengurusGudang))
                        <li class="
                            {{ Request::is('v1/laporan-barang-masuk*') ? 'active' : false }}
                            {{ Request::is('v1/laporan-barang-keluar*') ? 'active' : false }}
                            {{ Request::is('v1/laporan-po*') ? 'active' : false }}
                        ">
                            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">text_snippet</i>Laporan</a>
                            <ul class="collapse list-unstyled
                                {{ Request::is('v1/laporan-barang-masuk*') ? 'show' : false }}
                                {{ Request::is('v1/laporan-barang-keluar*') ? 'show' : false }}
                                {{ Request::is('v1/laporan-po*') ? 'show' : false }}
                            " id="reportSubmenu">
                                <li class="{{ Request::is('v1/laporan-barang-masuk*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang.masuk')}}">Barang Masuk</a>
                                </li>
                                <li class="{{ Request::is('v1/laporan-barang-keluar*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang.keluar')}}">Barang Keluar</a>
                                </li>
                                <li class="{{ Request::is('v1/laporan-po*') ? 'active' : false }}">
                                    <a href="{{route('laporan.po')}}">Purcase Order</a>
                                </li>
                            </ul>
                        </li>
                    @endif
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
                    @if (isset($admin))
                    <li>
                        <a href="{{route('setApp.index')}}" class="valign-center"><i class="material-icons">settings</i>Pengaturan</a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
