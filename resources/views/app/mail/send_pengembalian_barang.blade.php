<div>
	<h3>Permintaan Pengembalian Barang</h3>
	<p>Pembeli : {{ $pembeli }} meminta untuk melakukan pengembalian barang yang dia pesan.</p>
	<p>Alasan: <br>
		{{ $keterangan }}
	</p>
	<p>{{ $waktu }}</p>
	<p>
		No Kwitansi: {{ $no_kwitansi }}<br>
		Nama Barang: {{ $nama_barang }}<br>
		Jumlah Barang: {{ $jumlah }}<br>
		Satuan: {{ $satuan }}
	</p>
</div>