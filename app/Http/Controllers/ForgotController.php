<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ForgotRequest;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $email = $request->input('email');

        if(User::where('email',$email)->doesntExist()){
            return response([
                'message'=>'User doesn\'t exists!'
            ],404);
        }
        $token = Str::random(10);
        try{
            DB::table('password_resets')->insert([
                'email'=>$email,
                'token'=>$token
            ]);
            //Send email

            return response([
                'message'=>'Check your Email'
            ]);
        }catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }
    }
}
