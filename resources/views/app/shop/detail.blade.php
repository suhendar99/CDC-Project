@php
	$shop = true;
	$detail = true;
@endphp

@extends('layouts.dashboard.header')

@section('content')
<div id="detail">
	<div class="row">
		<div class="col-md-12">
            <div class="card card-block d-flex">
                <div class="card-body ">
					<div class="row">
					    <div class="col-md-4 garis">
					        {{-- @if ($item->barang->foto != null) --}}
					            {{-- <div class="card shadow card-image">
					                <img src="#" width="100" height="100" alt="Image-Penerimaan-Barang" class="img-border">
					            </div> --}}
					        {{-- @else --}}
					            <div class="card shadow card-image">
					                <center><i class="material-icons icon-large">broken_image</i></center>
					            </div>
					        {{-- @endif --}}
					    </div>
					    <div class="col-md-1" style="margin-right: -53px;"></div>
					    <div class="col-md-7">
					        <div class="row">
					            <div class="col-md-12">
					                <small class="font-weight-bold">Toko Ahmad</small>
					            </div>
					            <div class="col-md-12" style="border-bottom: 1px solid grey; border-left-width: 10px;">
					                <p class="h1">Beras Merah</p>
					            </div>
					            <div class="col-md-12 mt-4" style="border-bottom: 1px solid grey; border-left-width: 10px;">
					                <div class="row p-2">
					                    <div class="col-md-3 valign-center" style="opacity: 0.3;">
					                        <div class="h6">Harga :</div>
					                    </div>
					                    <div class="col-md-9 valign-center">
					                        <p class="font-weight-bold h5" style="color: red;">Rp 20.000</p>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-12 mt-4" style="border-bottom: 1px solid grey; border-left-width: 10px;">
					                <div class="row p-2">
					                    <div class="col-md-3 valign-center" style="opacity: 0.3;">
					                        <div class="h6">Info Produk :</div>
					                    </div>
					                    <div class="col-md-9 valign-center">
					                        <div class="row">
					                            <div class="col-md-4">
					                                <div class="row">
					                                    <div class="col-md-12">Stok</div>
					                                    <div class="col-md-12">200 Pcs</div>
					                                </div>
					                            </div>
					                            <div class="col-md-4">
					                                <div class="row">
					                                    <div class="col-md-12">Berat</div>
					                                    <div class="col-md-12">200 Gr</div>
					                                </div>
					                            </div>
					                            <div class="col-md-4">
					                                <div class="row">
					                                    <div class="col-md-12">Kondisi</div>
					                                    <div class="col-md-12">Baru</div>
					                                </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-12 mt-4">
					                <div class="row p-2">
					                    <div class="col-md-3 valign-center" style="opacity: 0.3;">
					                        <div class="h6">Ongkos Kirim :</div>
					                    </div>
					                    <div class="col-md-9 valign-center">
					                        <div class="row">
					                            <div class="col-md-6">
					                                <div class="float-left">
					                                    <div class="row">
					                                        <div class="col-md-12">
					                                            Dari Bandung
					                                        </div>
					                                    </div>
					                                </div>
					                            </div>
					                            <div class="col-md-6">
					                                <div class="float-right">
					                                    <div class="row">
					                                        <div class="col-md-12">
					                                            <small>Mulai dari : Rp 20.000</small>
					                                        </div>
					                                    </div>
					                                </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
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
{{-- Chart Section --}}
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
    document.getElementById("nextBtn").innerHTML = "Beli";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
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
    $(document).ready(function(){
        //active select2
        $(".provinsi-asal , .kota-asal, .provinsi-tujuan, .kota-tujuan").select2({
            theme:'bootstrap4',width:'style',
        });
        //ajax select kota asal
        $('select[name="province_origin"]').on('change', function () {
            let provindeId = $(this).val();
            if (provindeId) {
                jQuery.ajax({
                    url: '/citiesLoad/'+provindeId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('select[name="city_origin"]').empty();
                        $('select[name="city_origin"]').append('<option value="">-- pilih kota asal --</option>');
                        $.each(response, function (key, value) {
                            $('select[name="city_origin"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="city_origin"]').append('<option value="">-- pilih kota asal --</option>');
            }
        });
        //ajax select kota tujuan
        $('select[name="province_destination"]').on('change', function () {
            let provindeId = $(this).val();
            if (provindeId) {
                jQuery.ajax({
                    url: '/citiesLoad/'+provindeId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('select[name="city_destination"]').empty();
                        $('select[name="city_destination"]').append('<option value="">-- pilih kota tujuan --</option>');
                        $.each(response, function (key, value) {
                            $('select[name="city_destination"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="city_destination"]').append('<option value="">-- pilih kota tujuan --</option>');
            }
        });
        //ajax check ongkir
        let isProcessing = false;
        $('.btn-check').click(function (e) {
            e.preventDefault();

            let token            = $("meta[name='csrf-token']").attr("content");
            let city_origin      = $('input[name=city_origin]').val();
            let city_destination = $('select[name=city_destination]').val();
            let courier          = $('select[name=courier]').val();
            let weight           = $('#weight').val();

            if(isProcessing){
                return;
            }

            isProcessing = true;
            jQuery.ajax({
                url: "/v1/ongkir",
                data: {
                    _token:              token,
                    city_origin:         city_origin,
                    city_destination:    city_destination,
                    courier:             courier,
                    weight:              weight,
                },
                dataType: "JSON",
                type: "POST",
                success: function (response) {
                    console.log(response)
                    isProcessing = true;
                    if (response) {
                        $('#ongkir').empty();
                        $('.ongkir').addClass('d-block');
                        $.each(response[0]['costs'], function (key, value) {
                            $('#ongkir').append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        <li class="list-group-item">`+response[0].code.toUpperCase()+` : <strong>`+value.service+`</strong> - Rp. `+value.cost[0].value+` (`+value.cost[0].etd+` hari)</li>
                                    </label>
                                </div>
                            `)
                        });

                    }
                }
            });

        });

    });
</script>
{{--  --}}
@endpush


