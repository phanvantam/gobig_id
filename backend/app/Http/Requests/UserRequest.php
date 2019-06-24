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

    public function _childCreate()
    {
        $data = [
            'child_id' => Request::json('child_id'),
            'parent_id' => Request::json('parent_id'),
        ];
        $rules = [
            'child_id'=> 'required',
            'parent_id' => 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _permissionCreate()
    {
        $data = [
            'permission_id' => Request::json('permission_id'),
            'user_id' => Request::json('user_id'),
        ];
        $rules = [
            'permission_id'=> 'required',
            'user_id' => 'required',
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
