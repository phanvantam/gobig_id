<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class ScriptRequest extends MainRequest
{

    public function add() {
        $data = [
            'name' => Request::json('script.name'),
            'description' => Request::json('script.description'),
            'blocks' => Request::json('blocks'),
        ];
        $rules = [
            'name'=> 'required|max:190|min:5',
            'description' => 'required',
            'blocks' => 'required|array',
        ];
        $messages = [];
        $attributes = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'attributes'=> $attributes,
            'data'=> $data
        ];
    }

    public function edit() {
        $result = $this->add();
        return $result;
    }

}
