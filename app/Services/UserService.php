<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfileLink;
use App\Notifications\SendUserNameNotification;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var UserProfileLink
     */
    private $userProfileLink;

    /**
     * @construct of UserService
     */
    public function __construct()
    {
        $this->user = new User;
        $this->userProfileLink = new UserProfileLink;
    }

    public function addLinks($link,$userId){
        $request = ['link'=>$link,'user_id'=>$userId];
        return $this->userProfileLink->create($request);
    }

    /**
     * @param $request
     * @return array
     */
    public function createUser($request)
    {
        $imagePath = null;
        if (isset($request['image'])){
            $path = public_path() . '/uploads/users';
            $savePath = 'uploads/users/';
            $imagePath=uploadImage($request['image'],$path,$savePath);
        }
        $parts = explode("@", $request['email']);
        $userName = $parts[0];
        $user=$this->user->create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'role_id'=>$request['role_id'],
            'image'=>$imagePath,
            'user_name'=>$userName
        ]);
        if (isset($request['prfile_links'])) {
            foreach ($request['prfile_links'] as $link) {
                $this->addLinks($link, $user->id);
            }
        }
        return ['status'=>'success','result'=>$user];
    }

    /**
     * @param $perPage
     * @param $request
     * @param false $paginate
     * @return array
     */
    public function getUsers($perPage, $request, $paginate = false){
        $allUsers = $this->user->whereHas('role',function ($q){
            $q->where('name','!=','admin');
        })->with('role')->orderBy('id', 'desc');
        $total = 0;
        if ($paginate == false) {
            $users = $allUsers->get();
        } else {
            $users = $allUsers->paginate($perPage);
        }
        $total = $allUsers->count();
        return ['result' => $users, 'total' => $total];
    }

    public function updateIsActiveStatus($id,$request){
        $user=$this->user->find($id);
        $user->update([
            'is_active'=>$request['is_active']
        ]);
        return ['status'=>'success','result'=>'Status updated successfully!'];
    }

    public function updateProfile($request,$user){
        $user->update([
            'name'=>$request['name']
        ]);
        if (isset($request['image'])){
            if (file_exists(public_path().'/'.$user->image)){
                unlink(public_path().'/'.$user->image);
            }
            $imagePath = uploadImage($request['image'],'uploads/users','uploads/users/');
            $user->update([
                'image'=>$imagePath
            ]);
        }
        if (isset($request['prfile_links'])) {
            foreach ($request['prfile_links'] as $link) {
                $this->addLinks($link, $user->id);
            }
        }
        return $user;
    }

    public function sendNotifyEmailForUserName($request){
        $user=$this->user->whereEmail($request['email'])->first();
        if (!$user){
            return ['result'=>'fail','message'=>'User not found against this email'];
        }
        $user->notify(new SendUserNameNotification($user->user_name));
        return ['result'=>'success','message'=>'Your name has been send to you mail please check mail.'];
    }
}
