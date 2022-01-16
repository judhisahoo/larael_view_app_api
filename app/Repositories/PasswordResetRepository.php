<?php

namespace App\Repositories;

use App\Interfaces\PasswordResetRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResetModel;
use Illuminate\Support\Carbon;

class PasswordResetRepository implements PasswordResetRepositoryInterface{

    public function isValidToken($token){
        return PasswordResetModel::where('token',$token)->get()->count();
    }

    public function deleteTokenWithEmail($token,$email){
        return PasswordResetModel::where('token',$token)->where('email',$email)->delete();
    }

    public function createPasswordReset(array $details){
        $detailsObj=new PasswordResetModel();
        $detailsObj->token=$details['token'];
        $detailsObj->email=$details['email'];
        $detailsObj->created_at=Carbon::now();
        $detailsObj->save();
        return $detailsObj->id;
    }

    public function getDetailsByToken($token){
        return PasswordResetModel::where('token',$token)->get()->first();
    }
}
