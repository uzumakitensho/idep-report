<?php

namespace App\Exports;

use App\Models\IdepLog;
use App\Models\WithdrawalPeriode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class TotalIdepByEmployeeExport implements FromQuery
{
	use Exportable;

	public function __construct(WithdrawalPeriode $periode)
    {
        $this->periode = $periode;
    }
    
    public function query()
    {
        return IdepLog::query()->join('employees', 'employees.id', '=', 'idep_logs.employee_id')
			->select(
				DB::raw("sum(idep_logs.value) as quantity_total, employees.full_name")
			)
			->whereBetween('idep_logs.transaction_at', [$this->periode->periode_start_at, $this->periode->periode_end_at])
			->groupBy('idep_logs.employee_id')
			->orderBy('employees.full_name');
    }
}
