<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendForgetPasswordLinkEmailNotification;
use App\Rules\OldPasswordMatch;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Role
     */
    private $role;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @construct
     */
    public function __construct()
    {
        $this->user = new User;
        $this->role = new Role;
        $this->userService = new UserService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $this->user->with('links', 'role')->find(auth()->user()->id);
        $response = new UserResource($user);
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'data' => $response
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            "current_password" => ["required", new OldPasswordMatch],
            "password" => "required|min:6",
            "confirmation_password" => "required|min:6|same:password"
        ]);
        $this->user->update([
            'password' => Hash::make($request->password)
        ]);
        return ResponseHelper::response('success', 200, 'Password updated successfully');
    }

    public function sendForgetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $user = $this->user->email($request->email)->first();
        if (!$user) {
            return ResponseHelper::response('success', 200, 'Email does not exist');
        }
        $user->notify(new SendForgetPasswordLinkEmailNotification($user));
        return ResponseHelper::response('success', 200, 'Link has been send to your email successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function forgetPasswordView(Request $request)
    {
        $email = $request->email;
        return view('forget_password_view', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        dd($request->all());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
        try {
            $roles = $this->role->where('name', '!=', 'admin')->get();
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => ['roles' => $roles]
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $this->userService->updateProfile($request->all(), auth()->user());
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => 'Profile Updated successfully'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'success',
                'status_code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function forgetUserName(Request $request)
    {
        try {
            $response = $this->userService->sendNotifyEmailForUserName($request->all());
            if ($response['result'] == "fail") {
                return response()->json([
                    'status' => 'fail',
                    'status_code' => 404,
                    'data' => ["message" => $response['message']]
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => ["message" => $response['message']]
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'success',
                'status_code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function getSellerProfile($id)
    {
        try {
            $user = $this->user->with('links', 'role')->whereHas('role', function ($sql) {
                $sql->where('name', 'seller');
            })->find($id);
            $response = new UserResource($user);
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => $response
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
