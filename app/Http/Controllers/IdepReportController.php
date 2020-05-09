<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdepReportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function showListIdepReport()
	{
		return view('report.list');
	}
}
