<?php

namespace App\Repositories;

use App\Repositories\PermissionRepositoryInterface;
use App\Models\Permission;
use App\Models\Module;
use App\Models\Project;

class PermissionRepository implements PermissionRepositoryInterface
{

	public function getByFilter($params=[])
    {
        $query = new Permission;
        $result = $query->with('project')->get();
        return $result;
    }


	public function create($input)
	{
		$data = [
            'per_title'=> $input['title'],
            'per_modules_id'=> $input['modules_id'],
            'per_project_id'=> $input['project_id'],
            'per_description'=> $input['description'],
        ];
        $record_id = Permission::insertGetId($data);
        return $record_id;
	}


	public function createModule($input)
	{
		$data = [
            'mod_name'=> $input['name'],
            'mod_parent_id'=> $input['parent_id'],
            'mod_project_id'=> $input['project_id'],
            'mod_code'=> $input['code'],
        ];
        $record_id = Module::insertGetId($data);
        return $record_id;
	}

	public function createProject($input)
	{
		$data = [
            'pro_name'=> $input['name'],
            'pro_code'=> $input['code'],
        ];
        $record_id = Project::insertGetId($data);
        return $record_id;
	}

	public function getListProject()
	{
		$result = Project::get();
		return $result;
	}

	public function getListModule($project_id)
	{
		$result = Module::where('mod_project_id', $project_id)->get();
        return $result;
	}

	public function makeUniqueCode()
    {
        $code = uniqid();
        return $code;
    }


	public function getById($value)
	{
		$result = Permission::where('per_id', $value)->first();
		if($result !== null) {
			$result->modules = $this->getModuleCode($result->per_modules_id);
		}
		return $result;
	}

	public function getModuleCode($value)
	{
		$result = Module::whereIn('mod_id', explode(',', $value))->get();
		return $result;
	}
}