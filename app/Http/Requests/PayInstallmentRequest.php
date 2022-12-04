<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PayInstallmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return true; 
        
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
                'loan_id' => "required|exists:App\Models\Loan,id,status,approved",            
                        
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
      throw new HttpResponseException(sendError('Validation Error.', $validator->errors()));
    }
}
