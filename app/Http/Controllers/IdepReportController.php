<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdepLogRequest;
use App\Models\Employee;
use App\Models\IdepLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Arr;
use DB;

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

	public function postCreateForm(CreateIdepLogRequest $request)
	{
		$transaction_at = Carbon::createFromFormat('Y-m-d', $request->transaction_at);
		$full_name = trim(strip_tags($request->full_name));
		$quantity = intval($request->quantity);
		$description = trim(strip_tags($request->description));

		DB::beginTransaction();

		$employeeDetail = Employee::where('full_name', $full_name)
			->first();
		if(empty($employeeDetail)){
			$employeeDetail = Employee::create([
				'full_name' => $full_name,
			]);
			if(!$employeeDetail){
				DB::rollBack();
				return response()->json([
					'success' => false,
					'messages' => ['Gagal membuat data!'],
				], 422);
			}
		}

		$newIdepLog = IdepLog::create([
			'uuid_idep_log' => self::generateUUID(),
			'employee_id' => $employeeDetail->id,
			'transaction_at' => $transaction_at,
			'value' => $quantity,
			'description' => $description,
		]);
		if(!$newIdepLog){
			DB::rollBack();
			return response()->json([
				'success' => false,
				'messages' => ['Gagal membuat data!'],
			], 422);
		}

		DB::commit();

		return response()->json([
			'success' => true,
		], 200);
	}

	public function getDataEmployeeList(Request $request)
	{
		$query = trim(strip_tags($request->q));
		$employees = Employee::where('full_name', 'like', '%'.$query.'%')
			->select('full_name')
			->orderBy('full_name')
			->get();

		$employees = array_values(array_unique(array_filter(Arr::pluck($employees, 'full_name'))));

		return response()->json($employees);
	}

	public function getDataIdepLog(Request $request)
	{
		$logs = IdepLog::join('employees', 'employees.id', '=', 'idep_logs.employee_id')
			->select(
				DB::raw("FORMAT(sum(idep_logs.value), 0, 'id_ID') as quantity_total, employees.full_name")
			)
			->groupBy('idep_logs.employee_id')
			->orderBy('employees.full_name')
			->get();

		return response()->json([
			'success' => true,
			'result' => [
				'logs' => $logs,
			],
		]);
	}
}
