@php
        $icon = 'storage';
        $pageTitle = 'Penawaran';
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="row valign-center mb-2">
    <div class="col-md-8 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Penawaran</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <form action="{{route('penawaran-pemasok.index')}}" method="get" style="width: 100%;">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class=" form-control" placeholder=" Cari gudang ..." aria-label="Cari gudang bulky..." aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-secondary">search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('riwayat')}}" class="btn btn-primary">Lihat Penawaran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @if(count($gudangs) > 0)
                @foreach($gudangs as $gudang)
                <div class="col-4">
                    <div class="card">
                        <img src="{{ ($gudang->foto != null) ? asset($gudang->foto) : asset('images/gudang-bulky.jpg')}}" alt="Card Image" class="card-img-top" style="height: 150px;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5>{{ $gudang->nama }}</h5>
                                    <span style="font-size: .7rem;">{{ $gudang->nomor_gudang }}</span>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Alamat: {{ $gudang->alamat }},  Desa {{ $gudang->desa->nama }} Kec {{ $gudang->desa->kecamatan->nama }} {{ $gudang->desa->kecamatan->kabupaten->nama }}</li>
                            <li class="list-group-item">Hari Kerja: {{ $gudang->hari }}</li>
                            <li class="list-group-item" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);"> Jam Kerja: {{ $gudang->jam_buka }} - {{ $gudang->jam_tutup }} WIB</li>
                        </ul>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{route('penawaran-pemasok.edit',$gudang->id)}}" class="btn btn-primary btn-block btn-sm">Tawarkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="footer-copyright text-center pt-4 text-dark fixed">
                        ~ Tidak Ada Data Gudang ~
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            {{ $gudangs->links() }}
        </div>
    </div>
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">

</script>
{{--  --}}
@endpush
