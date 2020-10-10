<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdepLogRequest;
use App\Http\Requests\EditIdepLogRequest;
use App\Models\Employee;
use App\Models\IdepLog;
use App\Models\IdepType;
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
		$idep_type = trim(strip_tags($request->idep_type));
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

		if(!empty($idep_type)){
			$detailType = IdepType::where('type_name', $idep_type)->first();
			if(empty($detailType)){
				$detailType = IdepType::create([
					'type_name' => $idep_type,
				]);
				if(!$detailType){
					DB::rollBack();
					return response()->json([
						'success' => false,
						'messages' => ['Gagal membuat data!'],
					], 422);
				}
			}

			$newIdepLog->idep_type_id = $detailType->id;
			if(!$newIdepLog->save()){
				DB::rollBack();
				return response()->json([
					'success' => false,
					'messages' => ['Gagal membuat data!'],
				], 422);
			}
		}

		DB::commit();

		return response()->json([
			'success' => true,
		], 200);
	}

	public function postEditForm(EditIdepLogRequest $request, $uuid)
	{
		$transaction_at = Carbon::createFromFormat('Y-m-d', $request->transaction_at);
		$idep_type = trim(strip_tags($request->idep_type));
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

		if(!empty($idep_type)){
			$detailType = IdepType::where('type_name', $idep_type)->first();
			if(empty($detailType)){
				$detailType = IdepType::create([
					'type_name' => $idep_type,
				]);
				if(!$detailType){
					DB::rollBack();
					return response()->json([
						'success' => false,
						'messages' => ['Gagal membuat data!'],
					], 422);
				}
			}

			$newIdepLog->idep_type_id = $detailType->id;
			if(!$newIdepLog->save()){
				DB::rollBack();
				return response()->json([
					'success' => false,
					'messages' => ['Gagal membuat data!'],
				], 422);
			}
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

	public function getDataIdepTypeList(Request $request)
	{
		$query = trim(strip_tags($request->q));
		$idepTypes = IdepType::where('type_name', 'like', '%'.$query.'%')
			->select('type_name')
			->orderBy('type_name')
			->get();

		$idepTypes = array_values(array_unique(array_filter(Arr::pluck($idepTypes, 'type_name'))));

		return response()->json($idepTypes);
	}

	public function getDataIdepLog(Request $request)
	{
		$selectedDateFilter = null;
		if(!empty($request->selected_date)){
			$selDateStart = Carbon::createFromFormat('Y-m-d', $request->selected_date)->startOfDay();
			$selDateEnd = Carbon::createFromFormat('Y-m-d', $request->selected_date)->endOfDay();

			$selectedDateFilter = [$selDateStart, $selDateEnd];
		}

		$logs = IdepLog::join('employees', 'employees.id', '=', 'idep_logs.employee_id')
			->select(
				DB::raw("FORMAT(sum(idep_logs.value), 0, 'id_ID') as quantity_total, employees.full_name")
			)
			->groupBy('idep_logs.employee_id')
			->orderBy('employees.full_name')
			->get();

		$logsByDate = IdepLog::orderBy(DB::raw("DATE_FORMAT(idep_logs.transaction_at, '%Y-%m-%d')"))
			->select(
				DB::raw("FORMAT(sum(idep_logs.value), 0, 'id_ID') as quantity_total"),
				DB::raw("DATE_FORMAT(idep_logs.transaction_at, '%Y-%m-%d') as transaction_date")
			)
			->groupBy(DB::raw("DATE_FORMAT(idep_logs.transaction_at, '%Y-%m-%d')"))
			->get();

		$logsBySelectedDate = IdepLog::join('idep_types', 'idep_types.id', '=', 'idep_logs.idep_type_id')
			->select(
				DB::raw("FORMAT(sum(idep_logs.value), 0, 'id_ID') as quantity_total, idep_types.type_name")
			)
			->groupBy('idep_logs.idep_type_id');

		if($selectedDateFilter){
			$logsBySelectedDate = $logsBySelectedDate->whereBetween('idep_logs.transaction_at', $selectedDateFilter);
		}

		$logsBySelectedDate = $logsBySelectedDate->orderBy('idep_types.type_name')
			->get();

		$inputLogsByDate = IdepLog::leftJoin('idep_types', 'idep_types.id', '=', 'idep_logs.idep_type_id')
			->leftJoin('employees', 'employees.id', '=', 'idep_logs.employee_id')
			->select(
				'idep_logs.uuid_idep_log',
				'idep_logs.description',
				'idep_logs.value',
				'employees.full_name',
				'idep_types.type_name',
				DB::raw("FORMAT(idep_logs.value, 0, 'id_ID') as quantity"),
				DB::raw('DATE_FORMAT(idep_logs.created_at, "%Y-%m-%d %H:%i:%s") as created_date'),
				DB::raw('DATE_FORMAT(idep_logs.transaction_at, "%Y-%m-%d") as trans_date')
			);

		if($selectedDateFilter){
			$inputLogsByDate = $inputLogsByDate->whereBetween('idep_logs.transaction_at', $selectedDateFilter);
		}

		$inputLogsByDate = $inputLogsByDate->orderBy('idep_types.type_name')
			->get();

		return response()->json([
			'success' => true,
			'result' => [
				'logs' => $logs,
				'logsByDate' => $logsByDate,
				'logsBySelectedDate' => $logsBySelectedDate,
				'inputLogsDate' => $inputLogsByDate,
			],
		]);
	}
}
