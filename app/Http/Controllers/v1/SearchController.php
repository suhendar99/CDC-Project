<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class SearchController extends Controller
{
	public function __construct()
	{
		$this->barang = new Barang;
		$this->category = new Kategori;
		$this->shopPath = 'app.shop.';
		$this->pemasokPath = 'app.data-master.barang.';
	}

	public function barang(Request $request)
	{
		$category = $this->category->getData();
		$nomore = true;
		if($request->page == 'shop'){
			$barang =  $this->barang->where('nama_barang', 'like', '%'.$request->search.'%')->get();
			return view($this->shopPath.'index', compact('category','barang','nomore'));
		} elseif($request->page == 'pemasok'){
			$barang =  $this->barang->where('nama_barang', 'like', '%'.$request->search.'%')->paginate(24);
			return view($this->pemasokPath.'index', compact('category','barang'));
		} else {
			return 'null';
		}
	}
}
