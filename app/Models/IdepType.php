<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdepType extends Model
{
    protected $table = 'idep_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_name',
    ];
}
