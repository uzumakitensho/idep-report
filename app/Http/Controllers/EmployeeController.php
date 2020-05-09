<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportEmployeeRequest;
use App\Imports\EmployeesImport;
use App\Models\Employee;
use App\Models\IdepLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Arr;
use DB;
use Excel;

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

	public function importListEmployee(ImportEmployeeRequest $request)
	{
		Excel::import(new EmployeesImport, $request->file('import_file'));

		return redirect()->back()->withSuccess(['Import karyawan selesai.']);
	}
}
