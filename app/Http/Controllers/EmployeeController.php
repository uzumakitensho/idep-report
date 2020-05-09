<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\IdepLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Arr;
use DB;

class EmployeeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function showListEmployee(Request $request)
	{
		$employees = Employee::orderBy('full_name')->get();

		return view('employee.list', [
			'employees' => $employees,
		]);
	}
}
