<?php

namespace App\Services;

use App\Http\Resources\GigFavouriteResource;
use App\Models\Gig;
use App\Models\GigFavourite;
use App\Models\GigImage;
use App\Models\GigPackage;
use App\Models\GigRequirement;
use App\Models\GigTag;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SellerOrderReceieveNotification;
use Carbon\Carbon;
use Stripe;

class GigService
{
    /**
     * @var Gig
     */
    private $gig;
    /**
     * @var GigTag
     */
    private $gigTag;
    /**
     * @var GigPackage
     */
    private $gigPackage;
    /**
     * @var GigRequirement
     */
    private $gigRequirement;
    /**
     * @var GigImage
     */
    private $gigImage;
    /**
     * @var GigFavourite
     */
    private $gigFavourite;

    public function __construct()
    {
        $this->gig = new Gig;
        $this->gigTag = new GigTag;
        $this->gigPackage = new GigPackage;
        $this->gigRequirement = new GigRequirement;
        $this->gigImage = new GigImage;
        $this->gigFavourite = new GigFavourite;
        $this->order = new Order;
        $this->user = new User;
    }

    /**
     * @param $request
     * @param $user
     * @return mixed
     */
    public function createGig($request,$user){
        $request['user_id'] = $user->id;
        $gig=$this->gig->create($request);
        foreach ($request['search_tags'] as $tag){
            $input = ['name'=>$tag,'gig_id'=>$gig->id];
            $this->gigTag->create($input);
        }
        foreach ($request['packages'] as $package){
            $this->gigPackage->create(array_merge($package,['gig_id'=>$gig->id]));
        }
        foreach ($request['requirements'] as $requirement){
            $this->gigRequirement->create(['name'=>$requirement,'gig_id'=>$gig->id]);
        }
        foreach ($request['images'] as $image){
            $imagePath=uploadImage($image,'uploads/gigs','uploads/gigs/');
            $this->gigImage->create(['gig_id'=>$gig->id,'image'=>$imagePath]);
        }
        return $gig;
    }

    /**
     * @param $perPage
     * @param $request
     * @param false $paginate
     * @return array
     */
    public function getGigs($perPage, $request, $paginate = false){
        $gig = $this->gig;
        $total = 0;
        if ($paginate == false) {
            $gigs = $gig->orderBy('id', 'desc')->get();
            $total = $gig->count();
        } else {
            $total = $gig->get()->count();
            $gigs = $gig->orderBy('id', 'desc')->paginate($perPage);
        }
        return ['result' => $gigs, 'total' => $total];
    }

    /**
     * @param $request
     * @return array
     */
    public function changeGigStatus($request){
        $gig=$this->gig->find($request['id']);
        $gig->update([
            "status"=>$request['status']
        ]);
        return ['result'=>"Status has updated successfully!","total"=>1];
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function buyerGigListing($request){
        $queryLog = $this->gig->with("user","packages","requirements","tags")
            ->where("status","approved");
        if (isset($request['from']) && isset($request['to'])){
            $from = new Carbon($request['from']);
            $to = new Carbon($request['to']);
            $from = $from->format('Y-m-d')." 00:00:00";
            $to = $to->format('Y-m-d')." 00:00:00";
            $queryLog->whereBetween('created_at',[$from,$to]);
        }
        if (isset($request['search_tag'])){
            $queryLog->whereHas('tags',function ($sql) use($request){
                $tag = $request['search_tag'];
               $sql->where('name','like',"$tag%");
            });
        }
        return $queryLog->orderBy("id","desc")->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function gig($id){
       return $this->gig->with("user","packages","requirements","tags")
            ->find($id);
    }

    /**
     * @param $request
     * @param $user
     * @return GigFavouriteResource
     */
    public function createGigFavourite($request,$user){
        $input = array_merge($request,['user_id'=>$user->id]);
        $gigFavourite = $this->gigFavourite->updateOrCreate($input,$input);
        return new GigFavouriteResource($gigFavourite);
    }

    /**
     * @param $request
     * @param $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function favouriteGigsListing($request,$user){
        $gigs=$this->gigFavourite->where('user_id',$user->id)->with('user','gig')->get();
        return GigFavouriteResource::collection($gigs);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteFavGig($id){
        $gigFavourite=$this->gigFavourite->findOrFail($id);
        return $gigFavourite->delete();
    }
    public function payment($price)
    {
        $stripePublicKey = env('STRIPE_SECRET');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new Stripe\StripeClient($stripePublicKey);
        $paymentMethod = $stripe->tokens->create([
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => 2023,
                'cvc' => '314',
            ]
        ]);
        $payment=Stripe\Charge::create ([
            "amount" => $price*100,
            "currency" => "usd",
            "source" => $paymentMethod->id,
            "description" => ""
        ]);
        return $payment->id;
    }
    /**
     * @param $request
     * @param $user
     * @return mixed
     */
    public function placeOrder($request,$user){
        $serviceFee = 5;
        $gigPackage = $this->gigPackage->find($request['gig_package_id']);
        $subTotal=$serviceFee + $gigPackage->price;
        $transactionNo = $this->payment($subTotal);
        $user=$this->user->find($request['seller_id']);
        $order=$this->order->create([
           'buyer_id'=>$user->id,
            'seller_id'=>$request['seller_id'],
            'gig_id'=>$request['gig_id'],
            'gig_package_id'=>$request['gig_package_id'],
            'transaction_no'=>$transactionNo,
            'card_last_four_digits'=>$request['card_last_four_digits'],
            'expiry_date'=>$request['expiry_date'],
            'cvv_number'=>$request['cvv_number'],
            'service_fee'=>$serviceFee,
            'sub_total'=>$subTotal,
            'delivery_time'=>$gigPackage->delivery_time,
            'requirements'=>$request['requirements']
        ]);
        $user->notify(new SellerOrderReceieveNotification($this->order));
        return $order;
    }

    /**
     * @param $request
     * @param $user
     * @return mixed
     */
    public function getOrders($request,$user){
        return $this->order->where('buyer_id',$user->id)->get();
    }

    public function getOrder($id){
       return $this->order->find($id);
    }
}
