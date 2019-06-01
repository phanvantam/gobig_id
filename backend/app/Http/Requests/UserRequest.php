<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class UserRequest extends MainRequest
{
    public function findUser()
    {
        return [
            'rules' => [
                'mail' => ['required'],
                'password' => ['required'],
            ],
        ];
    }

    public function createUser()
    {
    	return [
            'rules' => [
                'name' => ['required'],
                'type' => ['required','integer'],
                'password' => ['required'],
                'mail' => ['required'],
            ],
        ];
    }

    public function updateUser()
    {
        return [
            'rules' => [
                'name' => ['required'],
                'type' => ['required','integer'],
                'password' => ['required'],
                'mail' => ['required'],
            ],
        ];
    }
}
