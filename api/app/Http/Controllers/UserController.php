<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Http\Requests\UserRequest;
use App\Models\Permission;

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
                'total_record' => $result->total(),
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
            'master_id'=> $this->request->json('master_id'),
        ];
        $request['password_code'] = $this->user->makePasswordCode($request['password'], $request['salt']);
        $record_id = $this->user->create($request);

        if($request['master_id'] !== 0) {
            $result = $this->user->getById($request['master_id']);
            $location = explode('.', $result->use_location);
            $location[] = $record_id;
        } else {
            $location = [$record_id];
        }
        $this->user->updateLocationById($record_id, $location);
        return $this->response($record_id);
    }

    public function update($user_id)
    {
        $request = [
            'fullname'=> $this->request->json('fullname'),
            'email'=> $this->request->json('email'),
            'password'=> $this->request->json('password'),
            'master_id'=> $this->request->json('master_id'),
            'salt'=> $this->user->makeSaltCode(),
        ];
        if(!empty($request['password'])) {
            $request['password_code'] = $this->user->makePasswordCode($request['password'], $request['salt']);
        }
        $this->user->updateById($user_id, $request);

        $user_detail = $this->user->getById($user_id);
        $result = $this->user->getByLocation($user_detail->use_location, ['use_location', 'use_id']);
        if($result !== null) {
            $location_new = $user_id;
            if((int)$request['master_id'] !== 0) {
                $master_detail = $this->user->getById($request['master_id']);
                $location_new = "{$master_detail->use_location}.{$user_id}";
            }
            foreach ($result as $item) {
                $location = preg_replace("/^".$user_detail->use_location."\./", $location_new. '.', $item->use_location);
                $this->user->updateLocationById($item->use_id, explode('.', $location));
            }
            $this->user->updateLocationById($user_id, explode('.', $location_new));
        }
        return $this->response();
    }

    public function permissionCreate()
    {
        $request = [
            'permission_id'=> $this->request->json('permission_id'),
            'user_id'=> $this->request->json('user_id'),
            'project_id'=> $this->request->json('project_id'),
        ];
        $this->user->permissionRemoveByProjectAndUser($request['project_id'], $request['user_id']);
        $this->user->permissionAdd($request);
        return $this->response();
    }

    public function permissionDetail($user_id)
    {
        $request = [
            'project_id'=> $this->request->query('project_id'),
        ];
        $result = $this->user->permissionGetByProjectAndUser($request['project_id'], $user_id);
        $response = $result === null ? [] : $result->toArray();
        return $this->response($response);
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
        
        $user->master;
        $user->permission;
        if($user->permission !== null) {
            $user->permission->map(function($item) {
                $item->project;
                $result = $this->permission->getModuleCode($item->per_modules_id);
                $modules = [
                    'code'=> [],
                    'list'=> []
                ];
                if($result !== null) {
                    foreach($result as $m_item) {
                        $modules['list'][] = [
                            'name'=> $m_item->mod_name,
                            'code'=> $m_item->mod_code
                        ];
                        $modules['code'][] = $m_item->mod_code;
                    }
                }
                $item->modules = $modules;
            });
        }
        $user_children = $this->user->getByLocation($user->use_location, ['use_code']);
        if($user_children !== null) {
            $user->children_code = $user_children->implode('use_code', '|');
        }
        
        return $this->response($user);
    }

    public function detail($user_id)
    {
        $user = $this->user->getById($user_id);
        if($user !== null) {
            $user->master;
            $user->permission;
            $user->permission->map(function($item) {
                $item->project;
                $result = $this->permission->getModuleCode($item->per_modules_id);
                $modules = [
                    'code'=> [],
                    'list'=> []
                ];
                if($result !== null) {
                    foreach($result as $m_item) {
                        $modules['list'][] = [
                            'name'=> $m_item->mod_name,
                            'code'=> $m_item->mod_code
                        ];
                        $modules['code'][] = $m_item->mod_code;
                    }
                }
                $item->modules = $modules;
            });
        }
        
        return $this->response($user);
    }

    public function child($user_id)
    {
        $user = $this->user->getById($user_id);
        $request = [
            'fullname'=> $this->request->input('fullname'),
            'per'=> $this->request->input('per', 10),
            'location'=> $user->use_location
        ];
        $result = $this->user->children($request);
        $response = [
            'users'=> $result->all(),
            'paginate'=> [
                'total_page' => ceil($result->total()/$result->perPage()),
                'current_page' => $result->currentPage(),
                'total_record' => $result->total(),
            ]
        ];
        return $this->response($response);
    }

    public function childRemove($id)
    {
        $this->user->childRemove($id);
        return $this->response();
    }

    public function profileUpdate()
    {
        $user = $this->user->getByCode(USER_CODE);
        $request = [
            'fullname'=> $this->request->json('fullname'),
        ];
        $this->user->updateProfileById($user->use_id, $request);
        return $this->response();
    }

    public function getByModule()
    {
        $request = [
            'module_code'=> $this->request->input('module_code'),
        ];
        $module_detail = $this->permission->moduleByCode($request["module_code"]);
        $permission = Permission::where('per_modules_id', 'LIKE', "{$module_detail->mod_id},%")->first();
        if($permission === null) {
            $permission = Permission::where('per_modules_id', 'LIKE', "%,{$module_detail->mod_id},%")->first();
        }
        if($permission === null) {
            $permission = Permission::where('per_modules_id', 'LIKE', "%,{$module_detail->mod_id}")->first();
        }
        $users = [];
        if($permission !== null) {
            $result = $this->user->permissionById($permission->per_id);
            if($result !== null) {
                foreach($result as $item) {
                    $users[] = $item->user;
                }
            }
        }
        
        return $this->response($users);
    }

    public function profileUpdatePassword()
    {
        $user = $this->user->getByCode(USER_CODE);
        $request = [
            'password'=> $this->request->json('password'),
            'salt'=> $this->user->makeSaltCode(),
        ];
        $request['password_code'] = $this->user->makePasswordCode($request['password'], $request['salt']);
        $this->user->updatePasswordById($user->use_id, $request);
        return $this->response();
    }

    public function profile()
    {
        $user = $this->user->getByCode(USER_CODE);

        $user->position;
        $user->permission;
        $user->permission->map(function($item) {
            $item->project;
        });
        return $this->response($user);
    }
}
