<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-sm bg-my-primary">
            <i class="material-icons md-24">format_align_left</i>
        </button>
        @if(isset($admin) || isset($pemasok) || isset($karyawan))
        <button type="button" id="rightbarCollapse" class="btn btn-sm bg-my-warning d-inline-block ml-auto">
            <i class="material-icons md-24">format_align_right</i>
        </button>                   
        @endif 
    </div>
</nav>
