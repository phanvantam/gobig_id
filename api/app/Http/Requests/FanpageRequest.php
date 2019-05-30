<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class FanpageRequest extends MainRequest
{

    public function scriptKeywordAdd() {
        $data = [
            'script_id' => Request::json('script_id'),
            'keywords' => Request::json('keywords'),
        ];
        $rules = [
            'script_id'=> 'required',
            'keywords' => 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function scriptKeywordEdit() {
        return $this->scriptKeywordAdd();
    }

}
