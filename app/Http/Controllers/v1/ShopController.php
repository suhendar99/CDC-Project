<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class ShopController extends Controller
{
	public function __construct()
	{
		$this->category = new Kategori;
	}
	public function index()
	{
		$category = $this->category->getAll();
		dd($category);
		return view('app.shop.index', compact($category));
	}
}
