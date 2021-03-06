<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|string|min:3',
            'email'  => 'required|min:3|unique:users',
            'password'  => 'required|min:6',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>'error','errors'=>$validator->errors()]);
        }
        $user = new User();
        $user-> name = $request->name;
        $user-> email = $request->email;
        $user-> password = bcrypt($request->password);
        $user-> save();
        return response()->json(['status'=>'success','data'=>$user]);

    }


    public function login()
    {
        $credentials = request(['email','password']);
        if($token = auth()->attempt($credentials))
        {
            return response()->json(['status'=>'success','token'=>$token]);
        }
        return response()->json(['status'=>'error']);
    }


    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'successfully logged out']);
    }
}
