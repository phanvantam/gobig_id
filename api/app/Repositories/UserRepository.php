<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\Position;
use App\Models\User;
use App\Models\UserChild;
use App\Models\UserPermission;

class UserRepository implements UserRepositoryInterface
{   

    public function getByFilter($params=[])
    {
        $query = new User;
        if($params['fullname'] !== null) {
            $query = $query->where('use_fullname', 'LIKE', "%{$params['fullname']}%");
        }
        $result = $query->with('position')->paginate($params['per']);
        return $result;
    }

    public function search($params)
    {
        $query = new User;
        if(!empty($params['query'])) {
            $query = $query->where('use_fullname', 'LIKE', "%{$params['query']}%");
            $query = $query->orWhere('use_email', 'LIKE', "%{$params['query']}%");
        }
        $result = $query->skip(0)->take(5)->get();
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

    public function getChild($value)
    {
        $result = UserChild::where('usc_parent_id', $value)->leftJoin('users', 'use_id', 'usc_child_id')->get();
        return $result;
    }

    public function childRemove($value)
    {
        UserChild::where('usc_id', $value)->delete();
    }

    public function removeChildByChildId($value)
    {
        UserChild::where('usc_child_id', $value)->delete();
    }

    public function childCreate($input)
    {
        $data = [
            'usc_parent_id'=> $input['parent_id'],
            'usc_child_id'=> $input['child_id']
        ];
        $record_id = UserChild::insertGetId($data);
        return $record_id;
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
            'use_position_id'=> $input['position_id'],
            'use_code'=> $input['code'],
            'use_password_code'=> $input['password_code'],
            'use_salt'=> $input['salt'],
        ];
        $record_id = User::insertGetId($data);
        return $record_id;
    }

    public function master($position_id) {
        $result = User::whereIn('use_position_id', function($query) use($position_id) {
            $query->select('pos_id')
            ->from(with(new Position)->getTable())
            ->where('pos_level', '<', function($query) use($position_id) {
                $query->select('pos_level')
                ->from(with(new Position)->getTable())
                ->where('pos_id', $position_id);
            });
        })->with('position')->get();
        return $result;
    }
   
    public function updateById($id, $input)
    {
        $data = [
            'use_fullname'=> $input['fullname'],
            'use_email'=> $input['email'],
            'use_position_id'=> $input['position_id'],
        ];
        if(!empty($input['password_code'])) {
            $data['use_password_code'] = $input['password_code'];
            $data['use_salt'] = $input['salt'];
        }
        User::where('use_id', $id)->update($data);
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

    public function permissionGetByProjectAndUser($project_id, $user_id)
    {
        return UserPermission::where('usp_project_id', $project_id)->where('usp_user_id', $user_id)->first();
    }
}
