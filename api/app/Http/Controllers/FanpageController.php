<?php

namespace App\Http\Controllers;

use App\Repositories\ScriptRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Repositories\FanpageRepositoryInterface;
use App\Repositories\FacebookRepositoryInterface;
use App\Repositories\FanpageScriptRepositoryInterface;
use App\Repositories\ScriptProcessRepositoryInterface;
use App\Http\Requests\FanpageRequest;

class FanpageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $script;
    protected $block;
    protected $fanpage;
    protected $facebook;
    protected $fanpage_script;
    protected $request;
    protected $script_process;

    public function __construct(
        ScriptRepositoryInterface $script,
        BlockRepositoryInterface $block,
        FanpageRepositoryInterface $fanpage,
        FacebookRepositoryInterface $facebook,
        FanpageScriptRepositoryInterface $fanpage_script,
        ScriptProcessRepositoryInterface $script_process,
        FanpageRequest $request
    ) {
        $this->script = $script;
        $this->block = $block;
        $this->fanpage = $fanpage;
        $this->facebook = $facebook;
        $this->fanpage_script = $fanpage_script;
        $this->request = $request;
        $this->script_process = $script_process;
    }

    public function index()
    {
        $name = [
            'key_name' => $this->request->input('key_name','')
        ];
        $result = $this->fanpage->getByFilter(1, $name);
        $pageFanpage = [
            'fanpages' => $result->all(),
            'paginate' => [
                'total_page' => ceil($result->total()/$result->perPage()),
                'current_page' => $result->currentPage(),
            ]
        ];
        return $this->response($pageFanpage);
    }
    
    public function scriptStartedAdd($fanpage_id)
    {
        $script_id = $this->request->json('script_id');

        $this->fanpage_script->removeByFanpageIdAndMethodStarted($fanpage_id);
        $fanpage = $this->fanpage->getById($fanpage_id);

        if($this->script->checkIssetById($script_id )) {
            $block = $this->block->getByScriptId($script_id)->first();
            $fanpage_script_id = $this->fanpage_script->add([
                'fanpage_id'=> $fanpage_id,
                'script_id'=> $script_id,
                'method'=> 'started',
                'data'=> '',
            ]);
            $status = $this->facebook->setStarted($fanpage->fan_token);
        } else {
            $status = $this->facebook->removeStarted($fanpage->fan_token);
        }
        return $this->response($status);
    }

    public function scriptStartedBeforeEdit($fanpage_id)
    {
        $result = $this->fanpage_script->getByFanpageIdAndMethodStarted($fanpage_id);

        $result = $this->script->getById($result->fas_script_id);
        $data = [];
        if($result !== null) {
            $data = [
                'id'=> $result->scr_id,
                'name'=> $result->scr_name,
            ];
        }
        
        return $this->response($data);
    }

    // public function editKeyword($fanpage_id)
    // {
    //     $fanpage_script = $this->fanpage_script->getByFanpageIdAndMethodKeyword($fanpage_id);
    //     $result = [];
    //     foreach($fanpage_script as $item) {
    //         $tags = explode('|', rtrim(ltrim($item->fas_data, '|'), '|'));
    //         $result[] = [
    //             'script_id'=> $item->fas_script_id,
    //             'tags'=> $tags,
    //             'tag'=> '',
    //             'keywords'=> $tags
    //         ];
    //     }
    //     return $this->response($result);
    // }

    public function searchScript()
    {
        $q = $this->request->input('q', '');
        $result = $this->fanpage_script->searchScript($q);

        $data = [];
        foreach ($result as $item) {
            $data[] = [
                'id'=> $item->scr_id,
                'name'=> $item->scr_name,
            ];
        }
        return $this->response($data);
    }

    public function scriptKeywordBeforeEdit($id)
    {
        $result = $this->fanpage_script->getById($id);
        $data = [
            "id"=> $result->fas_id,
            "keywords"=> explode('|', rtrim(ltrim($result->fas_data, '|'), '|')),
        ];
        $result = $this->script->getById($result->fas_script_id);
        $data['script'] = [
            'id'=> $result->scr_id,
            'name'=> $result->scr_name,
        ];
        return $this->response($data);
    }

    public function scriptKeyword($fanpage_id)
    {
        $fanpage_script = $this->fanpage_script->getByFanpageIdAndMethodKeyword($fanpage_id);
        $result = [];
        foreach($fanpage_script as $item) {
            $tags = explode('|', rtrim(ltrim($item->fas_data, '|'), '|'));
            $result[] = [
                'script_name'=> $item->scr_name,
                'tags'=> $tags,
                'id'=> $item->fas_id,
                'created_at'=> $item->fas_created_at,
            ];
        }
        return $this->response($result);
    }

    public function scriptKeywordAdd($fanpage_id)
    {
        $script_id = $this->request->json('script_id');
        $keywords = $this->request->json('keywords');

        $fanpage = $this->fanpage->getById($fanpage_id);
        $keywords = explode('|', $keywords);

        foreach ($keywords as $stt => &$value) {
            $keywords[$stt] = trim($value); 
        }
        $this->fanpage_script->add([
            'fanpage_id'=> (int) $fanpage_id,
            'script_id'=> $script_id,
            'method'=> 'keyword',
            'data'=> '|'. implode($keywords, '|') .'|'
        ]);
        return $this->response();
    }

    public function scriptKeywordEdit($id)
    {
        $script_id = $this->request->json('script_id');
        $keywords = $this->request->json('keywords');

        $keywords = explode('|', $keywords);

        foreach ($keywords as $stt => &$value) {
            $keywords[$stt] = trim($value); 
        }
        $this->fanpage_script->update($id, [
            'script_id'=> $script_id,
            'method'=> 'keyword',
            'data'=> '|'. implode($keywords, '|') .'|'
        ]);
        return $this->response();
    }

    public function listScriptConnect($fanpage_id)
    {
        $result = $this->fanpage_script->getByFilter($fanpage_id);
        return $this->response($result);
    }

    public function scriptProcess($fanpage_script_id)
    {
        $fanpage_script = $this->fanpage_script->getById($fanpage_script_id);
        $blocks = $this->block->getByScriptId($fanpage_script->fas_script_id);

        $result = [];
        foreach ($blocks as $item) {
            $result[] = [
                'block'=> [
                    'name'=> $item->blo_title
                ],
                'total_customer'=> $this->script_process->countByBlockCodeAndFanpageScriptId($item->blo_code, $fanpage_script_id)
            ];
        }
        return $this->response($result);
    }
}
