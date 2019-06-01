<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function findUser(UserRequest $request)
    {
        $data = $this->user->search([
            'use_mail' => $request->input('mail'),
            'use_password' => md5($request->input('password'))
        ]);
        dd($data);
    }

    public function index(UserRequest $request)
    {
        $filter = [
            's' => $request->input('s','')
        ];
        $data = $this->user->index($filter);
        return $this->response($data);
    }   

    public function getUser($id,UserRequest $request)
    {
        dd($id);
    }

    public function createUser(UserRequest $request)
    {
        $create =  $this->user->firstOrCreate([
            'use_mail' => $request->input('mail')
        ],[ 
            'use_type' => $request->input('type',0),
            'use_name' => $request->input('name'),
            'use_password' => md5($request->input('password')),
            'use_token' => md5($request->input('password'))
        ]);
        return $this->response();
    }

    public function updateUser($id,UserRequest $request)
    {
        if(!$this->user->find($id)) return $this->response(['message' => 'Người dùng không tồn tại !' ],204);
        $update =  $this->user->update($id,[
            'use_mail' => $request->input('mail'),
            'use_type' => $request->input('type',0),
            'use_name' => $request->input('name'),
            'use_password' => md5($request->input('password')),
        ]);
        if($update == 0) return $this->response(['message' => 'Cập nhật thông tin người dùng thất bại !' ],406);
        return $this->response();
    }
}
