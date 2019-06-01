<?php

namespace App\Http\Controllers;

use App\Repositories\TypeRepositoryInterface;
use App\Http\Requests\TypeRequest;

class TypeController extends Controller
{
	public function __construct(TypeRepositoryInterface $type)
    {
        $this->type = $type;
    }

	public function index(TypeRequest $request)
	{
		$filter = [
			's' => $request->input('s','')
		];
		$data = $this->type->index($filter);
		return $this->response($data);
	}

	public function createType(TypeRequest $request)
	{
		$data = $this->type->firstOrCreate([
			'typ_name' => $request->input('name','')
		]);
		return $this->response();
	}
}
