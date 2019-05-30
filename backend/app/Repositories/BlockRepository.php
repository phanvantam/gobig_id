<?php

namespace App\Repositories;
 
use App\Repositories\BlockRepositoryInterface;
use App\Models\Block;

class BlockRepository implements BlockRepositoryInterface 
{

    public function add($input)
    {
        $blocks = $input['blocks'];
        $script_id = $input['script_id'];
        $data = [];
        foreach ($blocks as $stt => $item) { 
            $templates = [];
            foreach ($item['templates'] as $template) {
                switch ($template['type']) {
                    case 'generic':
                        $templates[] = [
                            'type'=> $template['type'],
                            'title'=> $template['title'],
                            'image'=> empty($template['image_base64']) ? ltrim($template['image'], url()) : $this->saveImageFromBase64($template['image_base64']),
                            'subtitle'=> $template['subtitle'],
                            'buttons'=> $template['buttons'],
                        ];
                    break;
                    case 'text':
                        $templates[] = [
                            'type'=> $template['type'],
                            'title'=> $template['title'],
                            'buttons'=> $template['buttons'],
                        ];
                    break;
                }
            }
            $data[] = [
                'blo_code'=> $item['code'],
                'blo_stt'=> $stt+1,
                'blo_title'=> $item['title'],
                'blo_templates'=> base64_encode(json_encode($templates)),
                'blo_script_id'=> $script_id
            ];
        }
        Block::insert($data);
    }

    public function saveImageFromBase64($value) {
        list($type, $value) = explode(';', $value);
        list(,$extension) = explode('/',$type);
        list(,$value)      = explode(',', $value);
        $path = 'images/'. uniqid().'.'.$extension;
        $value = base64_decode($value);
        file_put_contents(storage_path($path), $value);
        return $path;
    }
    
    public function getByCode($block_code)
    {
        $result = Block::where('blo_code', $block_code)->first();
        return $result;
    }

    public function checkIssetByCode($block_code)
    {
        $result = Block::where('blo_code', $block_code)->count();
        return $result > 0 ? true : false;
    }

    public function getByScriptId($script_id)
    {
        $result = Block::where('blo_script_id', $script_id)->orderBy('blo_stt', 'ASC')->get();
        return $result;
    }

    public function removeByScriptId($script_id)
    {
        Block::where('blo_script_id', $script_id)->delete();
    }


}	
