<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->path = 'app.dashboard.';
	}
    public function index()
    {
    	return view($this->path.'index');
    }
}
