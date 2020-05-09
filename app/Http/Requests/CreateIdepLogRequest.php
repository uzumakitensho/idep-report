<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateIdepLogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transaction_at' => 'required|date_format:"Y-m-d"',
            'full_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException(response()->json([
            'status' => 'fail',
            'messages' => $validator->errors()->all(),
        ], 422)); 
    }
}
