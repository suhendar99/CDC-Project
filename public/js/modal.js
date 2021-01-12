function detailFotoKtpPengurusGudang(id){
    $('#fotoKtpGudangView').text("Mendapatkan Data.......")
    $.ajax({
        url: "/api/v1/getFotoKtp/"+id,
        method: "GET",
        contentType: false,
        cache: false,
        processData: false,
        success: (response)=>{
            $.each(response.data, function (a, b) {
                console.log(b.pengurus_gudang.foto_ktp)
                if (b.pengurus_gudang.foto_ktp == null) {
                    $("#fotoKtpGudangView").text('- Tidak Ada Foto Barang -');
                }else{
                    $("#fotoKtpGudangView").html(`<img class="foto" style="width:100%; height:auto;" src="${b.pengurus_gudang.foto_ktp}">`);
                }
            });
        },
        error: (xhr)=>{
            let res = xhr.responseJSON;
            console.log(res)
        }
    });
}
function detailFotoKtpPemasok(id){
    $('#fotoKtpPemasokView').text("Mendapatkan Data.......")
    $.ajax({
        url: "/api/v1/getFotoKtp/"+id,
        method: "GET",
        contentType: false,
        cache: false,
        processData: false,
        success: (response)=>{
            $.each(response.data, function (a, b) {
                console.log(b.pemasok.foto_ktp)
                if (b.pemasok.foto_ktp == null) {
                    $("#fotoKtpPemasokView").text('- Tidak Ada Foto Barang -');
                }else{
                    $("#fotoKtpPemasokView").html(`<img class="foto" style="width:100%; height:auto;" src="${b.pemasok.foto_ktp}">`);
                }
            });
        },
        error: (xhr)=>{
            let res = xhr.responseJSON;
            console.log(res)
        }
    });
}
function detailFotoKtpSelfiePengurusGudang(id){
    $('#fotoKtpSelfieGudangView').text("Mendapatkan Data.......")
    $.ajax({
        url: "/api/v1/getFotoKtp/"+id,
        method: "GET",
        contentType: false,
        cache: false,
        processData: false,
        success: (response)=>{
            $.each(response.data, function (a, b) {
                console.log(b.pengurus_gudang.foto_ktp_selfie)
                if (b.pengurus_gudang.foto_ktp_selfie == null) {
                    $("#fotoKtpSelfieGudangView").text('- Tidak Ada Foto Barang -');
                }else{
                    $("#fotoKtpSelfieGudangView").html(`<img class="foto" style="width:100%; height:auto;" src="${b.pengurus_gudang.foto_ktp_selfie}">`);
                }
            });
        },
        error: (xhr)=>{
            let res = xhr.responseJSON;
            console.log(res)
        }
    });
}
function detailFotoKtpSelfiePemasok(id){
    $('#fotoKtpSelfiePemasokView').text("Mendapatkan Data.......")
    $.ajax({
        url: "/api/v1/getFotoKtp/"+id,
        method: "GET",
        contentType: false,
        cache: false,
        processData: false,
        success: (response)=>{
            $.each(response.data, function (a, b) {
                console.log(b.pemasok.foto_ktp_selfie)
                if (b.pemasok.foto_ktp_selfie == null) {
                    $("#fotoKtpSelfiePemasokView").text('- Tidak Ada Foto Barang -');
                }else{
                    $("#fotoKtpSelfiePemasokView").html(`<img class="foto" style="width:100%; height:auto;" src="${b.pemasok.foto_ktp_selfie}">`);
                }
            });
        },
        error: (xhr)=>{
            let res = xhr.responseJSON;
            console.log(res)
        }
    });
}
