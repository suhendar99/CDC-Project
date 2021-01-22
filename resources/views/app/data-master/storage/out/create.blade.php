@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Storage Keluar';
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
            <a href="#" class="text-14">Data Master</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Storage Keluar</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Buat Data</a>
          </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
        @include('layouts.dashboard.search')
    </div> --}}
</div>
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                {{-- <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a href="#pills-home" class="nav-link active" id="pills-home-tab" data-toggle="pill" role="tab" aria-controls="pills-home" aria-selected="true" onclick="cleanBtn()">Kwitansi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pills-second" class="nav-link" id="pills-second-tab" data-toggle="pill" role="tab" aria-controls="pills-second" aria-selected="false" onclick="storageIn()">Surat Jalan</a>
                                    </li>
                                </ul> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('storage.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{route('storage.out.store')}}" method="post" enctype="multipart/form-data" id="form-tag">
                    @csrf
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- One "tab" for each step in the form: -->
                                <div class="tab">Pilih Pemesanan:
                                    <div class="form-group">
                                        <label>Pemesanan <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectSatuan" class="form-control @error('pemesanan_id') is-invalid @enderror" name="pemesanan_id" placeholder="Enter pemesanan_id">
                                            <option value="">--Pilih Pesanan--</option>
                                            @foreach($pemesanan as $pesan)
                                            <option value="{{ $pesan->id }}">Pemesan: {{ $pesan->nama_pemesan }} | Kode: {{ $pesan->kode }}</option>
                                            @endforeach
                                        </select>
                                        @error('pemesanan_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="tab">Kwitansi
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>DIbayar oleh <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('terima_dari') is-invalid @enderror" name="terima_dari" value="{{ old('terima_dari') }}" placeholder="Enter terima_dari barang">
                                            @error('terima_dari')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Jumlah Uang <small class="text-success">*Harus diisi</small></label>
                                            <input type="number" class="form-control @error('jumlah_uang_digits') is-invalid @enderror" name="jumlah_uang_digits" value="{{ old('jumlah_uang_digits') }}" placeholder="Enter jumlah_uang_digits barang" id="number">
                                            @error('jumlah_uang_digits')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="jumlah_uang_word" id="word">
                                    </div>
                                    <div class="form-group">
                                        <label>Tempat Pembuatan Kwitansi <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" value="{{ old('tempat') }}" placeholder="Enter tempat">
                                        @error('tempat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
 
                                <div class="tab">Surat Jalan:
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Pengirim <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim" value="{{ old('pengirim') }}" placeholder="Enter pengirim">
                                            @error('pengirim')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Penerima <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" class="form-control @error('penerima') is-invalid @enderror" name="penerima" value="{{ old('penerima') }}" placeholder="Enter penerima">
                                            @error('penerima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
 
                                <div class="tab">Storage Out:
                                    <div class="form-group">
                                        <label>Gudang <small class="text-success">*Harus diisi</small></label>
                                        <select name="gudang_id" id="gudang" class="form-control">
                                            <option value="">--Pilih Gudang--</option>
                                            @foreach ($gudang as $list)
                                                <option value="{{$list->id}}" {{ old('gudang_id') == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('gudang_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div style="overflow:auto;">
                                  <div  style="float:right;">
                                    <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-danger btn-sm">Previous</button>
                                    {{-- <div id="btn-colect"> --}}
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary btn-sm">Next</button>
                                    {{-- </div> --}}
                                  </div>
                                </div>
 
                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                  <span class="step"></span>
                                  <span class="step"></span>
                                  <span class="step"></span>
                                  <span class="step"></span>
                                </div>
                            </div>
                            {{-- <div class="col-md-12 col-sm-6">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>DIbayar oleh <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('terima_dari') is-invalid @enderror" name="terima_dari" value="{{ old('terima_dari') }}" placeholder="Enter terima_dari barang">
                                                @error('terima_dari')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Jumlah Uang <small class="text-success">*Harus diisi</small></label>
                                                <input type="number" class="form-control @error('jumlah_uang_digits') is-invalid @enderror" name="jumlah_uang_digits" value="{{ old('jumlah_uang_digits') }}" placeholder="Enter jumlah_uang_digits barang" id="number">
                                                @error('jumlah_uang_digits')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="jumlah_uang_word" id="word">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Pemesanan <small class="text-success">*Harus diisi</small></label>
                                                <select id="selectSatuan" class="form-control @error('pemesanan_id') is-invalid @enderror" name="pemesanan_id" placeholder="Enter pemesanan_id">
                                                    @foreach($pemesanan as $pesan)
                                                    <option value="{{ $pesan->id }}">Pemesan: {{ $pesan->nama_pemesan }} | Kode: {{ $pesan->kode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('pemesanan_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tempat Pembuatan Kwitansi <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" value="{{ old('tempat') }}" placeholder="Enter tempat">
                                                @error('tempat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan <small class="text-success">*Harus diisi</small></label>
                                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                            @error('keterangan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Pengirim <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim" value="{{ old('pengirim') }}" placeholder="Enter pengirim">
                                                @error('pengirim')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Penerima <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('penerima') is-invalid @enderror" name="penerima" value="{{ old('penerima') }}" placeholder="Enter penerima">
                                                @error('penerima')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label>Gudang <small class="text-success">*Harus diisi</small></label>
                                        <select name="gudang_id" id="gudang" class="form-control">
                                            <option value="">--Pilih Gudang--</option>
                                            @foreach ($gudang as $list)
                                                <option value="{{$list->id}}" {{ old('gudang_id') == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('gudang_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                            <select name="barang_kode" id="barang" class="form-control">
                                                <option value="">-Pilih Barang-</option>
                                            </select>
                                            @error('barang_kode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Enter jumlah barang">
                                            @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                            <select id="selectSatuan" class="form-control @error('satuan') is-invalid @enderror" name="satuan" placeholder="Enter satuan">
                                                <option value="kg">kg</option>
                                                <option value="ons">ons</option>
                                                <option value="gram">gram</option>
                                                <option value="ml">ml</option>
                                                <option value="m3">m<sup>3</sup></option>
                                                <option value="m2">m<sup>2</sup></option>
                                                <option value="m">m</option>
                                                <option value="gram">cm</option>
                                            </select>
                                            @error('satuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                      
                            </div> --}}
                        </div>
                        {{-- <div class="row">
                              <div class="col-md-12">
                                <div class="float-right" id="btn-action">
                                    <button type="button" class="btn btn-primary" onclick="nextOne()">Next</button>
                                </div>
                              </div>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/onscan.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab
function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Create";
    $('#nextBtn').attr('onclick', 'submitForm()');
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
    $('#nextBtn').attr('type', 'button');
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}
function submitForm() {
    document.getElementById("form-tag").submit();
}
function nextPrev(n) {
    // console.log(n);
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  console.log(currentTab);
  if (currentTab >= x.length) {
    //...the form gets submitted:
    // $("#nextBtn").attr('onclick','submitForm()');
    // $("#nextBtn").attr('id','btn-beli');
    // $('#btn-beli').attr('type','submit');
    // $('#nextBtn').html(`<button type="submit" id="btn-beli" class="btn btn-primary btn-sm">Beli</button>`)
    // document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}
function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}
function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>
<script>
    onScan.attachTo(document, {
        suffixKeyCodes: [13],
        reactToPaste: true,
        onScan: function(sCode, qty){
            console.log(sCode)
            $('#scanBarang').val(sCode)
            $.ajax({
                url: "/api/v1/storage/barang/"+sCode,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $('#barangStatus').empty();
                    $('#barangStatus').append('Barang ditemukan <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>')
                    $('#card-table').remove();
                    $('#card-form').after(`<div class="card card-block d-flex" id="card-table">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Kode Barang</td>
                                            <td id="kodeBarang">${response.data.kode_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td id="nama">${response.data.nama_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Kategori Barang</td>
                                            <td id="kategori">${response.data.kategori.nama}</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Barang</td>
                                            <td id="harga">${response.data.harga_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemasok Barang</td>
                                            <td id="pemasok">${response.data.pemasok.nama}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`)
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                    $('#barangStatus').empty();
                    $('#card-table').remove();
                    $('#barangStatus').append('Barang tidak ditemukan! <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>');
                }
            });
        }
        // onKeyDetect: function(key){
        //     console.log(key)
        // }
    });

    var a = ['','satu ','dua ','tiga ','empat ', 'lima ','enam ','tujuh ','delapan ','sembilan ','sepuluh ','sebelas ','dua belas ','tiga belas ','empat belas ','lima belas ','enam belas ','tujuh belas ','delapan belas ','sembilan belas '];
    var b = ['', '', 'dua puluh','tiga puluh','empat puluh','lima puluh', 'enam puluh','tujuh puluh','delapan puluh','sembilan puluh'];
    var c = ['', 'dua ratus', 'tiga ratus', 'empat ratus', 'lima ratus', 'enam ratus', 'tujuh ratus', 'delapan ratus', 'sembilan ratus'];

    function inWords (num) {
        if ((num = num.toString()).length > 8) return 'overflow';
        n = ('00000000' + num).substr(-8).match(/^(\d{2})(\d{1})(\d{2})(\d{1})(\d{2})$/);
        console.log(n);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (c[Number(n[2])] + ' ' + a[n[2][1]]) + 'ribu ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'ribu ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'ratus ' : '';
        str += (n[5] != 0) ? ((str != '') ? ' ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        console.log(str);
        return str;
    }

    document.getElementById('number').onkeyup = function () {
        // document.getElementById('word').innerHTML = inWords(document.getElementById('number').value);
        $('#word').val(inWords(document.getElementById('number').value))
    };

    // $('#gudang').change(function(event) {
    //     /* Act on the event */
    //     let id = $('#gudang').val();
    //     let array = [];
    //     $('#barang').html(`<option value="">--Pilih Barang--</option>`);

    //     $.ajax({
    //             url: "/api/v1/storage/out/gudang/"+id+"/barang",
    //             method: "GET",
    //             contentType: false,
    //             cache: false,
    //             processData: false,
    //             success: (response)=>{
    //                 console.log(response.data)

    //                 for (var i = response.data.length - 1; i >= 0; i--) {
                        
    //                     for (var j = response.data[i].storage_in.length - 1; j >= 0; j--) {
    //                         array.push(response.data[i].storage_in[j].storage.jumlah);
    //                     }
    //                     let jumlah = array.reduce((a, b) => a+b);

    //                     $('#barang').append(`
    //                         <option value="${response.data[i].kode_barang}">Nama: ${response.data[i].nama_barang} | Jumlah: ${jumlah} ${response.data[i].storage_in[0].storage.satuan}</option>
    //                     `)
    //                 }
    //             },
    //             error: (xhr)=>{
    //                 let res = xhr.responseJSON;
    //                 console.log(res)
    //                 console.log('error')
    //             }
    //         });
    // });

    $(document).ready(function() {
        $('#scanBarang').keyup(function(event) {
            /* Act on the event */
            let kode = $(this).val()

            $.ajax({
                url: "/api/v1/storage/barang/"+kode,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: (response)=>{
                    console.log(response.data)
                    $('#barangStatus').empty();
                    $('#barangStatus').append('Barang ditemukan <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>')
                    $('#card-table').remove();
                    $('#card-form').after(`<div class="card card-block d-flex">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Kode Barang</td>
                                            <td id="kodeBarang">${response.data.kode_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td id="nama">${response.data.nama_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Kategori Barang</td>
                                            <td id="kategori">${response.data.kategori.nama}</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Barang</td>
                                            <td id="harga">${response.data.harga_barang}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemasok Barang</td>
                                            <td id="pemasok">${response.data.pemasok.nama}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`)
                },
                error: (xhr)=>{
                    let res = xhr.responseJSON;
                    console.log(res)
                    console.log('error')
                    $('#barangStatus').empty();
                    $('#card-table').remove();
                    $('#barangStatus').append('Barang tidak ditemukan! <a href="{{ route('barang.create') }}" title="Create Barang" class="text-primary">Tambah Barang</a>');
                }
            });
        });
    });

    function storageIn() {
        $('#btn-action').html(`<button type="submit" class="btn btn-success btn-sm">Simpan</button>`);
    }

    function nextOne(){
        $('#pills-tab a[href="#pills-second"]').tab('show');
    }

    function cleanBtn() {
        $('#btn-action').html(`<button type="button" class="btn btn-primary" onclick="nextOne()">Next</button>`);
    }
</script>
@endpush