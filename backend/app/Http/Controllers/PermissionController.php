<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(
        PermissionRepositoryInterface $permission,
        UserRepositoryInterface $user,
        PermissionRequest $request
    ){
        $this->request = $request;
        $this->permission = $permission;
        $this->user = $user;
    }

    public function index()
    { 
        $request = [];
        $result = $this->permission->getByFilter($request);

        return $this->response($result);
    }

    public function create()
    {
        $request = [
            'title'=> $this->request->json('title'),
            'description'=> $this->request->json('description'),
            'project_id'=> $this->request->json('project_id'),
            'modules_id'=> $this->request->json('modules_id'),
        ];
        $record_id = $this->permission->create($request);
        return $this->response($record_id);
    }

    public function createModule()
    {
        $request = [
            'name'=> $this->request->json('name'),
            'parent_id'=> $this->request->json('parent_id'),
            'project_id'=> $this->request->json('project_id'),
            'code'=> $this->permission->makeUniqueCode(),
        ];
        $record_id = $this->permission->createModule($request);
        return $this->response($record_id);
    }

    public function listModule($project_id)
    {
        $result = $this->permission->getListModule($project_id);
        return $this->response($result);
    }

    public function createProject()
    {
        $request = [
            'name'=> $this->request->json('name'),
            'code'=> $this->permission->makeUniqueCode(),
        ];
        $record_id = $this->permission->createProject($request);
        return $this->response($record_id);
    }

    public function listProject()
    {
        $response = $this->permission->getListProject();
        return $this->response($response);
    }

}
