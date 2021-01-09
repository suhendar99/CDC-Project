<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;
use App\Province;
use App\City;

class ShopController extends Controller
{
	public function __construct()
	{
		$this->category = new Kategori;
		$this->barang = new Barang;
		$this->province = new Province;
		$this->city = new City;
	}
	public function index()
	{
		$category = $this->category->getData();
		$barang = $this->barang->limit(20)->get();
		// dd($category);
		return view('app.shop.index', compact('category','barang'));
	}

	public function detail($id)
	{
		$data = $this->barang->find($id);
		$provinces = $this->province->pluck('name','province_id');
		// dd($barang);
		return view('app.shop.detail', compact('data','provinces'));
	}

	public function getCities($id)
    {
        $city = $this->city->where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }
}
