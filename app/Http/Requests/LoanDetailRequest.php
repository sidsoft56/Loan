<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoanDetailRequest extends FormRequest
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
                'loan_id' => "nullable|exists:App\Models\Loan,id",
                'status' => "nullable|in:payed,unpayed",
                        
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
      throw new HttpResponseException(sendError('Validation Error.', $validator->errors()));
    }
}
