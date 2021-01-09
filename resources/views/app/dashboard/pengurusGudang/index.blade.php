@php
  $icon = 'dashboard';
  $pageTitle = 'Dashboard Pengurus Gudang';
  $dashboard = true;
  // $rightbar = true;
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
            <a href="#" class="text-14">Pengurus Gudang</a>
          </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-primary"></div>
            <div class="card-body pb-2">
                <div class="row">
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-primary">work</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-primary">20 Jenis</div>
                      </div>
                      <div class="col-12">
                        <div class="float-right text-my-subtitle">Barang</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-warning"></div>
            <div class="card-body pb-2">
                <div class="row">
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-warning">house_siding</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-warning">200 </div>
                      </div>
                      <div class="col-12">
                        <div class="float-right text-my-subtitle">Gudang</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-danger"></div>
            <div class="card-body pb-2">
                <div class="row">
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-danger">people</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-danger">2000 Akun</div>
                      </div>
                      <div class="col-12">
                        <div class="float-right text-my-subtitle">Pelanggan</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12  my-2">
        <div class="card shadow">
            <div class="line-strip bg-my-success"></div>
            <div class="card-body pb-2">
                <div class="row">
                  <div class="col-4">
                    <i class="material-icons md-48 text-my-success">extension</i>
                  </div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-12">
                        <div class="float-right text-my-success">100 Orang</div>
                      </div>
                      <div class="col-12">
                        <div class="float-right text-my-subtitle">Pemasok</div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
</script>
@endpush
