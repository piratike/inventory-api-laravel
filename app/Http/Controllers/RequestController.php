<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Correct response returned.
     *
     * @param string $result
     * @param string $message
     * @var \Illuminate\Http\Response
     */
    public static function returnSuccess($result, $message)
    {

        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);

    }

    /**
     * Failed response returned.
     * @param string $error
     * @param string $error_messages
     * @param int $code
     * @var \Illuminate\Http\Response
     */
    public static function returnFail($error, $error_messages, $code = 404)
    {

        $response = [
            'success' => false,
            'messge' => $error
        ];

        if(!empty($error_messages))
        {

            $response['data'] = $error_messages;

        }

        return response()->json($response, $code);

    }
}
