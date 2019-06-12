<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function response($data=[],$status = 1)
    {
    	return response()->json([
    		'status'=> $status,
    		'data'=> $data
    	]);
    }
}
