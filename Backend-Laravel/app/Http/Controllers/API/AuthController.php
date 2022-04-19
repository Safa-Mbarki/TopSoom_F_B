<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
    public function index(){
        return User::all();
    }

    public function register(Request $req){
        $validator = Validator::make($req->all(),[
            'name' => 'required',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        }else{
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),

            ]);
            $token = $user->createToken($user->email.'_Token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'Registered Successfully'
            ]);
        }
    }

    public function login(Request $req){

         $validator = Validator::make($req->all(),[
            'email' => 'required|email|max:191',
            'password' => 'required|min:8',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        }else{
             $user = User::where('email', $req->email)->first();
 
            if (! $user || ! Hash::check($req->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            }else{
                $token = $user->createToken($user->email.'_Token')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'username'=>$user->name,
                    'token'=>$token,
                    'message'=>'Logged Successfully'
                ]);
            }

        }

    }
    public function logout()
    {
        auth()->user()->tokens->each(function($token) {
            $token->delete();
        });
        return response()->json([
            'status'=>200,
            'message'=>'Logged Out Successfully',
        ]);
    }
}




