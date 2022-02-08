<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CouponsService;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function __construct()
    {
        $this->couponsService = new CouponsService;
    }

    public function addCoupons(Request $request){
        $request->validate([
            'start_at'=>'required',
            'expire_at'=>'required',
            'discount'=>'required|integer|min:1|max:99'
        ]);
        try {
            $response=$this->couponsService->createCoupons($request->all(),$request->user());
            return response()->json([
                'status'=>'success',
                'status_code'=>200,
                'data'=>$response['result']
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function getCouponsResponse(Request $request){
        $request->validate([
            'coupon_code'=>'required'
        ]);
        try {
            $response=$this->couponsService->getCouponValidate($request->all());
            return response()->json($response);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
