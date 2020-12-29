<nav id="sidebar">
    <div class="sidebar-content shadow">
        <div class="sidebar-header">
            <center>
                <img src="{{asset('images/logo-cdc.png')}}" class="rounded-circle mx-auto d-block avatar my-3">
                <span class="text-white avatar-text">{{ Auth::user()->name }}</span>
            </center>
        </div>
        <ul class="list-unstyled components">
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