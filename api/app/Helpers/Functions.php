<?php    
namespace App\Helpers;

use League\Fractal;

class Functions {

    public static function arrayGet($input, $key, $default = null)
    {
        if (is_null($key)) {
            return $input;
        }
        $arr = explode('.', $key);
        foreach ($arr as $k) {
            $input = isset($input[$k]) ? $input[$k] : null;
        }
        if (is_null($input)) {
            return $default;
        }
        return $input;
    }

    public static function transformer($data,$type,$transformer,$include = '')
    {
        $value = $type == 1 ? new Fractal\Resource\Item($data,$transformer) : new Fractal\Resource\Collection($data,$transformer);
        $manager = new Fractal\Manager();
        $manager->setSerializer(new DataArraySerializer());
        if($include)
        {
            $manager->parseIncludes($include);
        }
        return $manager->createData($value)->toArray();
    }
}