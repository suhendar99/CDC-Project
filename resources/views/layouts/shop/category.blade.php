<div id="category">
    <div class="row">
        @forelse($category as $c)
        <div class="col-6 pl-2 pr-2 pb-4">
            <div class="card" style="height: auto;">
                <a href=""></a>
                <div class="card-body d-flex justify-content-center">
                    <center>
                            <i class="material-icons text-my-warning md-48">{{$c['icon']}}</i><br>
                            <span>{{$c['nama']}}</span>
                    </center>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 pl-2 pr-2 pb-4">
            <p class="not-found text-center">Tidak Ada Kategori</p>
        </div>
        @endforelse
    </div>
</div>
