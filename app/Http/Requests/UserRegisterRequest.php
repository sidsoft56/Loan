<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required',
                'c_password' => 'required|same:password',        
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
      throw new HttpResponseException(sendError('Validation Error.', $validator->errors()));
    }
}
