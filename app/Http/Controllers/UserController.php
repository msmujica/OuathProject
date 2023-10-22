<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function Register(Request $request){

        $validation = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validation->fails())
            return $validation->errors();

        return $this -> CreateUser($request);
        
    }

    private function CreateUser($request){
        $user = new User();

        $user -> name = $request -> post("name");
        $user -> email = $request -> post("email");
        $user -> edad = $request -> post("edad");
        $user -> password = Hash::make($request -> post("password"));

        $user -> save();
        
        return $user;
    }

    private function UpdateUser($request){
        $user = User::findOrFail($request);

        $user = new User();
        $user -> name = $request -> post("name");
        $user -> email = $request -> post("email");
        $user -> edad = $request -> post("edad");
        $user -> password = Hash::make($request -> post("password"));

        $user -> save();

        return $user;
    }

    public function ValidateToken(Request $request){
        return auth('api')->user();
    }

    public function Logout(Request $request){
        $request->user()->token()->revoke();
        return ['message' => 'Token Revoked'];
        
        // Client ID: 1
        // Client secret: i66A8ocBX9boDbCjIHuPmtc9vAKlAvlvjmx1nUqx
    }

    
}
