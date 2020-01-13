<?php

namespace App\Http\Controllers;

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

        $user->master_hash = $request->masterHash;

        if ($user->save()){
            $success = true;
        }

        return response()->
        json($response = array(
            'success' => $success,
            'msg' => $request->masterHash
        ));
    }
}
