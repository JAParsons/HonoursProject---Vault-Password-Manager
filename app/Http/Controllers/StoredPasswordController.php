<?php

namespace App\Http\Controllers;

use App\StoredPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoredPasswordController extends Controller
{
    public function getDashboard()
    {
        $user = Auth::user();
        $token = $user->token;
        $storedPasswords = StoredPassword::where('user_token', $token)->get();

        return view('dashboard', ['storedPasswords' => $storedPasswords, 'user' => $user]);
    }
}
