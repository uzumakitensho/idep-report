<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportEmployeeRequest;
use App\Exports\TotalIdepByEmployeeExport;
use App\Models\Employee;
use App\Models\IdepLog;
use App\Models\WithdrawalPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Arr;
use DB;
use Excel;

class PeriodeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function showListPeriode(Request $request)
	{
		$periode = WithdrawalPeriode::orderBy('periode_start_at')->first();

		return (new TotalIdepByEmployeeExport($periode))->download('laporan-idep.xlsx');
	}
}
