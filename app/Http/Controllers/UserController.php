<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //takes a request obj and post new user to DB
    public function postRegister(Request $request)
    {
        $email = $request['email'];
        $name = $request['name'];
        $password = bcrypt($request['reg_password']); //hash provided password
        $masterKey = $request['enc_master_key'];
        $masterIV = $request['master_iv'];

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;
        $user->master_key = $masterKey;
        $user->master_iv = $masterIV;

        $user->save(); //save to DB

        return redirect()->route('dashboard');
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getDashboard()
    {
        return view('dashboard');
    }
}
