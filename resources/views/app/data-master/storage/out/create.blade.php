@php
        $icon = 'storage';
        $pageTitle = 'Buat Data Barang Keluar';
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
            <a href="#" class="text-14">Data Gudang</a>
            <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
            <a href="#" class="text-14">Data Barang Keluar</a>
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
                        <div class="col-md-10">
                            <div class="float-left">
                                <h5 class="card-title" id="text-ket">
                                    Pilih Pemesanan Untuk Barang Keluar
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-2">
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
                                <div class="tab" data-keterangan="Pilih Pemesanan Untuk Barang Keluar">
                                    <div class="form-group">
                                        <label>Pemesanan <small class="text-success">*Harus diisi</small></label>
                                        <select id="selectSatuan" class="form-control @error('pemesanan_id') is-invalid @enderror" name="pemesanan_id" placeholder="Enter pemesanan_id">
                                            <option value="">--Pilih Pesanan--</option>
                                            @foreach($pemesanan as $pesan)
                                            <option value="{{ $pesan->id }}" data-kode="{{ $pesan->nomor_pemesanan }}" @if($poci != null && $pesan->id == $poci) selected @endif>Pemesan: {{ $pesan->nama_pemesan }} | Kode: {{ $pesan->nomor_pemesanan }}</option>
                                            @endforeach
                                        </select>
                                        @error('pemesanan_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="tab" data-keterangan="Isi form untuk kwitansi pemesanan">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Dibayar oleh <small class="text-success">*Harus diisi</small></label>
                                            <input type="text" id="dibayar_oleh" class="form-control @error('terima_dari') is-invalid @enderror" name="terima_dari" value="{{ old('terima_dari') }}" placeholder="Masukan pembayar...">
                                            @error('terima_dari')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Jumlah Uang <small class="text-success">*Harus diisi</small></label>
                                            <input type="number" id="jumlah_uang" class="form-control @error('jumlah_uang_digits') is-invalid @enderror" name="jumlah_uang_digits" value="{{ old('jumlah_uang_digits') }}" placeholder="Masukan jumlah uang yang dibayar...">
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
                                        <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" value="{{ old('tempat') }}" placeholder="Masukan nama tempat...">
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

                                <div class="tab" data-keterangan="Isi Kelengkapan Surat Jalan untuk Pemesanan">
                                    {{-- <div class="form-row">
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
                                    </div> --}}
                                    <div class="form-group">
                                        <label>No Surat Jalan <small class="text-success">*Harus diisi</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    {{ $kode_surat }}/SJ/
                                                </span>
                                            </div>
                                            <input class="form-control @error('profil_lembaga') is-invalid @enderror" type="text" placeholder="Nama profil lembaga... (Maks. 6 karakter)" name="profil_lembaga"></input>
                                            <input class="form-control @error('tanggal_surat') is-invalid @enderror" type="date" placeholder="Tanggal..." name="tanggal_surat"></input>
                                        </div>
                                        @error('profil_lembaga')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('tanggal_surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="tab" data-keterangan="Pilih Gudang Retail">
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
                                </div> --}}
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
                                  {{-- <span class="step"></span> --}}
                                </div>
                            </div>
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
  $('#text-ket').html($('.tab').get(n).attributes[0].value)
  // console.log($('#text-ket').get(0).innerHTML = $('.tab').get(n).attributes[0].value)
  // console.log($('.tab').get(n).attributes[0].value);
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

  if (n == -1){
    $("#nextBtn").attr('onclick','nextPrev(1)');
  }
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  alert(currentTab);
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
  let z = x[currentTab].getElementsByTagName("select");

  if (z.length > 0) {
    for (let j = 0; j < z.length; j++) {
        // If a field is empty...
        if (z[j].value === "") {
          // add an "invalid" class to the field:
          // z[j].className += "";
          alert("Mohon pilih data terlebih dahulu.");
          // and set the current valid status to false:
          valid = false;
        }
    }
  }

  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value === "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }

    console.log(y);
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
    $('#selectSatuan').change(function(event) {
        /* Act on the event */
        let kode = $('#selectSatuan option:selected').data("kode")
        let idPesanan = $('#selectSatuan').val()
        for (var i = $('.tab').length - 1; i >= 1; i--) {

            let keterangan = $('.tab').get(i).attributes[0].value+' '+kode;
            $('.tab').get(i).attributes[0].value = keterangan
        }

        $.ajax({
            url: "/api/v1/getPesanan/"+idPesanan,
        }).done(function(response) {
            console.log(response);
            $('#dibayar_oleh').val(response.data.nama_pemesan);
            $('#jumlah_uang').val(response.harga);
            $('#word').val(inWords(response.harga));
        });
    });
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

    var a = ['','Satu ','Dua ','Tiga ','Empat ', 'Lima ','Enam ','Tujuh ','Delapan ','Sembilan ','Sepuluh ','Sebelas ','Dua Belas ','Tiga Belas ','Empat Belas ','Lima Belas ','Enam Belas ','Tujuh Belas ','Delapan Belas ','Sembilan Belas '];
    var b = ['', '', 'Dua Puluh','Tiga Puluh','Empat Puluh','Lima Puluh', 'Enam Puluh','Tujuh Puluh','Delapan Puluh','Sembilan Puluh'];
    var c = ['', '', 'Dua Ratus', 'Tiga Ratus', 'Empat Ratus', 'Lima Ratus', 'Enam Ratus', 'Tujuh Ratus', 'Delapan Ratus', 'Sembilan Ratus'];

    function inWords (num) {
        if ((num = num.toString()).length > 10) return 'overflow';
        n = ('000000000' + num).substr(-10).match(/^(\d{1})(\d{3})(\d{3})(\d{1})(\d{2})$/);
        console.log(n);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Miliar ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || c[n[2][0]] + ' ' + b[n[2][1]] + ' ' + a[n[2][2]]) + 'Juta ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || c[n[3][0]] + ' ' + b[n[3][1]] + ' ' + a[n[3][2]]) + 'Ribu ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Ratus ' : '';
        str += (n[5] != 0) ? ((str != '') ? ' ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        console.log(str);
        return str;
    }

    document.getElementById('jumlah_uang').onkeyup = function () {
        // document.getElementById('word').innerHTML = inWords(document.getElementById('jumlah_uang').value);
        $('#word').val(inWords(document.getElementById('jumlah_uang').value))
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
