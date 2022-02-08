<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService,User $user)
    {
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
        $this->user = $user;
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role_id'=>'required'
        ]);
        try {
            $user = $this->user->with('links','role')->email($request->email)->first();
            if ($user && $user->is_active == 0){
                return ResponseHelper::response('fail',403,'Your account has been suspended please contact to the support team.');
            }
            if (!$user){
                return ResponseHelper::response('fail',404,'User not found');
            }
            $credentials = $request->only(['email','password']);
            if (Auth::attempt($credentials)){
                $token=$user->createToken(config('app.name'))->accessToken;
                return response()->json([
                    'status' => 'success',
                    'status_code' => 200,
                    'data'=>['token'=>$token,'user'=>$user]
                ],200);
            }
            return ResponseHelper::response('fail',500,'Credentials does not match');
        }catch (\Exception $exception){
            return response()->json(['status'=>'fail','status_code'=>500,'message'=>$exception->getMessage()]);
        }

    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
//        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
//            $user = Socialite::driver('google')->user();
            return $user->token;
            $finduser = $this->user->email()->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/home');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);

                return redirect('/home');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function googleLogin(Request $request){
        $request->validate([
            'role_id'=>'required',
            'token'=>'required'
        ]);
        $provider = Socialite::driver('google')->userFromToken($request->token);
        $user=$this->user->email($provider->getEmail())->with('role')->first();
        if ($user){
            Auth::login($user);
            $user = Auth::user();
            $token=$user->createToken('Laravel')->plainTextToken;
            return ResponseHelper::apiResponse('success',200,['token'=>$token,'user'=>$user]);
        }
        $newUser = $this->user->create([
           'name'=> $provider->getName(),
            'email'=>$provider->getEmail(),
            'role_id'=>$request['role_id']
        ]);
        Auth::login($newUser);
        $user = Auth::user();
        $token=$user->createToken('Laravel')->plainTextToken;
        return ResponseHelper::apiResponse('success',200,['token'=>$token,'user'=>$user]);
    }
}
