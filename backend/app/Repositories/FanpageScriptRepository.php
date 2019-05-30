<?php

namespace App\Repositories;
 
use App\Repositories\FanpageScriptRepositoryInterface;
use App\Models\FanpageScript;
use App\Models\Script;

class FanpageScriptRepository implements FanpageScriptRepositoryInterface 
{

    public function add($input)
    {
        $data = [
            'fas_method'=> $input['method'],
            'fas_fanpage_id'=> $input['fanpage_id'],
            'fas_data'=> $input['data'],
            'fas_script_id'=> $input['script_id'],
        ];
        return FanpageScript::insertGetId($data);
    }

    public function update($id, $input)
    {
        $data = [
            'fas_method'=> $input['method'],
            'fas_data'=> $input['data'],
            'fas_script_id'=> $input['script_id'],
        ];
        return FanpageScript::where('fas_id', $id)->update($data);
    }

    public function getByFanpageIdAndMethodKeyword($fanpage_id)
    {
        $result = FanpageScript::where('fas_fanpage_id', $fanpage_id)
                                ->where('fas_method', 'keyword')
                                ->leftJoin('script', 'scr_id', 'fas_script_id')
                                ->get();
        return $result;
    }

    public function searchScript($q)
    {
        $result = Script::limit(5);
        if(!empty($q)) {
            $result = $result->where('scr_name', 'LIKE', "%{$q}%");
        }
        return $result->get();
    }

    public function getByFanpageIdAndScriptId($fanpage_id, $script_id)
    {
        $result = FanpageScript::where('fas_fanpage_id', $fanpage_id)->where('fas_script_id', $script_id)->get();
        return $result;
    }

    public function removeByFanpageIdAndMethodKeyword($fanpage_id)
    {
        FanpageScript::where('fas_fanpage_id', $fanpage_id)->where('fas_method', 'keyword')->delete();
    }

    public function getByFanpageIdAndMethodStarted($fanpage_id)
    {
        $result = FanpageScript::where('fas_fanpage_id', $fanpage_id)->where('fas_method', 'started')->first();
        return $result;
    }

    public function getById($value)
    {
        $result = FanpageScript::where('fas_id', $value)->first();
        return $result;
    }


    public function getByFanpageIdAndKeyword($fanpage_id, $keyword)
    {
        $result = FanpageScript::where('fas_fanpage_id', $fanpage_id)
                                ->where('fas_data', 'LIKE', "%|{$keyword}|%")
                                ->where('fas_method', 'keyword')
                                ->first();
        return $result;
    }

    public function removeByFanpageIdAndMethodStarted($fanpage_id)
    {
        FanpageScript::where('fas_fanpage_id', $fanpage_id)->where('fas_method', 'started')->delete();
    }

    public function getByFilter($fanpage_id)
    {
        $result = FanpageScript::where('fas_fanpage_id', $fanpage_id)
                                ->leftJoin('script', 'scr_id', 'fas_script_id')
                                ->get();
        return $result;
    }

}	
