<?php 

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        return [
            'id' 	=> $item->typ_id,
            'name'	=> $item->typ_name,
        ];
    }
}