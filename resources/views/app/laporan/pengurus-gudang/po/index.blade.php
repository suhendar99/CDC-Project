@php
        $icon = 'text_snippet';
        $pageTitle = 'Laporan Purcase Order';
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
            <a href="#" class="text-14">laporan</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Purcase Order</a></div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5></h5>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('laporan.po.pdf')}}" target="__blank" id="actionLaporan" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Tanggal Awal <small class="text-success">*Harus diisi</small></label>
                                                <input type="date" class="form-control @error('awal') is-invalid @enderror" name="awal" value="{{ old('awal') }}">
                                                @error('awal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Tanggal Akhir <small class="text-success">*Harus diisi</small></label>
                                                <input type="date" class="form-control @error('akhir') is-invalid @enderror" name="akhir" value="{{ old('akhir') }}">
                                                @error('akhir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="exportPdf">
                                            <label class="custom-control-label" for="exportPdf">PDF</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="exportExcel">
                                            <label class="custom-control-label" for="exportExcel">Excel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-download"></i> Buat Laporan</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
{{-- Chart Section --}}
<script type="text/javascript">
    const formExcel = ()=>{
        const pdf = document.querySelector("#exportPdf");
        const excel = document.querySelector("#exportExcel");
        const actionForm = document.querySelector("#actionLaporan");
        pdf.checked = true;
        pdf.addEventListener('click', e=>{
            if(excel.checked == true){
                excel.checked = false;
            }
            actionForm.action = "{{ route('laporan.po.pdf') }}";
        });
        excel.addEventListener('click', e=>{
            if(pdf.checked == true){
                pdf.checked = false;
            }
            actionForm.action = "{{ route('laporan.po.excel') }}";
        });
    }
    formExcel();
</script>
{{--  --}}
@endpush