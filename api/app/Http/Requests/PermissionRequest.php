<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;

class PermissionRequest extends MainRequest
{

    public function _createModule()
    {
    	$data = [
            'name' => Request::json('name'),
            'parent_id' => Request::json('parent_id'),
            'project_id' => Request::json('project_id'),
        ];
        $rules = [
            'name'=> 'required',
            'parent_id' => 'required',
            'project_id' => 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _createProject()
    {
        $data = [
            'name' => Request::json('name'),
        ];
        $rules = [
            'name'=> 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _positionCreate()
    {
        $data = [
            'name' => Request::json('name'),
            'key' => Request::json('key'),
            'level' => Request::json('level'),
        ];
        $rules = [
            'name'=> 'required',
            'key'=> 'required',
            'level'=> 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _create()
    {
        $data = [
            'title' => Request::json('title'),
            'modules_id' => Request::json('modules_id'),
            'project_id' => Request::json('project_id'),
        ];
        $rules = [
            'title'=> 'required',
            'modules_id'=> 'required',
            'project_id'=> 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _update()
    {
        return $this->_create();
    }
}
