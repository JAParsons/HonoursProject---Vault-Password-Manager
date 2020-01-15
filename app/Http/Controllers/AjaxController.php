<?php

namespace App\Http\Controllers;

use App\StoredPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AjaxController extends Controller
{
    //verify the user before allowing the creation of QR backups
    public function postVerifyPassword(Request $request)
    {
        $success = false;
        $user = Auth::user();

        if (Hash::check($request->password, $user->password)){
            $success = true;
        }

        return response()->
            json($response = array(
                'success' => $success,
                'msg' => $request->password,
            ));
    }

    //post the generated master hash
    public function postMasterHash(Request $request)
    {
        $success = false;
        $user = Auth::user();

        $user->master_hash = bcrypt($request->masterHash);

        if ($user->save()){
            $success = true;
        }

        return response()->
        json($response = array(
            'success' => $success,
            'msg' => $request->masterHash
        ));
    }

    function postAddStoredPassword(Request $request){
        $success = false;
        $user = Auth::user();

        $storedPassword = new StoredPassword();
        $storedPassword->user_token = $user->token;
        $storedPassword->email = $request->email;
        $storedPassword->password = $request->password;
        $storedPassword->iv = $request->iv;
        $storedPassword->website_name = $request->name;
        $storedPassword->website_url = $request->url;
        $storedPassword->image_url = 'default';

        if ($storedPassword->save()){
            $success = true;
        }

        return response()->
        json($response = array(
            'success' => $success
        ));
    }
}
