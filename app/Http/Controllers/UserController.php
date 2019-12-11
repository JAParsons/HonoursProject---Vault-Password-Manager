<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //takes a request obj and posts
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

        return redirect()->back();
    }

    public function postLogin(Request $request)
    {

    }
}
