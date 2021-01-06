@php
        $pageTitle = 'Dashboard Petani';
        $data = [1,2,3,4,6,1,1,1,1,1,1,1,2,1,1,1,1];
        $dashboard = true;
        $pemasok = true;
@endphp
@extends('layouts.dashboard.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Waiting for Approval</div>

                <div class="card-body">
                    Your account is waiting for our administrator approval.
                    <br />
                    Please check back later.
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
