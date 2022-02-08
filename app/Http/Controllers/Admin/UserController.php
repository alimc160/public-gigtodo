<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function index(){
        $data = [];
        $data['users'] = $this->userService->getUsers(10,null,true);
        return view('admin.user.index',compact('data'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return string[]
     */
    public function changeStatus($id,Request $request){
        return $this->userService->updateIsActiveStatus($id,$request->all());
    }
}
