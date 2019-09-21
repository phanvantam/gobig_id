<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPermission;

class UserRepository implements UserRepositoryInterface
{   

    public function getByFilter($params=[])
    {
        $query = new User;
        if($params['fullname'] !== null) {
            $query = $query->where('use_fullname', 'LIKE', "%{$params['fullname']}%");
        }
        $result = $query->paginate($params['per']);
        return $result;
    }

    public function search($params)
    {
        $query = new User;
        if(!empty($params['query'])) {
            $query = $query->where('use_fullname', 'LIKE', "%{$params['query']}%");
            $query = $query->orWhere('use_email', 'LIKE', "%{$params['query']}%");
            $query = $query->orWhere('use_code', 'LIKE', "%{$params['query']}%");
        }
        $result = $query->skip(0)->take(10)->get();
        return $result;
    }

    public function getByCode($value)
    {
        $result = User::where('use_code', $value)->first();
        return $result;
    }

    public function getById($value)
    {
        $result = User::where('use_id', $value)->first();
        return $result;
    }

    public function makeUniqueCode()
    {
        $code = uniqid("ID_", true);
        return $code;
    }

    public function makeSaltCode()
    {
        $salt = md5($this->makeUniqueCode());
        return $salt;
    }

    public function makePasswordCode($password, $salt)
    {
        $value = md5(implode('.', [$password, $salt]));
        return $value;
    }

    public function create($input)
    {
        $data = [
            'use_fullname'=> $input['fullname'],
            'use_email'=> $input['email'],
            'use_code'=> $input['code'],
            'use_master_id'=> $input['master_id'],
            'use_password_code'=> $input['password_code'],
            'use_salt'=> $input['salt'],
        ];
        $record_id = User::insertGetId($data);
        return $record_id;
    }

    public function updateById($id, $input)
    {
        $data = [
            'use_fullname'=> $input['fullname'],
            'use_email'=> $input['email'],
            'use_master_id'=> $input['master_id'],
        ];
        if(!empty($input['password_code'])) {
            $data['use_password_code'] = $input['password_code'];
            $data['use_salt'] = $input['salt'];
        }
        User::where('use_id', $id)->update($data);
    }

    public function updateLocationById($id, $values)
    {
        $data = [
            'use_location'=> implode('.', $values),
        ];
        User::where('use_id', $id)->update($data);
    }

    public function getByLocation($value, $fields=['*'])
    {
        return User::select($fields)->where('use_location','LIKE', "{$value}.%")->get();
    }

    public function children($params=[])
    {
        $query = User::where('use_location','LIKE', "{$params['location']}.%");
        if($params['fullname'] !== null) {
            $query = $query->where('use_fullname', 'LIKE', "%{$params['fullname']}%");
        }
        $result = $query->paginate($params['per']);
        return $result;
    }

    public function updateProfileById($id, $input)
    {
        $data = [
            'use_fullname'=> $input['fullname'],
        ];
        User::where('use_id', $id)->update($data);
    }

    public function updatePasswordById($id, $input)
    {
        $data = [
            'use_salt'=> $input['salt'],
            'use_password_code'=> $input['password_code'],
        ];
        User::where('use_id', $id)->update($data);
    }


    public function permissionAdd($input)
    {
        $data = [
            'usp_permission_id'=> $input['permission_id'],
            'usp_project_id'=> $input['project_id'],
            'usp_user_id'=> $input['user_id'],
        ];
        $record_id = UserPermission::insertGetId($data);
        return $record_id;
    }

    public function permissionRemoveByProjectAndUser($project_id, $user_id)
    {
        UserPermission::where('usp_project_id', $project_id)->where('usp_user_id', $user_id)->delete();
    }

    public function permissionById($value)
    {
        return UserPermission::where('usp_permission_id', $value)->with('user')->skip(0)->take(10)->get();
    }

    public function permissionGetByProjectAndUser($project_id, $user_id)
    {
        return UserPermission::where('usp_project_id', $project_id)->where('usp_user_id', $user_id)->first();
    }
}
