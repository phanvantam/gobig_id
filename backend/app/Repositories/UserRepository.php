<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Transformers\UserTransformer;
use App\Helpers\Functions;

class UserRepository implements UserRepositoryInterface
{   
    public function search($data)
    {
        $user = new User;
        foreach ($data as $key => $value) {
            $user = $user->where($key,$value);
        }
        return $user->first();
    }

    public function index($filter)
    {
        $data = User::where('use_name', 'LIKE', "%{$filter['s']}%")
            ->orderBy('use_updated_at')
            ->paginate(10);
        return [
            'data' => Functions::transformer($data,0,new UserTransformer,'type'),
            'paginate' => [
                'current'=> $data->currentPage(),
                'total'=> $data->lastPage(),
                'per'=> $data->perPage(),
            ]
        ];
    }

    public function find($id)
    {
        return User::where('use_id',$id)->first();
    }

    public function update($id,$data)
    {
        return User::where('use_id',$id)->update($data);
    }

    public function firstOrCreate($find,$data = [])
    {
        return User::firstOrCreate($find,$data);
    }
}
