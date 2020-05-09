<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdepLog extends Model
{
    protected $table = 'idep_logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid_idep_log',
		'employee_id',
		'transaction_at',
		'value',
		'description',
		'withdrawn_at',
		'withdrawal_id',
    ];
}
