<?php 

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	protected $defaultIncludes  = [
        'type',
    ];

    public function transform($item)
    {
        return [
            'id' 	=> $item->use_id,
            'name'	=> $item->use_name,
            'mail'	=> $item->use_mail,
            'token'	=> $item->use_token,
        ];
    }

    public function includeType($item)
    {
    	$type = $item->type;
    	return $type ? $this->item($type, new TypeTransformer) : $this->null();
    }
}