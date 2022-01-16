<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface{

    public function getAllUsers(){
        return User::get();
    }

    public function getUserById($user_id){
        return User::where('id',$user_id)->get()->toArray();
    }

    public function deleteUser($user_id){
        return User::where('id',$user_id)->delete();
    }

    public function createUser(array $userDetails){
        $userObj=new User();
        $userObj->name=$userDetails['name'];
        $userObj->email=$userDetails['email'];
        $userObj->phone=$userDetails['phone'];
        $userObj->password=Hash::make($userDetails['password']);
        $userObj->save();
        return $userObj->id;
    }

    public function updateUser($user_id,array $newDetails){
        return User::where('id',$user_id)->update($newDetails);
    }

    public function updateUserByEmail($email,$newDetails){
        return User::where('email',$email)->update($newDetails);
    }
}
