@php
        $icon = 'text_snippet';
        $pageTitle = 'Laporan Stok Barang';
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
            <a href="#" class="text-14">Stok Barang</a></div>
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
                            <form action="{{route('laporan.stok.pdf')}}" target="__blank" id="actionLaporan" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row" id="fill">
                                    <div class="col-md-12">
                                        <h6 class="ml-3">Pilih Laporan Berdasarkan :</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row ml-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="filterBulan">
                                                    <label class="custom-control-label mr-2" for="filterBulan">Bulan</label>
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="filterTanggal">
                                                    <label class="custom-control-label" for="filterTanggal">Tanggal</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="bulan" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="col-md-12">Bulan <small class="text-success">*Harus dipilih</small></label>
                                                <select name="month" id="" class="form-control col-md-12" style="width: 100% !important;">
                                                    <option value="">-- Pilih Bulan--</option>
                                                    <option value="1">Januari</option>
                                                    <option value="2">Februari</option>
                                                    <option value="3">Maret</option>
                                                    <option value="4">April</option>
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                                    <option value="8">Agustus</option>
                                                    <option value="9">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                                @error('month')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="tanggal" style="display: none;">
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
                                <div class="col-md-12" id="checkbox" style="display: none;">
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
                                <div class="row" id="button" style="display: none;">
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
            actionForm.action = "{{ route('laporan.stok.pdf') }}";
        });
        excel.addEventListener('click', e=>{
            if(pdf.checked == true){
                pdf.checked = false;
            }
            actionForm.action = "{{ route('laporan.stok.excel') }}";
        });
    }
    formExcel();

    const Filter = ()=>{
        const bulan = document.querySelector("#filterBulan");
        const tanggal = document.querySelector("#filterTanggal");
        $('#fill').show();
        bulan.addEventListener('click', e=>{
            if(tanggal.checked == true){
                tanggal.checked = false;
            }
            if (bulan.checked == true) {
                $('#bulan').fadeIn();
                $('#button').fadeIn();
                $('#tanggal').css('display','none');
                $('#fill').css('display','none');
                $('#checkbox').fadeIn();
            }
        });
        tanggal.addEventListener('click', e=>{
            if(bulan.checked == true){
                bulan.checked = false;
            }
            if (tanggal.checked == true) {
                $('#bulan').css('display','none');
                $('#fill').css('display','none');
                $('#tanggal').fadeIn();
                $('#button').fadeIn();
                $('#checkbox').fadeIn();
            }
        });
    }
    Filter();
</script>
{{--  --}}
@endpush
