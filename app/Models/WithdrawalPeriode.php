<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalPeriode extends Model
{
    protected $table = 'withdrawal_periodes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'periode_start_at',
		'periode_end_at',
		'is_withdrawn',
    ];
}
