@php
  $icon = 'dashboard';
  $pageTitle = 'Dashboard Pelanggan';
  $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
  $dashboard = true;
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
            <a href="#" class="text-14">Pelanggan</a>
          </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">

</script>
@endpush
