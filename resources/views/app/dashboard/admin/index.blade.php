@php
        $pageTitle = 'Dashboard Admin';
        $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
        $dashboard = true;
        $admin = true;
        // $rightbar = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
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
