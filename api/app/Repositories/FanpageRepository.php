<?php

namespace App\Repositories;
 
use App\Repositories\FanpageRepositoryInterface;
use App\Models\Fanpage;

class FanpageRepository implements FanpageRepositoryInterface 
{
    public function getByFilter($per = 10,$name)
    {
        $result = Fanpage::where('fan_name', 'LIKE', "%{$name['key_name']}%")
                        ->paginate($per);
        return $result;
    }
    
    public function getByFacebookId($value)
    {
        $result = Fanpage::where('fan_facebook_id', $value)->first();
        return $result;
    }

    public function getById($value)
    {
        $result = Fanpage::where('fan_id', $value)->first();
        return $result;
    }

}	
