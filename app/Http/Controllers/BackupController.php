<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function getCreateBackup()
    {
        $user = Auth::user();
        return view('createBackup', ['user' => $user]);
    }
}
