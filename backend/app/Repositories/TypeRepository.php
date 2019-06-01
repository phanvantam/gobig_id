<?php

namespace App\Repositories;

use App\Models\Type;
use App\Repositories\TypeRepositoryInterface;
use App\Transformers\TypeTransformer;
use App\Helpers\Functions;

class TypeRepository implements TypeRepositoryInterface
{
	public function index($filter)
	{
		$data = Type::where('typ_name', 'LIKE', "%{$filter['s']}%")
            ->orderBy('typ_updated_at')
            ->paginate(10);
        return [
            'data' => Functions::transformer($data,0,new TypeTransformer),
            'paginate' => [
                'current'=> $data->currentPage(),
                'total'=> $data->lastPage(),
                'per'=> $data->perPage(),
            ]
        ];
	}

    public function firstOrCreate($find,$data= [])
    {
        return Type::firstOrCreate($find,$data);
    }
}
