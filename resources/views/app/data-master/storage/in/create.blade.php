@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row h-100">
        <div class="col-md-12">
            @if (session()->has('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
		    	<i data-feather="check-circle"></i>
		        {{ session()->get('success') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    @elseif (session()->has('failed'))
		    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		    	<i data-feather="alert-circle"></i>
		        {{ session()->get('failed') }}
		        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    @endif
            <div class="card card-block d-flex" id="card-form">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="float-left">
                                <h5>Tambah Data Barang</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="{{route('barang.index')}}" class="btn btn-primary btn-sm">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <form action="{{route('in.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Kode Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('barang_kode') is-invalid @enderror" name="barang_kode" value="{{ old('barang_kode') }}" id="scanBarang" aria-describedby="barangStatus">
                                        <small id="barangStatus" class="form-text text-success"><a href="{{ route('barang.create') }}" title="Create Barang">Tambah Barang</a></small>
                                        @error('barang_kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Jumlah Barang <small class="text-success">*Harus diisi</small></label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Enter jumlah barang">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Satuan <small class="text-success">*Harus diisi</small></label>
                                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan') }}" placeholder="Enter satuan">
                                        @error('satuan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Gudang <small class="text-success">*Harus diisi</small></label>
                                        <select name="gudang_id" id="" class="form-control">
                                            <option value="0">--Pilih Gudang--</option>
                                            @foreach ($gudang as $list)
                                                <option value="{{$list->id}}" {{ old('gudang_id') == $list->id ? 'selected' : ''}}>{{$list->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('harga_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
<script src="{{ asset('js/onscan.js') }}"></script>
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
                    $('#barangStatus').append('Barang ditemukan <a href="{{ route('barang.create') }}" title="Create Barang">Tambah Barang</a>')
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
                    $('#barangStatus').append('Barang tidak ditemukan! <a href="{{ route('barang.create') }}" title="Create Barang">Tambah Barang</a>');
                }
            });
        }
        // onKeyDetect: function(key){
        //     console.log(key)
        // }
    });
</script>
@endpush