<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class UserRequest extends MainRequest
{

    public function _create()
    {
    	$data = [
            'fullname' => Request::json('fullname'),
            'email' => Request::json('email'),
            'password' => Request::json('password'),
        ];
        $rules = [
            'fullname'=> 'required',
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