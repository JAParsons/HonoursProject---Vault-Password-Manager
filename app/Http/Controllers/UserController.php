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
        $password = bcrypt($request['password']); //hash provided password

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;

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
