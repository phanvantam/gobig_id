<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class TypeRequest extends MainRequest
{
    public function createType()
    {
    	return [
            'rules' => [
                'name' => ['required'],
            ],
        ];
    }

    public function updateType()
    {
        return [
            'rules' => [
                'name' => ['required'],
            ],
        ];
    }
}
