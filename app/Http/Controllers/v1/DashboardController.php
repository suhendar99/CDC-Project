<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->pathPemasok = 'app.dashboard.pemasok.';
		$this->pathPelanggan = 'app.dashboard.pelanggan.';
		$this->pathKaryawan = 'app.dashboard.karyawan.';
		$this->pathAdmin = 'app.dashboard.admin.';
	}
    
    public function index()
    {
		$auth = Auth::user();
    	if ($auth->pemasok_id != null) {
    		return view($this->pathPemasok.'index');	
    	} elseif ($auth->karyawan_id != null) {
    		return view($this->pathKaryawan.'index');	
    	} elseif ($auth->pelanggan_id != null) {
    		return view($this->pathPelanggan.'index');
    	} else {
    		return view($this->pathAdmin.'index');
    	}
    }
}
