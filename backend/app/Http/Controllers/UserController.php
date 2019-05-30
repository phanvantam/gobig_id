<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    protected $request;

    public function __construct(
        UserRepositoryInterface $user,
        Request $request
    )
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function index()
    {
        $result = $this->user->getByFilter();
        return $this->response($result);
    }

    public function add()
    {
        $data = [
            'fullname' => $this->request->json('fullname'),
            'password' => $this->request->json('password'),
            'email' => $this->request->json('email'),
            'phone' => $this->request->json('phone'),
        ];
        $this->user->add($data);
        return $this->response();
    }
}
