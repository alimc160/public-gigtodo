<?php

namespace App\Services;

use App\Models\Coupons;
use Carbon\Carbon;

class CouponsService
{
    public function __construct()
    {
        $this->coupons = new Coupons;
    }

    /**
     * @param $request
     * @param $user
     * @return array
     */
    public function createCoupons($request, $user)
    {
        $coupons = $this->coupons->create([
            'created_by' => $user->id,
            'start_at' => $request['start_at'],
            'expire_at' => $request['expire_at'],
            'discount' => $request['discount'],
            'code'=>'cou'.time().$user->id
        ]);
        return ['result'=>$coupons,'total'=>1];
    }

    /**
     * @param $request
     * @return array
     */
    public function getCouponValidate($request){
        $currentDate = Carbon::now();
        $coupon=$this->coupons->where('code',$request['coupon_code'])->first();
        $startDate = Carbon::parse($coupon->start_at);
        $endDate = Carbon::parse($coupon->expire_at);
        if ($currentDate < $startDate){
            return [
                'status'=>'success',
                'status_code'=>200,
                'message'=>'This coupon code is not available for now'
            ];
        }else if($currentDate > $endDate){
            return [
                'status'=>'success',
                'status_code'=>404,
                'message'=>'This coupon code has been expired!'
            ];
        }else if (!$coupon){
            return [
                'status'=>'success',
                'status_code'=>404,
                'message'=>'This coupon code was not found!'
            ];
        }else{
            return [
                'status'=>'success',
                'status_code'=>200,
                'data'=>$coupon
            ];
        }
    }
}
