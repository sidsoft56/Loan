<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Hash;


class RegisterController extends Controller
{
    
    
    /**
    * Register api
    * @param  
    *   name:@string
    *   password:@string
    *   c_password:@string
    *   email:@string
    *
    * @return \Illuminate\Http\Response
    *   
    */

    public function register(UserRegisterRequest $request)
    {
       
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =$user->createToken('MyApp')->accessToken;
        $success['name'] =$user->name;

        return sendResponse($success, 'User register successfully.');
    }

    /**
    * Login api
    * @param  
    *   password:@string 
    *   email:@string
    *
    * @return \Illuminate\Http\Response
    *   
    */
    public function login(UserLoginRequest $request)
    {   
       
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $success['token'] =$user->createToken('MyApp')->accessToken; 
                $success['name'] =$user->name;

                return sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return sendError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
       }
       else{ 
        return sendError('Unauthorised.', ['error'=>'Email address does not exist']);
       } 
    }


}
