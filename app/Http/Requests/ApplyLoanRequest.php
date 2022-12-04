<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplyLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->role == 'admin'){
            return true;
        }
        else{
            return false; 
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [            
                'amount' => "required|regex:/^\d+(\.\d{1,2})?$/",
                'term' => 'required|integer|min:0',
                        
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
      throw new HttpResponseException(sendError('Validation Error.', $validator->errors()));
    }
}
