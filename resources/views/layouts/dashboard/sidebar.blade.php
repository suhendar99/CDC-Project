{{-- {{dd('returOut : '.Request::is('v1/returOut/*'), 'retur : '.Request::is('v1/retur/*'))}} --}}
<div id="sidebar">
    <div id="sidebar-child" class="shadow">
        <nav>
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <center>
                        @if($set->logo_app != null)
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
                        <li class="{{ Request::is('v1/piutangIn*') ? 'active' : false }}">
                            <a href="{{route('piutangIn.index')}}" class="valign-center {{ Request::is('v1/piutangIn*') ? 'active' : false }}"><i class="material-icons">attach_money</i>Data Piutang</a>
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
                        {{ Request::is('v1/koperasi*') ? 'active' : false }}
                        {{ Request::is('v1/armada*') ? 'active' : false }}
                        @endif
                    ">
                        @if (isset($admin))
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
                            {{ Request::is('v1/koperasi*') ? 'show' : false }}
                            {{ Request::is('v1/armada*') ? 'show' : false }}
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
                            <li class="
                                {{ Request::is('v1/koperasi*') ? 'active' : false }}
                            ">
                                <a href="{{route('koperasi.index')}}">Data Koperasi</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/armada*') ? 'active' : false }}
                            ">
                                <a href="{{route('armada.index')}}">Data Armada Pengiriman</a>
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
                    ">
                        <a href="#gudangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">house_siding</i>Gudang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/gudang*') ? 'show' : false }}
                            {{ Request::is('v1/pengurus-gudang*') ? 'show' : false }}
                        " id="gudangSubmenu">
                            <li class="{{ Request::is('v1/gudang*') ? 'active' : false }}">
                                <a href="{{route('gudang.index')}}">Identitas Gudang</a>
                            </li>
                            <li class="{{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}">
                                <a href="{{route('pengurus-gudang.index')}}">Pengurus Gudang</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('v1/storage*') ? 'active' : false }}">
                        <a href="{{route('storage.index')}}" class="valign-center"><i class="material-icons">work</i>Pengelolaan Barang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/po*') ? 'active' : false }}
                        {{ Request::is('v1/returIn*') ? 'active' : false }}
                        {{ Request::is('v1/returOut*') ? 'active' : false }}
                        {{ Request::is('v1/pemesanan*') ? 'active' : false }}
                    ">
                        <a href="#transaksiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">attach_money</i>Transaksi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/po*') ? 'show' : false }}
                            {{ Request::is('v1/returIn*') ? 'show' : false }}
                            {{ Request::is('v1/returOut*') ? 'show' : false }}
                            {{ Request::is('v1/pemesanan*') ? 'show' : false }}
                        " id="transaksiSubmenu">
                            <li class="{{ Request::is('v1/pemesanan*') ? 'active' : false }}">
                                <a href="{{route('pemesanan.index')}}">Pesanan Pelanggan</a>
                            </li>
                            <li class="{{ Request::is('v1/po*') ? 'active' : false }}">
                                <a href="{{route('po.index')}}">Pembelian Barang</a>
                            </li>
                            <li class="{{ Request::is('v1/returIn*') ? 'active' : false }}">
                                <a href="{{route('returIn.index')}}">Retur Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/returOut*') ? 'active' : false }}">
                                <a href="{{route('returOut.index')}}">Retur Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/piutangIn*') ? 'active' : false }}
                        {{ Request::is('v1/piutangOut*') ? 'active' : false }}
                    ">
                        <a href="#piutangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">money_off</i>Piutang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/piutangIn*') ? 'show' : false }}
                            {{ Request::is('v1/piutangOut*') ? 'show' : false }}
                        " id="piutangSubmenu">
                            <li class="{{ Request::is('v1/piutangIn*') ? 'active' : false }}">
                                <a href="{{route('piutangIn.index')}}">Piutang Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/piutangOut*') ? 'active' : false }}">
                                <a href="{{route('piutangOut.index')}}">Piutang Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}
                        {{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}
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
                    @endif
                    @if (isset($pengurusGudangBulky))
                    <li class="
                        {{ Request::is('v1/gudang-bulky*') ? 'active' : false }}
                        {{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}
                    ">
                        <a href="#gudangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">house_siding</i>Gudang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/gudang-bulky*') ? 'show' : false }}
                            {{ Request::is('v1/pengurus-gudang*') ? 'show' : false }}
                        " id="gudangSubmenu">
                            <li class="{{ Request::is('v1/gudang-bulky*') ? 'active' : false }}">
                                <a href="{{route('gudang-bulky.index')}}">Identitas Gudang</a>
                            </li>
                            <li class="{{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}">
                                <a href="{{route('pengurus-gudang.index')}}">Pengurus Gudang</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('v1/storage*') ? 'active' : false }}">
                        <a href="{{route('storage.index')}}" class="valign-center"><i class="material-icons">work</i>Pengelolaan Barang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/po*') ? 'active' : false }}
                        {{ Request::is('v1/returIn*') ? 'active' : false }}
                        {{ Request::is('v1/returOut*') ? 'active' : false }}
                        {{ Request::is('v1/pemesanan*') ? 'active' : false }}
                    ">
                        <a href="#transaksiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">attach_money</i>Transaksi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/po*') ? 'show' : false }}
                            {{ Request::is('v1/returIn*') ? 'show' : false }}
                            {{ Request::is('v1/returOut*') ? 'show' : false }}
                            {{ Request::is('v1/pemesanan*') ? 'show' : false }}
                        " id="transaksiSubmenu">
                            <li class="{{ Request::is('v1/pemesanan*') ? 'active' : false }}">
                                <a href="{{route('pemesanan.index')}}">Pesanan Pelanggan</a>
                            </li>
                            <li class="{{ Request::is('v1/po*') ? 'active' : false }}">
                                <a href="{{route('po.index')}}">Pembelian Barang</a>
                            </li>
                            <li class="{{ Request::is('v1/returIn*') ? 'active' : false }}">
                                <a href="{{route('returIn.index')}}">Retur Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/returOut*') ? 'active' : false }}">
                                <a href="{{route('returOut.index')}}">Retur Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/piutangIn*') ? 'active' : false }}
                        {{ Request::is('v1/piutangOut*') ? 'active' : false }}
                    ">
                        <a href="#piutangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">money_off</i>Piutang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/piutangIn*') ? 'show' : false }}
                            {{ Request::is('v1/piutangOut*') ? 'show' : false }}
                        " id="piutangSubmenu">
                            <li class="{{ Request::is('v1/piutangIn*') ? 'active' : false }}">
                                <a href="{{route('piutangIn.index')}}">Piutang Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/piutangOut*') ? 'active' : false }}">
                                <a href="{{route('piutangOut.index')}}">Piutang Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}
                        {{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}
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
                    @endif
                    {{-- @endif --}}
                     @if (Auth::user()->pelanggan_id != null)
                    {{-- <li class="
                        {{ Request::is('v1/barangWarung*') ? 'active' : false }}
                    ">
                        <a href="#barangWarung" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i> Manajemen Warung</a>
                        <ul id="barangWarung" class="collapse list-unstyled
                            {{ Request::is('v1/barangWarung*') ? 'show' : false }}
                        ">
                        </ul>
                    </li> --}}
                    <li class="
                    {{ Request::is('v1/barangWarung*') ? 'active' : false }}
                    ">
                        <a href="{{route('barangWarung.index')}}" class="valign-center"><i class="material-icons">work</i>Daftar Barang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/pemesananMasukWarung*') ? 'active' : false }}
                        {{ Request::is('v1/pemesananKeluarWarung*') ? 'active' : false }}
                        {{ Request::is('v1/returMasukPembeli*') ? 'active' : false }}
                        {{ Request::is('v1/returKeluarPelanggan*') ? 'active' : false }}
                    ">
                        <a href="#transaksiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">attach_money</i>Transaksi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/pemesananMasukWarung*') ? 'show' : false }}
                            {{ Request::is('v1/pemesananKeluarWarung*') ? 'show' : false }}
                            {{ Request::is('v1/returMasukPembeli*') ? 'show' : false }}
                            {{ Request::is('v1/returKeluarPelanggan*') ? 'show' : false }}
                        " id="transaksiSubmenu">
                            <li class="{{ Request::is('v1/pemesananMasukWarung*') ? 'active' : false }}">
                                <a href="{{route('pemesananMasukWarung.index')}}">Pesanan Pelanggan</a>
                            </li>
                            <li class="{{ Request::is('v1/pemesananKeluarWarung*') ? 'active' : false }}">
                                <a href="{{route('pemesananKeluarWarung.index')}}">Pembelian Barang</a>
                            </li>
                            <li class="{{ Request::is('v1/returMasukPembeli*') ? 'active' : false }}">
                                <a href="{{route('returMasukPembeli.index')}}">Retur Masuk</a>
                            </li>
                            <li class="{{ Request::is('v1/returKeluarPelanggan*') ? 'active' : false }}">
                                <a href="{{route('returKeluarPelanggan.index')}}">Retur Keluar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/piutangPelanggan*') ? 'active' : false }}
                    ">
                        <a href="{{route('piutangPelanggan.index')}}" class="valign-center"><i class="material-icons">money_off</i>Piutang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}
                        {{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}
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
                            {{ Request::is('v1/laporan-barang*') ? 'active' : false }}
                            {{ Request::is('v1/laporan-po*') ? 'active' : false }}
                        ">
                            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">text_snippet</i>Laporan</a>
                            <ul class="collapse list-unstyled
                                {{ Request::is('v1/laporan-barang-masuk*') ? 'show' : false }}
                                {{ Request::is('v1/laporan-barang-keluar*') ? 'show' : false }}
                                {{ Request::is('v1/laporan-barang*') ? 'show' : false }}
                                {{ Request::is('v1/laporan-po*') ? 'show' : false }}
                            " id="reportSubmenu">
                                <li class="{{ Request::is('v1/laporan-barang-keluar*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang.keluar')}}">Penjualan</a>
                                </li>
                                <li class="{{ Request::is('v1/laporan-barang-masuk*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang.masuk')}}">Pembelian</a>
                                </li>
                                <li class="{{ Request::is('v1/laporan-barang*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang')}}">Stok Barang</a>
                                </li>
                                {{-- <li class="{{ Request::is('v1/laporan-barang-masuk*') ? 'active' : false }}">
                                    <a href="{{route('laporan.barang.masuk')}}">Neraca untung Rugi</a>
                                </li> --}}
                                {{-- <li class="{{ Request::is('v1/laporan-po*') ? 'active' : false }}">
                                    <a href="{{route('laporan.po')}}">Purcase Order</a>
                                </li> --}}
                            </ul>
                        </li>
                    @endif
                    @if (isset($admin))
                    <li class="
                        {{ Request::is('v1/setApp*') ? 'active' : false }}
                        {{ Request::is('v1/pengaturanTransaksi*') ? 'active' : false }}
                    ">
                        <a href="#colapsePengaturan" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">settings</i> Pengaturan</a>
                        <ul id="colapsePengaturan" class="collapse list-unstyled
                            {{ Request::is('v1/setApp*') ? 'show' : false }}
                            {{ Request::is('v1/pengaturanTransaksi*') ? 'show' : false }}
                        ">
                            <li class="
                            {{ Request::is('v1/setApp*') ? 'active' : false }}
                            ">
                                <a href="{{route('setApp.index')}}">Aplikasi</a>
                            </li>
                            <li class="
                            {{ Request::is('v1/pengaturanTransaksi*') ? 'active' : false }}
                            ">
                                <a href="{{route('pengaturanTransaksi.index')}}">Transaksi</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
