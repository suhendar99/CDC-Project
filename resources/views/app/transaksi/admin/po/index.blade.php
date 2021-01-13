@php
    $icon = 'receipt_long';
    $pageTitle = 'Data Purchase Order';
@endphp

@extends('layouts.dashboard.header')

@section('content')
{{-- {{dd($pemasok)}} --}}
{{-- {{dd('Pemasok = '.$pemasok)}} --}}
<div class="row valign-center mb-2">
    <div class="col-md-12 col-sm-12 valign-center py-2">
        <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
        <div>
          <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
          <div class="valign-center breadcumb">
            <a href="#" class="text-14">Dashboard</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">{{$pageTitle}}</a>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-right">
                                <a href="{{route('po.create')}}" class="btn btn-primary btn-sm">Tambah PO</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @foreach($data as $d)
                <div class="col-md-6 col-6 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 border-right">
                                    Dari : <span class="pl-2">{{$d->pengirim_po}}</span>
                                </div>
                                <div class="col-md-6">
                                    Ke : <span class="pl-2">{{$d->penerima_po}}</span>
                                </div>
                                <div class="col-md-6 border-right">
                                    Email : <span class="pl-2">{{$d->email_pengirim}}</span>
                                </div>
                                <div class="col-md-6">
                                    Email : <span class="pl-2">{{$d->email_penerima}}</span>
                                </div>
                                <div class="col-md-12"> 
                                    <hr class=" my-1">
                                    <span class=" text-18">Data Barang PO</span><br>
                                    @foreach($d->po_item as $i)
                                    <span>{{$i->nama_barang}} ({{$i->jumlah.' '.$i->satuan}})</span>,
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
</script>
@endpush
