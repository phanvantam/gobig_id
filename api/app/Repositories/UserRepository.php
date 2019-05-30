<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getByFilter()
    {
        $result = User::get();
        return $result;
    }

    public function getByUserId($value)
    {
        $result = User::where('user_id', $value)->first();
        return $result;
    }

    public function add($input)
    {

        //Sử dụng thêm một salt cố định
        $staticSalt = '010101#';

        $data = [
            'user_fullname'=> $input['fullname'],
            'user_password'=> md5($staticSalt.$input['password']),
            'user_email'=> $input['email'],
            'user_phone'=> $input['phone'],
        ];
        return User::insertGetId($data);
    }
}
