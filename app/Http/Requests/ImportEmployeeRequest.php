<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'import_file' => 'required|file|mimes:xlsx,xlsm,xltx,xltm,xls,xlt,ods,ots,slk,xml,gnumeric,htm,html,csv,tsv',
        ];
    }
}
