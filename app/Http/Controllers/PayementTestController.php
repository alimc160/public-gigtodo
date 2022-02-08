<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\User;
use Illuminate\Http\Request;
//use Stripe;
use Stripe;

class PayementTestController extends Controller
{
    public function test()
    {
        $user = User::find(2);
        $gig = Gig::with('packages')->find(2);
        $price = $gig->packages->first()->price;
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
//        dd($paymentMethod->id);
//        $payment = new Stripe\Charge::create([
//
//        ]);
//        dd($paymentMethod->toJSON());
//        $user=$user->createOrGetStripeCustomer();
//        $user->updateDefaultPaymentMethod($paymentMethod->id);
//        dd($user);
        $payment=Stripe\Charge::create ([
            "amount" => $price*100,
            "currency" => "usd",
            "source" => $paymentMethod->id,
            "description" => ""
        ]);
        return $payment->id;
    }
}
