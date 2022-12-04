<?php

use Illuminate\Http\Response;

if(!function_exists('sendError')){	
   /**
    * return error response.
    *
    * @return \Illuminate\Http\Response
    */
    function sendError($error, $errorMessages = [], $code = 404)
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


if(!function_exists('sendResponse')){	
   /**
    * return error response.
    *
    * @return \Illuminate\Http\Response
    */
    function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'=> $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
}
?>