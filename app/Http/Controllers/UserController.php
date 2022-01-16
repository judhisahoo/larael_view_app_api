<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\PasswordResetRepository;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    protected $userRepository;
    protected $passwordResetRepo;
    public function __construct(UserRepository $userRepo,PasswordResetRepository $passwordResetRepo)
    {
        $this->userRepository=$userRepo;
        $this->passwordResetRepo=$passwordResetRepo;
    }

    public function register(Request $userRequest){
        //$data = $userRequest->validated();
        $rules=[
            'name'=>'required|min:5|max:100',
            'phone'=>'nullable|min:10|max:10',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        ];
        $validator = Validator::make($userRequest->all(), $rules);
        if($validator->fails()){
            return response([
                'type'=>'fail',
                'message'=>$validator->errors()->all()
            ]);
        }else{
            $this->userRepository->createUser($userRequest->all());
            return response([
                'type'=>'success',
                'message'=>'user registered success fully'
            ],200);
        }

    }

    public function login(Request $request){
        $rules=[
            'email'=>'required|email|exists:users,email',
            'password'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response([
                'type'=>'fail',
                'message'=>$validator->errors()->all()
            ]);
        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user=Auth::user();
                $userObj=User::find($user->id);
                $token=$userObj->createToken('app')->accessToken;
                return response([
                    'type'=>'success',
                    'token'=>$token,
                    'user'=>$user
                ],200);
            }
        }

    }

    public function getAll(){
        $all=$this->userRepository->getAllUsers();
        return response([
            'message'=>'success',
            'allUser'=>$all
        ],200);
    }

    public function getDetails(){
        $userDetails=Auth::user();
        return response([
            'message'=>'success',
            'allUser'=>$userDetails
        ],200);
    }

    public function forgot(Request $request){
        $rules=[
            'email'=>'required|email|exists:users,email|unique:password_resets,email,NULL,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response([
                'type'=>'fail',
                'message'=>$validator->errors()->all()
            ]);
        }else{
            $token = Str::random(25);
            $details=[
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ];
            $this->passwordResetRepo->createPasswordReset($details);
            //DB::table('password_resets')->insert();
            /// this simple mail but here can create event and send mail by milable QUEUE
            Mail::send('forgot_password', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Your Password');
            });

            return response([
                'type'=>'success',
                'message'=>'Pleaasee cheeck your email inbox to reset your password.'
            ],200);
        }
    }


    public function reset(Request $request){
        $rules=[
            'token'=>'required|exists:password_resets,token',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response([
                'type'=>'fail',
                'message'=>$validator->errors()->all()
            ]);
        }else{
            $passwordResetDetails=$this->passwordResetRepo->getDetailsByToken($request->token);
            try{
                $passwordArr=['password'=>Hash::make($request->password)];
                $this->userRepository->updateUserByEmail($passwordResetDetails->email,$passwordArr);
                $this->passwordResetRepo->deleteTokenWithEmail($request->token,$passwordResetDetails->email);
                return response([
                    'type'=>'success',
                    'message'=>'Your password reset successfully.'
                ],200);
            }catch(Exception $e){
                return response([
                    'type'=>'fail',
                    'message'=>[$e->getMessage()]
                ],402);
            }
        }
    }
}
