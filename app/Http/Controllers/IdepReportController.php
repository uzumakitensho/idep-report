<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\IdepLog;
use Illuminate\Http\Request;
use Arr;

class IdepReportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function showListIdepReport(Request $request)
	{
		return view('report.list');
	}

	public function getDataEmployeeList(Request $request)
	{
		$query = $request->q;
		$employees = Employee::where('full_name', 'like', '%'.$query.'%')
			->select('full_name')
			->orderBy('full_name')
			->get();

		$employees = array_values(array_unique(array_filter(Arr::pluck($employees, 'full_name'))));

		return response()->json($employees);
	}
}
