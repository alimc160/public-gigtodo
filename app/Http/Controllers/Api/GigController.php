<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\User;
use App\Services\GigService;
use Illuminate\Http\Request;
use Stripe;

class GigController extends Controller
{
    /**
     * @var GigService
     */
    private $gigService;

    public function __construct()
    {
        $this->gigService =  new GigService;
    }

    public function createGig(Request $request){
        $request->validate([
            'title'=>'required|max:250',
            'description'=>'required',
            'search_tags'=>'required',
            'category_id'=>'required',
            'sub_category_id'=>'required',
            "packages"=>"required",
            'requirements'=>"required",
            "images"=>"required"
        ]);
        try {
          $gig = $this->gigService->createGig($request->all(),auth()->user());
          return response()->json([
             "status"=>"success",
             "status_code"=>200,
             "data"=>['gig'=>$gig]
          ],200);
        }catch (\Exception $exception){
            return response()->json([
               "status"=>"fail",
               "status_code"=>$exception->getCode(),
               "message"=>$exception->getMessage()
            ],500);
        }
    }

    public function getBuyerGigsListing(Request $request){
        try {
            $gigs=$this->gigService->buyerGigListing($request->all());
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>['gigs'=>$gigs]
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ],$exception->getCode());
        }
    }

    public function getGig($id){
        try {
            $gig = $this->gigService->gig($id);
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>['gig'=>$gig]
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ],$exception->getCode());
        }
    }

    public function addGigToFavourite(Request $request){
        try {
            $gigFavourite=$this->gigService->createGigFavourite($request->all(),auth()->user());
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>$gigFavourite
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ],$exception->getMessage());
        }
    }

    public function getFavouriteGigsListing(Request $request){
        try {
            $favouriteGigs = $this->gigService->favouriteGigsListing($request->all(),auth()->user());
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>['favourite_gigs'=>$favouriteGigs]
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ],$exception->getCode());
        }
    }

    public function deleteFavouriteGig($id){
        try {
            $this->gigService->deleteFavGig($id);
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "message"=>'Gig has been deleted from list successfully'
            ]);
        }catch (\Exception $exception){
            return[
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ];
        }
    }

    public function orderGig(Request $request){
        $request->validate([
           'seller_id'=>'required',
           'gig_id'=>'required',
           'gig_package_id'=>'required',
//            'transaction_no'=>'required',
            'card_last_four_digits'=>'required',
            'expiry_date'=>'required',
            'cvv_number'=>'required',
            'requirements'=>'required'
        ]);
        try {
          $this->gigService->placeOrder($request->all(),auth()->user());
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "message"=>'Order has been placed successfully'
            ]);
        }catch (\Exception $exception){
            return[
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function orderHistory(Request $request){
        try {
            $orders=$this->gigService->getOrders($request->all(),auth()->user());
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>$orders
            ]);
        }catch (\Exception $exception){
            return[
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ];
        }
    }

    public function getOrder($id){
        try {
            $order=$this->gigService->getOrder($id);
            return response()->json([
                "status"=>"success",
                "status_code"=>200,
                "data"=>$order
            ]);
        }catch (\Exception $exception){
            return[
                "status"=>"fail",
                "status_code"=>$exception->getCode(),
                "message"=>$exception->getMessage()
            ];
        }
    }
}
