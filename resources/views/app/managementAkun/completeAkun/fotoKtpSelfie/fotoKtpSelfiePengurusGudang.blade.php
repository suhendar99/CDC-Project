@php
        $icon = 'dashboard';
        $pageTitle = 'Pengisian Foto KTP dengan selfie';
        $nosidebar = true;
@endphp
<style>
    .wrap-video{
        width: 100%;
        height: 100vh;
        object-fit: cover;
    }
    #video{
        border-radius: 5px;
        width: 100%;
    }
    #canvas{
        border-radius: 5px;
        width: 100%;
    }
    body{
        margin: 0;
    }
    .controller {
        position: absolute;
        z-index: 100;
    }
    #snap{
        /*border-radius: 0;*/
        width: 100%;
    }
    .bg-dark-opacity{
        width: 100%;
        height: 50px;
        /*background: black;*/
        /*opacity: .5;*/
    }
    .cam-title{
        font-size: 1.2rem;
        font-weight: 700;
        /* color: red; */
        opacity: 1;
    }
    .logo-taniquy{
        object-fit: scale-down;
        height: 50px;
        width: auto;
    }
    #canvas{
        width: 100% !important;
        height: auto;
    }
    #showTagName {
        font-size: 2rem;
        font-weight: 500;
        text-transform: capitalize;
    }
</style>
@extends('layouts.dashboard.header')

@section('content')
<div class="container-fluid">
    <div class="row valign-center mb-2">
        <div class="col-md-8 col-sm-12 valign-center py-2">
            <i class="material-icons md-48 text-my-warning">{{$icon}}</i>
            <div>
              <h4 class="mt-1 mb-0">{{$pageTitle}}</h4>
              {{-- <div class="valign-center breadcumb">
                <a href="#" class="text-14">Dashboard</a>
                <i class="material-icons md-14 px-2">keyboard_arrow_right</i>
                <a href="#" class="text-14">Data User</a>
              </div> --}}
            </div>
        </div>
        {{-- <div class="col-md-4 col-sm-12 valign-center py-2">
            @include('layouts.dashboard.search')
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="col-md-12">
                    <div class="row">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="float-left">
                                                        <h5>Ambil Foto</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 justify-content-center">
                                                    <video id="video" playsinline autoplay></video>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-block btn-primary btn-sm mt-2" id="snap">Ambil Foto</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="float-left">
                                                        <a href="" data-toggle="modal" data-target="#exampleModalCenter"> Contoh foto</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="float-right">
                                                        <h5>Hasil Capture</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 justify-content-center">
                                                    <canvas id="canvas"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-right">
                                        <form action="{{route('foto.ktp.selfie',Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="foto_ktp_selfie" id="foto-ktp" required>
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <div class="float-right">
                                                      <button type="submit" class="btn btn-success btn-sm">Selanjutnya</button>
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
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <img src="{{asset('images/selfie_ktp.jpg')}}" alt="Foto Selfie KTP" style="width: 100%;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script type="text/javascript">
     'use strict';
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('spanErrorMsg');
        const hdConstraints = {
            audio: false,
            video: {
                // facingMode: "environment",
                width: { ideal: 4096 },
                height: { ideal: 2160 }
            }
        };

        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(hdConstraints);
                handleSuccess(stream);
            } catch (error) {
                errorMsgElement.innerHTML = `navigator.getUserMendia.error:${error.toString()}`
            }
         }
         function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
         }
         init();

         snap.addEventListener("click", function () {
            const img = document.querySelector("#image");
                const ctx = canvas.getContext("2d");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext("2d").drawImage(video, 0, 0);
                // Other browsers will fall back to image/png
                const imgData = canvas.toDataURL();
                $('#foto-ktp').val(imgData)
        });

        function createBlob(dataURL) {
            var BASE64_MAKER = ';base64,';
            if (dataURL.indexOf(BASE64_MAKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = decodeURIComponent(parts[1]);
                return new Blob([raw], { type: contentType });
            }
            var parts = dataURL.split(BASE64_MAKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;
            var uInt8Array = new Uint8Array(rawLength);
            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }
            return new Blob([uInt8Array], { type: contentType });
        }
</script>
@endpush
