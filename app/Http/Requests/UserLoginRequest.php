<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;

class UserLoginRequest extends FormRequest
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
        'email' => 'required|email:rfc,dns|exists:App\Models\User,email',
        'password' => 'required'        
        ];
    }

    protected function failedValidation(Validator $validator)
    { 
      throw new HttpResponseException($this->sendError('Validation Error.', $validator->errors()));
    }
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'=> $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
    * return error response.
    *
    * @return \Illuminate\Http\Response
    */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
