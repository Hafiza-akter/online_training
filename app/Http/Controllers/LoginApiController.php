<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginApiController extends Controller
{
    /**
     * userのメールアドレスを受け取り、api tokenを返却する
     * セキュリティの追加対策がいると思う!!
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // JSONを変換する
        $data = json_decode(file_get_contents('php://input'));

        $user = User::where('email', $data->mail)->first();
        $token = null;
        if($user != null){
            //存在している
            $token = $user->api_token;
        }

        return json_encode(["token" => $token]);
    }

}
