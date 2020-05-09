<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'full_name',
    ];

    public function getTotalAllQuantityAttribute()
    {
    	return $total = IdepLog::where('employee_id', $this->id)->sum('value');
    }
}
