<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
	
    public function makePasswordCode($password, $salt)
    {
        $value = md5(implode('.', [$password, $salt]));
        return $value;
    }

    public function verifyInfoUser($email, $password)
    {
        $result = null;
        $user = User::where('use_email', $email)->first();
        if($user !== null) {
            $result = $user->use_password_code === $this->makePasswordCode($password, $user->use_salt) ? $user : null;
        }
        return $result;
    }

}
