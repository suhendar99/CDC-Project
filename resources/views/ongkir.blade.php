@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <div class="card">
                <h5 class="card-header text-black" style="background-color: .bg-secondary;">
                    Cek Ongkos Kirim
                </h5>
                <div class="card-body">
                    <form class="form" id="ongkir" method="POST">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Kota Asal:</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="kota_asal" name="kota_asal" required="">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Kota Tujuan</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="kota_tujuan" name="kota_tujuan" required="">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Kurir</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="kurir" name="kurir" required="">
                                    <option value="" selected="selected">--Pilih kurir--</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS INDONESIA</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Berat (Kg)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="berat" name="berat" placeholder="Max. 30 KG" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="submit" class="btn btn-success col-sm-8">Cek</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7" id="response_ongkir">
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#kota_asal').select2({
            placeholder: '--Pilih kota/kabupaten asal--',
            language: "id"
        });

        $('#kota_tujuan').select2({
            placeholder: '--Pilih kota/kabupaten tujuan--',
            language: "id"
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "{{ route('get.kota', 'kotaasal') }}",
            success: function (msg) {
                $("select#kota_asal").html(msg);
            }
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "{{ route('get.kota', 'kotatujuan') }}",
            success: function (msg) {
                $("select#kota_tujuan").html(msg);
            }
        });

        $("#ongkir").submit(function (e) {
            e.preventDefault();
            $.ajax({
                //url: 'cek_ongkir.php',
                url: "{{ route('cek.ongkir') }}",
                type: 'post',
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    document.getElementById("response_ongkir").innerHTML = data;
                }
            });
        });

    });
</script>
@endpush
@endsection
