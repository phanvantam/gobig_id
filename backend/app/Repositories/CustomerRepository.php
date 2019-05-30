<?php

namespace App\Repositories;
 
use App\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface 
{
    
    public function getByFilter($per = 10,$name)
    {
        $result = Customer::
                    where('cus_name', 'LIKE', "%{$name['key_name']}%")
                    ->paginate($per);
        return $result;
    }
    
    public function add($input)
    {
        $data = [
            'cus_name'=> $input['name'],
            'cus_avatar'=> $input['avatar'],
            'cus_facebook_id'=> $input['facebook_id'],
            'cus_fanpage_id'=> $input['fanpage_id'],
        ];
        return Customer::insertGetId($data);
    }

    public function checkIssetByFacebookId($value)
    {
        $result = Customer::where('cus_facebook_id', $value)->count();
        return $result === 0 ? false : true;
    }

    public function getById($value)
    {
        $result = Customer::where('cus_id', $value)->first();
        return $result;
    }

    public function getByFacebookId($value)
    {
        $result = Customer::where('cus_facebook_id', $value)->first();
        return $result;
    }

}	
