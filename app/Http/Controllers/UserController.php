<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        $validation = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if($validation){
            $usercheck = User::where('username',$request->username)->first();
            if(!$usercheck){
                return response()->json(['message'=>"Username not found"],401);
            }else{
                if (Hash::check($request->password, $usercheck->password)) {
                    return response()->json(['success' => 'Login successful'], 200);
                } else {
                    return response()->json(['error' => 'Invalid credentials'], 401);
                }
            }
        }
    }

    public function register(Request $request){
        $validation = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'email' => ['required'],
            'nik' => ['required'],
            'name' => ['required']
        ]);
        $password = Hash::make($request->password);
        if($validation){
           $usernamecheck = User::where('username', $request->username)->first();
           $emailcheck = User::where('email', $request->email)->first();

           if($usernamecheck){
            return response()->json(['error' => 'Username already taken'], 401);
           }elseif($emailcheck){
            return response()->json(['error' => 'Email already taken'], 401);
           }else{
            $create = User::create([
                'username' => $request->username,
                'password' => $password,
                'email' => $request->email,
                'nik' => $request->nik,
                'name' => $request->name,
                'is_admin' => 0
            ]);
            if($create){
                    return response()->json(['success' => 'user created'], 200);
            }else{
                    return response()->json(['error' => 'An error occured'], 401);
            }
           }
        }
    }

    public function user(){
        $userall = User::all();
        return response()->json($userall, 200);
    }

    public function user_info($id){
        $user = User::where('id',$id)->first();
        return response()->json($user, 200);
    }
    
}
