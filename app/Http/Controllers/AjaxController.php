<?php

namespace App\Http\Controllers;

use App\StoredPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AjaxController extends Controller
{
    //verify the user before allowing the creation of QR backups
    public function postVerifyPassword(Request $request)
    {
        $success = false;
        $msg = '';
        $user = Auth::user();

        if (Hash::check($request->password, $user->password)){
            $success = true;
        }
        else{
            $msg = 'Incorrect Password';
        }

        return response()->
            json($response = array(
                'success' => $success,
                'msg' => $msg,
            ));
    }

    public function postChangeAccountPassword(Request $request){
        $success = false;
        $user = Auth::user();
        $password = bcrypt($request->password);
        $masterKey = $request->master;
        //$masterHash = bcrypt($request->hash);

        $user->password = $password;
        $user->master_key = $masterKey;
        //$user->master_hash = $masterHash;

        if ($user->save()){
            $success = true;
        }

        return response()->
        json($response = array(
            'success' => $success,
            'user' => $user,
        ));
    }

    //authenticate recovery login via master hash
    public function postRecoveryLogin(Request $request)
    {
        $success = false;
        $salt = '';
        $user = User::where(['token' => $request->token])->first();

        if (Hash::check($request->masterHash, $user->master_hash)){
            Auth::login($user);
            $salt = $user->master_salt;
            $success = true;
        }

        return response()->
        json($response = array(
            'success' => $success,
            'user' => $user,
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
        $msg = '';
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
        else{
            $msg = 'Unexpected error occurred, please try again';
        }

        return response()->
        json($response = array(
            'success' => $success,
            'msg' => $msg,
            'id' => $storedPassword->id
        ));
    }

    function postDeleteStoredPassword(Request $request){
        $success = false;
        $msg = '';
        $user = Auth::user();

        if (StoredPassword::where(['id' => $request->id, 'user_token' => $user->token])->delete()){
            $success = true;
        }
        else{
            $msg = 'Unexpected error occurred, please try again';
        }

        return response()->
        json($response = array(
            'success' => $success,
            'msg' => $msg
        ));
    }

    function postEditStoredPassword(Request $request){
        $success = false;
        $msg = 'Unexpected error occurred, please try again';
        $user = Auth::user();

        $storedPassword = StoredPassword::where('id', $request->id)->first();

        //check if the stored password belongs to the user
        if($storedPassword->user_token == $user->token){

            //update account values
            $storedPassword->email = $request->email;
            $storedPassword->website_name = $request->name;
            $storedPassword->website_url = $request->url;

            //if the stored password has also been updated
            if($request->newPassword && $request->iv){
                $storedPassword->password = $request->newPassword;
                $storedPassword->iv = $request->iv;
            }
        }
        else{
            $msg = "You don't have permission to do this";
        }

        if ($storedPassword->save()){
            $success = true;
        }
        else{
            $msg = 'Unexpected error occurred, please try again';
        }

        return response()->
        json($response = array(
            'success' => $success,
            'msg' => $msg
        ));
    }
}
