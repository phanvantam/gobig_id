<?php

namespace App\Repositories;
 
use App\Repositories\ScriptRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Models\Script;
use App\Models\FormData;

class ScriptRepository implements ScriptRepositoryInterface {
    
    private $block;

    public function __construct(BlockRepositoryInterface $block)
    {
        $this->block = $block;
    }

    public function getByFilter($per = 10,$name)
    {
        $result = Script::where('scr_name', 'LIKE', "%{$name['key_name']}%")
            ->paginate($per);
        return $result;
    }

    public function getListFormData()
    {
        return FormData::get();
    }

    public function add($input)
    {
        $data = [
            'scr_name'=> $input['name'],
            'scr_description'=> $input['description']
        ];
        $script_id = Script::insertGetId($data);
        $data = [
            'blocks'=> $input['blocks'],
            'script_id'=> $script_id
        ];
        $this->block->add($data);
    }

    public function updateById($script_id, $input)
    {
        $data = [ 
            'scr_name'=> $input['name'],
            'scr_description'=> $input['description'],
        ];
        Script::where('scr_id', $script_id)->update($data);
        
        $this->block->removeByScriptId($script_id);
        $data = [
            'blocks'=> $input['blocks'],
            'script_id'=> $script_id
        ];
        $this->block->add($data);
    }

    public function checkIssetById($script_id)
    {
        $result = Script::where('scr_id', $script_id)->count();
        return $result > 0 ? true : false;
    }

    public function getById($script_id)
    {
        $result = Script::where('scr_id', $script_id)->first();
        return $result;
    }

}	
