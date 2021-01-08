<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;

class ShopController extends Controller
{
	public function __construct()
	{
		$this->category = new Kategori;
		$this->barang = new Barang;
	}
	public function index()
	{
		$category = $this->category->getAll();
		$barang = $this->barang->limit(20)->get();
		// dd($category);
		return view('app.shop.index', compact('category','barang'));
	}
}
