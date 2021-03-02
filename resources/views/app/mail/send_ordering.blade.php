<div>
	<h3>Pemesanan Baru</h3>
	<p>Waktu: {{ now('Asia/Jakarta') }}</p>
	<p>Kode Pemesanan: {{ $kode }}</p>
	<p>Pemesan: {{ $pemesan->nama }}</p>
	<p>Barang yang dipesan: </p>
	<ul>
		<li>Nama: {{ $barang->nama_barang }}</li>
		<li>Jumlah: {{ $barang->jumlah_barang }}</li>
		<li>Satuan: {{ $barang->satuan }}</li>
		<li>Harga: Rp. {{ number_format($barang->harga,0,',','.') }}</li>
	</ul>
</div>