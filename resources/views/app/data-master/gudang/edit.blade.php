@php
        $icon = 'storage';
        $pageTitle = 'Edit Data Gudang';
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
            <a href="#" class="text-14">Edit Data Gudang</a>
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
            <div class="card card-block d-flex">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('gudang.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="col-md-12 col-12">
                                {{-- <h5>Location</h5> --}}
                                <div style="width: 100%; height: 300px;" id="map"></div>
                                {{-- <small>*) Seret pin untuk mengisi latitude & longitude</small> --}}
                                <small>*) Drag & Drop Pin to set latitude & longitude</small>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-block" onclick="getLocation()">Lokasi Saya</button>
                                    <small>*) Klik untuk mendapatkan lokasi anda saat ini</small>
                                </div>
                            </div>
                            <form action="{{route('gudang.update',$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Latitude <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" id="latitude" class="form-control @error('lat') is-invalid @enderror" name="lat" value="{{ $data->lat }}" placeholder="Masukan Latitude / Garis Lintang">
                                                @error('lat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Longitude <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" id="longitude" class="form-control @error('long') is-invalid @enderror" name="long" value="{{ $data->long }}" placeholder="Masukan Longitude / Garis Bujur">
                                                @error('long')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="provinsi-select">Provinsi</label>
                                                <select class="form-control @error('provinsi_id') is-invalid @enderror" id="provinsi-select" name="provinsi_id">
                                                    <option value="">-- Pilih Disini --</option>
                                                    @foreach($provinsi as $p)
                                                    <option value="{{$p->id}}" @if($p->id == $data->desa->kecamatan->kabupaten->provinsi_id) selected @endif>{{$p->nama}}</option>
                                                    @endforeach
                                                </select>
                                                @error('provinsi_id')
                                                <div class="invalid-feedback">
                                                    <i class="bx bx-radio-circle"></i>
                                                    {{{$message}}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="kabupaten-select">Kabupaten</label>
                                                <select class="form-control @error('kabupaten_id') is-invalid @enderror" id="kabupaten-select" name="kabupaten_id">
                                                    <option value="">-- Pilih Disini --</option>
                                                    <option value="{{ $data->desa->kecamatan->kabupaten_id }}" selected>{{ $data->desa->kecamatan->kabupaten->nama }}</option>}
                                                </select>
                                                @error('kabupaten_id')
                                                <div class="invalid-feedback">
                                                    <i class="bx bx-radio-circle"></i>
                                                    {{{$message}}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="kecamatan-select">Kecamatan</label>
                                                <select class="form-control @error('kecamatan_id') is-invalid @enderror" id="kecamatan-select" name="kecamatan_id">
                                                    <option value="">-- Pilih Disini --</option>
                                                    <option value="{{ $data->desa->kecamatan_id }}" selected>{{ $data->desa->kecamatan->nama }}</option>}
                                                </select>
                                                @error('kecamatan_id')
                                                <div class="invalid-feedback">
                                                    <i class="bx bx-radio-circle"></i>
                                                    {{{$message}}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="desa-select">Desa</label>
                                                <select class="form-control @error('desa_id') is-invalid @enderror" id="desa-select" name="desa_id">
                                                    <option value="">-- Pilih Disini --</option>
                                                    <option value="{{ $data->desa_id }}" selected>{{ $data->desa->nama }}</option>}
                                                </select>
                                                @error('desa_id')
                                                <div class="invalid-feedback">
                                                    <i class="bx bx-radio-circle"></i>
                                                    {{{$message}}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Nama Gudang <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $data->nama }}" placeholder="Masukan Nama Gudang">
                                                @error('nama')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Kontak <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('kontak') is-invalid @enderror" name="kontak" value="{{ $data->kontak }}" placeholder="Masukan kontak Gudang">
                                                @error('kontak')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Foto <small class="text-success">*Boleh tidak  diisi</small></label>
                                                <input type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror" name="foto" value="{{ $data->foto }}" placeholder="Masukan Foto Gudang">
                                                @error('foto')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hari Kerja <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" class="form-control @error('hari') is-invalid @enderror" name="hari" value="{{ $data->hari }}" placeholder="Masukan Hari Kerja">
                                                @error('hari')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Jam Buka <small class="text-success">*Harus diisi</small></label>
                                                <input type="time" class="form-control @error('jam_buka') is-invalid @enderror" name="jam_buka" value="{{ $data->jam_buka }}" placeholder="Masukan Jam Buka">
                                                @error('jam_buka')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Jam Tutup <small class="text-success">*Harus diisi</small></label>
                                                <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror" name="jam_tutup" value="{{ $data->jam_tutup }}" placeholder="Masukan Jam Tutup">
                                                @error('jam_tutup')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Kapasitas Luas Gudang (&#13217;)<small class="text-success">*Harus diisi</small></label>
                                                <input type="number" min="1" class="form-control @error('kapasitas_meter') is-invalid @enderror" name="kapasitas_meter" value="{{ $data->kapasitas_meter }}" placeholder="Masukan Luas gudang">
                                                @error('kapasitas_meter')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="font-size: 11px;">Kapasitas Berat Gudang (Ton)<small class="text-success">*Harus diisi</small></label>
                                                <input type="numeric" min="1" class="form-control @error('kapasitas_berat') is-invalid @enderror" name="kapasitas_berat" value="{{ $data->kapasitas_berat }}" placeholder="Masukan Kapasitas Barang Di Gudang">
                                                @error('kapasitas_berat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Nama Pemilik Gudang <small class="text-success">*Harus diisi</small></label>
                                                <input type="text" min="1" class="form-control @error('pemilik') is-invalid @enderror" name="pemilik" value="{{ $data->pemilik }}" placeholder="Masukan Nama Pemilik Gudang">
                                                @error('pemilik')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat <small class="text-success">*Harus diisi</small></label>
                                    <textarea name="alamat" id="" cols="30" rows="10" class="form-control @error('alamat') is-invalid @enderror">{{$data->alamat}}</textarea>
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
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
    var mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
    var satelite   = L.tileLayer(mbUrl, {id: 'mapbox/satellite-v9', tileSize: 512, zoomOffset: -1}),
        streets  = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1});

        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="">Badan Perencanaan Pembangunan Daerah Kabupaten Bekasi</a>',
                        maxZoom:20, }),
    gstreet     = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        attribution: 'Google',
                        maxZoom: 20, }),
    gterrain    = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, }),
    gsatelite   = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, }),
    ghybrid     = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20, });
    var baseLayers = {
        "OSM": osm,
        "Google Street"     : gstreet,
        "Google Terrain"    : gterrain,
        "Google Satelite"   : gsatelite,
        "Google Hybrid"     : ghybrid
    };
    var latitudeNow = '{{$data->lat}}'
    var longitudeNow = '{{$data->long}}'
    var map = L.map('map', {
            center: [latitudeNow, longitudeNow],
            zoom: 10,
            layers: [ghybrid]
    });
    var marker = L.marker([latitudeNow, longitudeNow],{
      draggable: true
    }).addTo(map);
    L.control.layers(baseLayers).addTo(map);
    var geocodeService = L.esri.Geocoding.geocodeService();
    marker.on('dragend', function (e) {
      document.getElementById('latitude').value = marker.getLatLng().lat;
      document.getElementById('longitude').value = marker.getLatLng().lng;

        geocodeService.reverse().latlng(e.target._latlng).run(function (error, result) {
              if (error) {
                return;
              }

              // console.log(result)

              let geo = "";
              let kecamatan = "";
              let kabupaten = "";
              let provinsi = "";

              if (result.address.District !== "") {
                // console.log('kecamatan='+result.address.District)
                kecamatan = 'kecamatan='+result.address.District;
                geo = geo + "?" + kecamatan;
              }

              if (result.address.Subregion !== "") {
                // console.log('kabupaten='+result.address.Subregion)
                kabupaten = 'kabupaten='+result.address.Subregion;
                if (geo !== "") {
                    geo = geo + "&" + kabupaten;
                }else{
                    geo = geo + "?" + kabupaten;
                }
              }

              if (result.address.Region !== "") {
                // console.log('provinsi='+result.address.Region)
                provinsi = 'provinsi='+result.address.Region;
                if (geo !== "") {
                    geo = geo + "&" + provinsi;
                }else{
                    geo = geo + "?" + provinsi;
                }
              }

              $.ajax({
                  url: '/api/v1/geocode'+geo,
                  type: 'GET',
                  cache: false,
                  dataType: 'json',
                  success: function(response) {
                    // alert(json.data);
                    console.log(response);
                    if (typeof response.kecamatan !== 'undefined') {
                        $('#kecamatan-select').html('');
                        $('#kecamatan-select').append($('<option>').text(response.kecamatan.nama).attr({
                            value: response.kecamatan.id,
                            selected: 'selected'
                        }));
                        $('#kabupaten-select').html('')
                        $('#kabupaten-select').append($('<option>').text(response.kecamatan.kabupaten.nama).attr({
                            value: response.kecamatan.kabupaten.id,
                            selected: 'selected'
                        }));
                        $.each($('#provinsi-select option'), function(index, val) {
                             /* iterate through array or object */
                             if ($(this).val() == response.kecamatan.kabupaten.provinsi.id) {
                                $(this).attr('selected', 'selected');
                             }
                        });
                        getDesa(response.kecamatan.id)
                    }

                    if (typeof response.kabupaten !== 'undefined') {
                        $('#kabupaten-select').html('');
                        $('#kabupaten-select').append($('<option>').text(response.kabupaten.nama).attr({
                            value: response.kabupaten.id,
                            selected: 'selected'
                        }));
                        $.each($('#provinsi-select option'), function(index, val) {
                             /* iterate through array or object */
                             if ($(this).val() == response.kabupaten.provinsi.id) {
                                $(this).attr('selected', 'selected');
                             }
                        });
                        getKecamatan(response.kabupaten.id)
                    }

                    if (typeof response.provinsi !== 'undefined') {
                        $.each($('#provinsi-select option'), function(index, val) {
                             /* iterate through array or object */
                             if ($(this).val() == response.provinsi.id) {
                                $(this).attr('selected', 'selected');
                             }
                        });
                        $('#kecamatan-select').html(`<option value="">-- Pilih Disini --</option>`);
                        $('#kabupaten-select').html(`<option value="">-- Pilih Disini --</option>`)
                        $('#desa-select').html(`<option value="">-- Pilih Disini --</option>`)
                        getKabupaten(response.provinsi.id)
                    }
                  }
                });

              marker.bindPopup(result.address.Match_addr).openPopup();
            });
    });
    function getLocation(){
    // get users lat/long
    var getPosition = {
      enableHighAccuracy: false,
      timeout: 9000,
      maximumAge: 0
    };
    console.log(getPosition);
    function success(gotPosition) {
      var uLat = gotPosition.coords.latitude;
      var uLon = gotPosition.coords.longitude;
      // console.log(uLat,uLon);
      document.getElementById('latitude').value = uLat;
      document.getElementById('longitude').value = uLon;
      map.setView(new L.LatLng(uLat, uLon), 10);
      map.removeLayer(marker);

      marker = L.marker([uLat, uLon],{
          draggable: true
        }).addTo(map);
        marker.on('dragend', function (e) {
            document.getElementById('latitude').value = marker.getLatLng().lat;
            document.getElementById('longitude').value = marker.getLatLng().lng;


        });
      // console.log(`${uLat}`, `${uLon}`);
    };
    function error(err) {
      console.warn(`ERROR(${err.code}): ${err.message}`);
    };
    navigator.geolocation.getCurrentPosition(success, error, getPosition);
    };

    $('#provinsi-select').change(function() {
            var valueProv = $('#provinsi-select').val();
            console.log('Provinsi Id : '+valueProv);
            getKabupaten(valueProv);
        });
        $('#kabupaten-select').change(function() {
            var valueKab = $('#kabupaten-select').val();
            console.log('Kabupaten Id : '+valueKab);
            getKecamatan(valueKab);
        });
        $('#kecamatan-select').change(function() {
            var valueKec = $('#kecamatan-select').val();
            console.log('Kecamatan Id : '+valueKec);
            getDesa(valueKec);
        });
        $('#desa-select').change(function() {
            var valueDesa = $('#desa-select').val();
            console.log('Desa Id : '+valueDesa);
        });
        function getKabupaten(id) {
            $.ajax({
              url: '/api/v1/getKabupaten/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#kabupaten-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                          // console.log(json.data[i].nama);
                          $('#kabupaten-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#kabupaten-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
        function getKecamatan(id) {
            $.ajax({
              url: '/api/v1/getKecamatan/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#kecamatan-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                          // console.log(json.data[i].nama);
                          $('#kecamatan-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#kecamatan-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
        function getDesa(id) {
            $.ajax({
              url: '/api/v1/getDesa/'+id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                // alert(json.data);
                // console.log(json.data);
                  $("#desa-select").html('');
                  if (json.code == 200) {
                      for (i = 0; i < Object.keys(json.data).length; i++) {
                          // console.log(json.data[i].nama);
                          $('#desa-select').append($('<option>').text(json.data[i].nama).attr('value', json.data[i].id));
                      }
                  } else {
                      $('#desa-select').append($('<option>').text('Data tidak di temukan').attr('value', 'Data tidak di temukan'));
                  }
              }
            });
        }
</script>
{{--  --}}
@endpush
