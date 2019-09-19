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

    public function getByProject($project_id)
    {
        $result = $this->permission->getByProject($project_id);

        return $this->response($result);
    }

    public function getById($id)
    {
        $result = $this->permission->getById($id);
        $result->project;
        return $this->response($result);
    }

    public function create()
    {
        $request = [
            'title'=> $this->request->json('title'),
            'project_id'=> $this->request->json('project_id'),
            'modules_id'=> $this->request->json('modules_id'),
        ];
        $record_id = $this->permission->create($request);
        return $this->response($record_id);
    }

    public function update($id)
    {
        $request = [
            'title'=> $this->request->json('title'),
            'project_id'=> $this->request->json('project_id'),
            'modules_id'=> $this->request->json('modules_id'),
        ];
        $this->permission->update($id, $request);
        return $this->response();
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

    public function positionCreate()
    {
        $request = [
            'name'=> $this->request->json('name'),
            'key'=> $this->request->json('key'),
            'level'=> $this->request->json('level'),
        ];
        $record_id = $this->permission->positionCreate($request);
        return $this->response($record_id);
    }

    public function position()
    {
        $request = [];
        $result = $this->permission->positionGetByFilter($request);
        return $this->response($result);
    }

    public function positionSearch()
    {
        $result = $this->permission->positionSearch();
        return $this->response($result);
    }
}
