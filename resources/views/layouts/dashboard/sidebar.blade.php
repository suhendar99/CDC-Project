{{-- {{dd('returOut : '.Request::is('v1/returOut/*'), 'retur : '.Request::is('v1/retur/*'))}} --}}
<div id="sidebar">
    <div id="sidebar-child" class="shadow">
        <nav>
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <center>
                        {{-- @if($set->logo_app != null)
                        <img src="{{asset($set->logo_app)}}" height="50" class="scale-down my-3">
                        @else

                        <img src="{{asset('images/logo-app.png')}}" height="50" class="scale-down my-3">
                        @endif --}}
                        @if(Auth::user()->pengurus_gudang_id != null)
                        <img src="{{asset('images/logo/logo-cdcretail-white.svg')}}" height="60" width="90%" class="scale-down my-3">
                        @elseif(Auth::user()->pengurus_gudang_bulky_id != null)
                        <img src="{{asset('images/logo/logo-cdcbulky-white.svg')}}" height="60" width="90%" class="scale-down my-3">
                        @elseif(Auth::user()->pelanggan_id != null)
                        <img src="{{asset('images/logo/Logo-iwarung-white.svg')}}" height="60" width="90%" class="scale-down my-3">
                        @elseif(Auth::user()->pembeli_id != null)
                        <img src="{{asset('images/logo/Logo-imarket-white.svg')}}" height="60" width="90%" class="scale-down my-3">
                        @else
                        <img src="{{asset('images/logo/Logo-CDC-White.svg')}}" height="60" width="90%" class="scale-down my-3">
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
                        {{ Request::is('v1/ui-banner*') ? 'active' : false }}
                    ">
                        <a href="#piutangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">airplay</i>UI Element</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/ui-banner*') ? 'show' : false }}
                        " id="piutangSubmenu">
                            <li class="{{ Request::is('v1/ui-banner*') ? 'active' : false }}">
                                <a href="{{route('ui-banner.index')}}">Banner</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        @if (isset($admin))
                        {{ Request::is('v1/user*') ? 'active' : false }}
                        {{ Request::is('v1/kode-role-akses*') ? 'active' : false }}
                        {{ Request::is('v1/kode-transaksi*') ? 'active' : false }}
                        {{ Request::is('v1/bank*') ? 'active' : false }}
                        {{ Request::is('v1/akun-bank*') ? 'active' : false }}
                        {{ Request::is('v1/pemilik-gudang-retail*') ? 'active' : false }}
                        {{ Request::is('v1/pemilik-gudang-bulky*') ? 'active' : false }}
                        {{ Request::is('v1/pemasok*') ? 'active' : false }}
                        {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/pembeli*') ? 'active' : false }}
                        {{ Request::is('v1/satuan*') ? 'active' : false }}
                        {{ Request::is('v1/kategoriBarang*') ? 'active' : false }}
                        {{ Request::is('v1/koperasi*') ? 'active' : false }}
                        {{ Request::is('v1/armada*') ? 'active' : false }}
                        @endif
                    ">
                        @if (isset($admin))
                        <a href="#dataSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i> Data Master</a>
                        <ul id="dataSubmenu" class="collapse list-unstyled
                            @if (isset($admin))
                            {{ Request::is('v1/user*') ? 'show' : false }}
                            {{ Request::is('v1/kode-role-akses*') ? 'show' : false }}
                            {{ Request::is('v1/kode-transaksi*') ? 'show' : false }}
                            {{ Request::is('v1/bank*') ? 'show' : false }}
                            {{ Request::is('v1/akun-bank*') ? 'show' : false }}
                            {{ Request::is('v1/pemilik-gudang-retail*') ? 'show' : false }}
                            {{ Request::is('v1/pemilik-gudang-bulky*') ? 'show' : false }}
                            {{ Request::is('v1/pemasok*') ? 'show' : false }}
                            {{ Request::is('v1/pelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/pembeli*') ? 'show' : false }}
                            {{ Request::is('v1/satuan*') ? 'show' : false }}
                            {{ Request::is('v1/kategoriBarang*') ? 'show' : false }}
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
                                {{ Request::is('v1/kode-role-akses*') ? 'active' : false }}
                            ">
                                <a href="{{route('kode-role-akses.index')}}">Kode Role Akses</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/bank*') ? 'active' : false }}
                            ">
                                <a href="{{route('bank.index')}}">Bank</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemasok*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemasok.index')}}">Pemasok</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemilik-gudang-bulky*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemilik-gudang-bulky.index')}}">Pemilik Gudang Bulky</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pemilik-gudang-retail*') ? 'active' : false }}
                            ">
                                <a href="{{route('pemilik-gudang-retail.index')}}">Pemilik Gudang Retail</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pelanggan*') ? 'active' : false }}
                            ">
                                <a href="{{route('pelanggan.index')}}">Warung</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/pembeli*') ? 'active' : false }}
                            ">
                                <a href="{{route('pembeli.index')}}">Pembeli</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/kategoriBarang*') ? 'active' : false }}
                            ">
                                <a href="{{route('kategoriBarang.index')}}">Kategori Induk</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/kode-transaksi*') ? 'active' : false }}
                            ">
                                <a href="{{route('kode-transaksi.index')}}">Kode Transaksi</a>
                            </li>
                            <li class="
                                {{ Request::is('v1/satuan*') ? 'active' : false }}
                            ">
                                <a href="{{route('satuan.index')}}">Satuan Barang</a>
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
                    <li class="
                        {{ Request::is('v1/log-activity*') ? 'active' : false }}
                        {{ Request::is('v1/log-transaksi*') ? 'active' : false }}
                    ">
                        <a href="#logSub" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">grading</i>Log</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/log-activity*') ? 'show' : false }}
                            {{ Request::is('v1/log-transaksi*') ? 'show' : false }}
                        " id="logSub">
                            <li class="{{ Request::is('v1/log-activity*') ? 'active' : false }}">
                                <a href="{{route('log-activity.index')}}">Log Aktivitas</a>
                            </li>
                            <li class="{{ Request::is('v1/log-transaksi*') ? 'active' : false }}">
                                <a href="{{route('log-transaksi.index')}}">Log Transaksi</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (isset($pengurusGudang))
                    @if (Auth::user()->pengurusGudang->status == 1)
                    <li class="
                        {{ Request::is('v1/gudang-retail*') ? 'active' : false }}
                        {{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}
                    ">
                        <a href="#gudangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">house_siding</i>Gudang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/gudang-retail*') ? 'show' : false }}
                            {{ Request::is('v1/pengurus-gudang*') ? 'show' : false }}
                        " id="gudangSubmenu">
                            <li class="{{ Request::is('v1/gudang-retail*') ? 'active' : false }}">
                                <a href="{{route('gudang.index')}}">Identitas Gudang</a>
                            </li>
                            <li class="{{ Request::is('v1/pengurus-gudang*') ? 'active' : false }}">
                                <a href="{{route('pengurus-gudang.index')}}">Pengurus Gudang</a>
                            </li>
                        </ul>
                    </li>
                    @endif
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
                                <a href="{{route('pemesanan.index')}}">Pesanan dari Warung</a>
                            </li>
                            <li class="{{ Request::is('v1/po*') ? 'active' : false }}">
                                <a href="{{route('po.index')}}">Pembelian ke Bulky</a>
                            </li>
                            <li class="{{ Request::is('v1/returIn*') ? 'active' : false }}">
                                <a href="{{route('returIn.index')}}">Retur dari Warung</a>
                            </li>
                            <li class="{{ Request::is('v1/returOut*') ? 'active' : false }}">
                                <a href="{{route('returOut.index')}}">Retur ke Bulky</a>
                            </li>
                        </ul>
                    </li>
                    @if (Auth::user()->pengurusGudang->status == 1)
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
                                <a href="{{route('piutangIn.index')}}">Piutang dari Warung</a>
                            </li>
                            <li class="{{ Request::is('v1/piutangOut*') ? 'active' : false }}">
                                <a href="{{route('piutangOut.index')}}">Piutang ke Bulky</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}
                        {{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}
                        {{ Request::is('v1/retail/laba-rugi*') ? 'active' : false }}
                    ">
                        <a href="#rekapitulasiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">book</i>Rekapitulasi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/rekapitulasiPembelian*') ? 'show' : false }}
                            {{ Request::is('v1/rekapitulasiPenjualan*') ? 'show' : false }}
                            {{ Request::is('v1/retail/laba-rugi*') ? 'show' : false }}
                        " id="rekapitulasiSubmenu">
                            <li class="{{ Request::is('v1/rekapitulasiPenjualan*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPenjualan.index')}}">Penjualan</a>
                            </li>
                            <li class="{{ Request::is('v1/rekapitulasiPembelian*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPembelian.index')}}">Pembelian</a>
                            </li>
                            <li class="{{ Request::is('v1/retail/laba-rugi*') ? 'active' : false }}">
                                <a href="{{route('retail.laba-rugi.index')}}">Laba Rugi</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @endif
                    @if (isset($pengurusGudangBulky))
                        @if (Auth::user()->pengurusGudangBulky->status == 1)
                        <li class="
                            {{ Request::is('v1/gudang-bulky*') ? 'active' : false }}
                            {{ Request::is('v1/bulky/pengurus*') ? 'active' : false }}
                        ">
                            <a href="#gudangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">house_siding</i>Gudang</a>
                            <ul class="collapse list-unstyled
                                {{ Request::is('v1/gudang-bulky*') ? 'show' : false }}
                                {{ Request::is('v1/bulky/pengurus*') ? 'show' : false }}
                            " id="gudangSubmenu">
                                <li class="{{ Request::is('v1/gudang-bulky*') ? 'active' : false }}">
                                    <a href="{{route('gudang-bulky.index')}}">Identitas Gudang</a>
                                </li>
                                <li class="{{ Request::is('v1/bulky/pengurus*') ? 'active' : false }}">
                                    <a href="{{route('bulky.pengurus.index')}}">Pengurus Gudang</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    <li class="{{ Request::is('v1/bulky/storage*') ? 'active' : false }}">
                        <a href="{{route('bulky.storage.index')}}" class="valign-center"><i class="material-icons">work</i>Pengelolaan Barang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/bulky/pemesanan/keluar*') ? 'active' : false }}
                        {{ Request::is('v1/bulky/retur/masuk*') ? 'active' : false }}
                        {{ Request::is('v1/bulky/retur/keluar*') ? 'active' : false }}
                        {{ Request::is('v1/bulky/pemesanan/masuk*') ? 'active' : false }}
                    ">
                        <a href="#transaksiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">attach_money</i>Transaksi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/bulky/pemesanan/keluar*') ? 'show' : false }}
                            {{ Request::is('v1/bulky/retur/masuk*') ? 'show' : false }}
                            {{ Request::is('v1/bulky/retur/keluar*') ? 'show' : false }}
                            {{ Request::is('v1/bulky/pemesanan/masuk*') ? 'show' : false }}
                        " id="transaksiSubmenu">
                            <li class="{{ Request::is('v1/bulky/pemesanan/masuk*') ? 'active' : false }}">
                                <a href="{{route('bulky.pemesanan.index')}}">Pesanan dari Retail</a>
                            </li>
                            <li class="{{ Request::is('v1/bulky/pemesanan/keluar*') ? 'active' : false }}">
                                <a href="{{route('bulky.pemesanan.keluar.index')}}">Pemesanan ke Pemasok</a>
                            </li>
                            <li class="{{ Request::is('v1/bulky/retur/masuk*') ? 'active' : false }}">
                                <a href="{{route('bulky.retur.masuk.index')}}">Retur dari Retail</a>
                            </li>
                            <li class="{{ Request::is('v1/bulky/retur/keluar*') ? 'active' : false }}">
                                <a href="{{route('bulky.retur.keluar.index')}}">Retur ke Pemasok</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="
                        {{ Request::is('v1/piutangIn*') ? 'active' : false }}
                        {{ Request::is('v1/piutangOut*') ? 'active' : false }}
                    ">
                        <a href="#piutangSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">money_off</i>Piutang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/piutangIn*') ? 'show' : false }}
                            {{ Request::is('v1/piutangOut*') ? 'show' : false }}
                        " id="piutangSubmenu">
                            <li class="{{ Request::is('v1/piutangIn*') ? 'active' : false }}">
                                <a href="{{route('piutangIn.index')}}">Piutang dari Retail</a>
                            </li>
                            <li class="{{ Request::is('v1/piutangOut*') ? 'active' : false }}">
                                <a href="{{route('piutangOut.index')}}">Piutang ke Petani</a>
                            </li>
                        </ul>
                    </li> --}}
                    <li class="
                        {{ Request::is('v1/bulky/rekapitulasi/pembelian*') ? 'active' : false }}
                        {{ Request::is('v1/bulky/rekapitulasi/penjualan*') ? 'active' : false }}
                        {{ Request::is('v1/bulky/laba-rugi*') ? 'active' : false }}
                    ">
                        <a href="#rekapitulasiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">book</i>Rekapitulasi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/bulky/rekapitulasi/pembelian*') ? 'show' : false }}
                            {{ Request::is('v1/bulky/rekapitulasi/penjualan*') ? 'show' : false }}
                            {{ Request::is('v1/bulky/laba-rugi*') ? 'show' : false }}
                        " id="rekapitulasiSubmenu">
                            <li class="{{ Request::is('v1/bulky/rekapitulasi/penjualan*') ? 'active' : false }}">
                                <a href="{{route('bulky.rekap.penjualan.index')}}">Penjualan</a>
                            </li>
                            <li class="{{ Request::is('v1/bulky/rekapitulasi/pembelian*') ? 'active' : false }}">
                                <a href="{{route('bulky.rekap.pembelian.index')}}">Pembelian</a>
                            </li>
                            <li class="{{ Request::is('v1/bulky/laba-rugi*') ? 'active' : false }}">
                                <a href="{{route('bulky.laba-rugi.index')}}">Laba Rugi</a>
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
                        {{ Request::is('v1/barangMasukPelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/barangKeluarPelanggan*') ? 'active' : false }}
                    ">
                        <a href="#manajemensub" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">storage</i>Manajemen Barang</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/barangWarung*') ? 'show' : false }}
                            {{ Request::is('v1/barangMasukPelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/barangKeluarPelanggan*') ? 'show' : false }}
                        " id="manajemensub">
                            <li class="{{ Request::is('v1/barangMasukPelanggan*') ? 'active' : false }}">
                                <a href="{{route('barangMasukPelanggan.index')}}">Manajemen Barang Masuk ke Warung</a>
                            </li>
                            <li class="{{ Request::is('v1/barangWarung*') ? 'active' : false }}">
                                <a href="{{route('barangWarung.index')}}">Barang Yang Dimiliki Warung</a>
                            </li>
                            <li class="{{ Request::is('v1/barangKeluarPelanggan*') ? 'active' : false }}">
                                <a href="{{route('barangKeluarPelanggan.index')}}">Manajemen Barang Keluar ke Pembeli</a>
                            </li>
                        </ul>
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
                                <a href="{{route('pemesananMasukWarung.index')}}">Pesanan dari Pembeli</a>
                            </li>
                            <li class="{{ Request::is('v1/pemesananKeluarWarung*') ? 'active' : false }}">
                                <a href="{{route('pemesananKeluarWarung.index')}}">Pembelian ke Retail</a>
                            </li>
                            <li class="{{ Request::is('v1/returMasukPembeli*') ? 'active' : false }}">
                                <a href="{{route('returMasukPembeli.index')}}">Retur dari Pembeli</a>
                            </li>
                            <li class="{{ Request::is('v1/returKeluarPelanggan*') ? 'active' : false }}">
                                <a href="{{route('returKeluarPelanggan.index')}}">Retur ke Retail</a>
                            </li>
                        </ul>
                    </li>
                    <li class="
                        {{ Request::is('v1/piutangPelanggan*') ? 'active' : false }}
                    ">
                        <a href="{{route('piutangPelanggan.index')}}" class="valign-center"><i class="material-icons">money_off</i>Piutang</a>
                    </li>
                    <li class="
                        {{ Request::is('v1/rekapitulasiPembelianPelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/rekapitulasiPenjualanPelanggan*') ? 'active' : false }}
                        {{ Request::is('v1/labaRugiPelanggan*') ? 'active' : false }}
                    ">
                        <a href="#rekapitulasiSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">book</i>Rekapitulasi</a>
                        <ul class="collapse list-unstyled
                            {{ Request::is('v1/rekapitulasiPembelianPelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/rekapitulasiPenjualanPelanggan*') ? 'show' : false }}
                            {{ Request::is('v1/labaRugiPelanggan*') ? 'show' : false }}
                        " id="rekapitulasiSubmenu">
                            <li class="{{ Request::is('v1/rekapitulasiPenjualanPelanggan*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPenjualanPelanggan.index')}}">Penjualan</a>
                            </li>
                            <li class="{{ Request::is('v1/rekapitulasiPembelianPelanggan*') ? 'active' : false }}">
                                <a href="{{route('rekapitulasiPembelianPelanggan.index')}}">Pembelian</a>
                            </li>
                            <li class="{{ Request::is('v1/labaRugiPelanggan*') ? 'active' : false }}">
                                <a href="{{route('labaRugiPelanggan.index')}}">Laba Rugi</a>
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

                    @if (isset($pengurusGudangBulky))
                        <li class="
                            {{ Request::is('v1/bulky/laporan/pembelian*') ? 'active' : false }}
                            {{ Request::is('v1/bulky/laporan/penjualan*') ? 'active' : false }}
                            {{ Request::is('v1/bulky/laporan/barang*') ? 'active' : false }}
                        ">
                            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">text_snippet</i>Laporan</a>
                            <ul class="collapse list-unstyled
                                {{ Request::is('v1/bulky/laporan/pembelian*') ? 'show' : false }}
                                {{ Request::is('v1/bulky/laporan/penjualan*') ? 'show' : false }}
                                {{ Request::is('v1/bulky/laporan/barang*') ? 'show' : false }}
                            " id="reportSubmenu">
                                <li class="{{ Request::is('v1/bulky/laporan/penjualan*') ? 'active' : false }}">
                                    <a href="{{route('bulky.laporan.barang.keluar.index')}}">Penjualan</a>
                                </li>
                                <li class="{{ Request::is('v1/bulky/laporan/pembelian*') ? 'active' : false }}">
                                    <a href="{{route('bulky.laporan.barang.masuk.index')}}">Pembelian</a>
                                </li>
                                <li class="{{ Request::is('v1/bulky/laporan/barang*') ? 'active' : false }}">
                                    <a href="{{route('bulky.laporan.barang.index')}}">Stok Barang</a>
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
                        {{ Request::is('v1/batasPiutang*') ? 'active' : false }}
                        {{ Request::is('v1/pengaturan-wangpas*') ? 'active' : false }}
                    ">
                        <a href="#colapsePengaturan" data-toggle="collapse" aria-expanded="false" class="valign-center dropdown-toggle"><i class="material-icons">settings</i> Pengaturan</a>
                        <ul id="colapsePengaturan" class="collapse list-unstyled
                            {{ Request::is('v1/setApp*') ? 'show' : false }}
                            {{ Request::is('v1/pengaturanTransaksi*') ? 'show' : false }}
                            {{ Request::is('v1/batasPiutang*') ? 'show' : false }}
                            {{ Request::is('v1/pengaturan-wangpas*') ? 'show' : false }}
                        ">
                            <li class="
                                {{ Request::is('v1/batasPiutang*') ? 'active' : false }}
                            ">
                                <a href="{{route('batasPiutang.index')}}">Piutang</a>
                            </li>
                            <li class="
                            {{ Request::is('v1/setApp*') ? 'active' : false }}
                            ">
                                <a href="{{route('setApp.index')}}">Aplikasi</a>
                            </li>
                            <li class="
                            {{ Request::is('v1/pengaturan-wangpas*') ? 'active' : false }}
                            ">
                                <a href="{{route('pengaturan-wangpas.index')}}">Wangpas</a>
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
