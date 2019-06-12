<?php

namespace App\Repositories;

use App\Repositories\PermissionRepositoryInterface;
use App\Models\Permission;
use App\Models\Module;

class PermissionRepository implements PermissionRepositoryInterface
{  
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