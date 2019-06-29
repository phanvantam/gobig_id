<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(
        UserRepositoryInterface $user,
        PermissionRepositoryInterface $permission,
        UserRequest $request
    ){
        $this->request = $request;
        $this->user = $user;
        $this->permission = $permission;
    }

    public function index()
    { 
        $request = [
            'fullname'=> $this->request->input('fullname'),
            'per'=> $this->request->input('per', 10),
        ];
        $result = $this->user->getByFilter($request);
        $response = [
            'users'=> $result->all(),
            'paginate'=> [
                'total_page' => ceil($result->total()/$result->perPage()),
                'current_page' => $result->currentPage(),
            ]
        ];

        return $this->response($response);
    }

    public function create()
    {
        $request = [
            'fullname'=> $this->request->json('fullname'),
            'email'=> $this->request->json('email'),
            'password'=> $this->request->json('password'),
            'code'=> $this->user->makeUniqueCode(),
            'salt'=> $this->user->makeSaltCode(),
        ];
        $request['password_code'] = $this->user->makePasswordCode($request['password'], $request['salt']);
        $record_id = $this->user->create($request);
        return $this->response($record_id);
    }

    public function childCreate()
    {
        $request = [
            'parent_id'=> $this->request->json('parent_id'),
            'child_id'=> $this->request->json('child_id'),
        ];
        $record_id = $this->user->childCreate($request);
        return $this->response($record_id);
    }

    public function permissionCreate()
    {
        $request = [
            'permission_id'=> $this->request->json('permission_id'),
            'user_id'=> $this->request->json('user_id'),
        ];
        $this->user->permissionAdd($request);
        return $this->response();
    }

    public function search()
    {
        $request = [
            'query'=> $this->request->input('query'),
        ];
        $result = $this->user->search($request);
        $response = $result === null ? [] : $result->toArray();
        return $this->response($response);
    }

    public function info()
    {
        $user = $this->user->getByCode(USER_CODE);

        $result = $this->permission->getById($user->use_permission_id);

        $modules = [
            'code'=> [],
            'list'=> []
        ];
        if($result->modules !== null) {
            foreach($result->modules as $item) {
                $modules['list'][] = [
                    'name'=> $item->mod_name,
                    'code'=> $item->mod_code
                ];
                $modules['code'][] = $item->mod_code;
            }
        }

        $response = [
            'fullname'=> $user->use_fullname,
            'email'=> $user->use_email,
            'code'=> $user->use_code,
            'id'=> $user->use_id,
            'permission'=> [
                'title'=> $result->per_title,
                'id'=> $result->per_id,
            ],
            'modules'=> $modules
        ];
        return $this->response($response);
    }

    public function child($user_id)
    {
        $result = $this->user->getChild($user_id);
        $response = $result === null ? [] : $result->toArray();
        return $this->response($response);
    }

    // public function info()
    // {
    //     $user = $this->user->getByCode(USER_CODE);
    //     $result = $this->permission->getById($user->use_permission_id);

    //     $modules = [
    //         'code'=> [],
    //         'list'=> []
    //     ];
    //     if($result->modules !== null) {
    //         foreach($result->modules as $item) {
    //             $modules['list'][] = [
    //                 'name'=> $item->mod_name,
    //                 'code'=> $item->mod_code
    //             ];
    //             $modules['code'][] = $item->mod_code;
    //         }
    //     }

    //     $response = [
    //         'permission'=> [
    //             'title'=> $result->per_title,
    //             'id'=> $result->per_id,
    //         ],
    //         'modules'=> $modules
    //     ];
    //     return $this->response($response);
    // }
}
