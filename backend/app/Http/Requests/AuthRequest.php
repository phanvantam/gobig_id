<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class AuthRequest extends MainRequest
{

    public function _login()
    {
    	$data = [
            'email' => Request::json('email'),
            'password' => Request::json('password'),
        ];
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

}
