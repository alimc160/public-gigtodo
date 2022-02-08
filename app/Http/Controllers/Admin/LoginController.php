<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        $user = User::where('email',$request->email)->first();
        if (!$user){
            session()->flash('error','Credentials does not match');
        }
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)){
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error','Credentials does not match');
    }
}
