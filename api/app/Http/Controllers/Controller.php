<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function response($data=[])
    {
    	return response()->json([
    		'status'=> 1,
    		'data'=> $data
    	]);
    }
}
