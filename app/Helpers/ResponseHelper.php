<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * @param $status
     * @param $code
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response($status,$code,$message)
    {
        return response()->json([
            'status' => $status,
            'status_code' => $code,
            'message' => $message
        ],$code);
    }
    public static function apiResponse($status,$code,$data): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'status_code' => $code,
            'data'=>$data
        ],$code);
    }
}
