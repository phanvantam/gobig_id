<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class FormDataRequest extends MainRequest
{

    public function add() {
        $data = [
            'title' => Request::json('title'),
            'description' => Request::json('description'),
            'fields' => Request::json('fields'),
        ];
        $rules = [
            'title'=> 'required',
            'description' => 'required',
            'fields' => 'required|array',
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
