<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function response($data=[],$code = 200)
    {
    	return response()->json([
    		'code' => $code ,
    		'data' => $data
    	]);
    }
}
