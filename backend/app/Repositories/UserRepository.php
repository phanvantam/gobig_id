<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\User;

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

    public function getByCode($value)
    {
        $result = User::where('use_code', $value)->first();
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
            'use_salt'=> $input['salt'],
            'use_code'=> $input['code'],
            'use_password_code'=> $input['password_code'],
            'use_salt'=> $input['salt'],
        ];
        $record_id = User::insertGetId($data);
        return $record_id;
    }
}
