<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepositoryInterface;
use App\Http\Requests\AuthRequest;
use App\Helpers\TokenJWT;

class AuthController extends Controller
{
	public function __construct(
		AuthRepositoryInterface $auth,
		AuthRequest $request,
		TokenJWT $token_jwt
	){
        $this->auth = $auth;
        $this->request = $request;
        $this->token_jwt = $token_jwt;
    }

	public function login()
	{
		$request = [
            'email'=> $this->request->json('email'),
            'password'=> $this->request->json('password'),
        ];
        $result = $this->auth->verifyInfoUser($request['email'], $request['password']);
        if($result !== null) {
        	$payload = [
        		'user_code'=> $result->use_code,
        		'user_fullname'=> $result->use_fullname,
        		'user_email'=> $result->use_email,
        	];
        	$token = $this->token_jwt->create($payload);
        	return $this->response([
                'exp'=> (int) env('TOKEN_JWT_TIME_EXP'),
        		'type_token'=> 'Bearer',
        		'access_token'=> $token
        	]);
        } else {
			return $this->response(null, 0);
        }
	}
}
