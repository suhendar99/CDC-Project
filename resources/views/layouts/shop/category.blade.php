
<div id="category">
    <div class="row">
        @forelse($category as $c)
        <div class="col-6 pl-2 pr-2 pb-4">
            <div class="card" style="height: auto;">
                <div class="card-body d-flex justify-content-center">
                    <a href="{{route('cari.kategori',$c->id)}}"></a>
                    <center>
                            {{-- <i class="material-icons text-my-warning md-48"></i><br> --}}
                            <img src="{{ ($c->icon != null) ? asset($c->icon) : 'images/logo/Logo-CDC.svg'}}" height="100px" width="100px" onerror="this.src='/images/logo/Logo-CDC.svg'; this.style='object-fit: scale-down;opacity: 0.5;'" style="object-fit: scale-down;">
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
