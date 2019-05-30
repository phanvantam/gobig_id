<?php

namespace App\Http\Controllers;

use App\Repositories\ScriptRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Http\Requests\ScriptRequest;

class ScriptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $script;
    protected $block;
    protected $request;

    public function __construct(
        ScriptRepositoryInterface $script,
        ScriptRequest $request,
        BlockRepositoryInterface $block
    ) {
        $this->script = $script;
        $this->block  = $block;
        $this->request  = $request;
    }

    public function index()
    {
        $name = [
            'key_name' => $this->request->input('key_name','')
        ];
        $result = $this->script->getByFilter(1, $name);
        $pageScript = [
            'script' => $result->all(),
            'paginate' => [
                'total_page' => ceil($result->total()/$result->perPage()),
                'current_page' => $result->currentPage(),
            ]
        ];
        return $this->response($pageScript);
    }
    
    public function add()
    {

        $data = [
            'name'=> $this->request->json('script.name'),
            'description'=> $this->request->json('script.description'),
            'blocks'=> $this->request->json('blocks'),
        ];
        $this->script->add($data);
        return $this->response();
    }

    public function edit($script_id)
    {
        $data = [
            'name'=> $this->request->json('script.name'),
            'description'=> $this->request->json('script.description'),
            'blocks'=> $this->request->json('blocks'),
        ];
        $this->script->updateById($script_id, $data);
        return $this->response();
    }

    public function formData()
    {
        $result = $this->script->getListFormData();

        $data = [];
        foreach ($result as $item) {
            $tmp = [
                "title"=> $item->fod_title,
                "id"=> $item->fod_id,
                "fields"=> []
            ];
            $fields = json_decode(base64_decode($item->fod_fields), true);
            foreach ($fields as $value) {
                $tmp['fields'][] = [
                    'title'=> $value['data']['title'],
                    'code'=> $value['data']['code'],
                    'id'=> $item->fod_id
                ];
            }
            $data[] = $tmp;
        }
        return $this->response($data);
    }

    public function beforeEdit($script_id)
    {
        $script = $this->script->getById($script_id);
        $blocks = $this->block->getByScriptId($script_id);
        $result = [
            'script'=> [
                'id'=> $script->scr_id,
                'name'=> $script->scr_name,
                'description'=> $script->scr_description,
            ],
            'blocks'=> []
        ];
        foreach ($blocks as $item) {
            $templates = [];
            foreach (json_decode(base64_decode($item->blo_templates), true) as $template) {
                switch ($template['type']) {
                    case 'generic':
                        $templates[] = [
                            'error'=> false,
                            'code'=> md5(time() . rand(0, time())),
                            'image_base64'=> null,
                            'type'=> $template['type'],
                            'title'=> $template['title'],
                            'image'=> url($template['image']),
                            'subtitle'=> $template['subtitle'],
                            'buttons'=> $template['buttons'],
                        ];
                    break;
                    case 'text':
                        $templates[] = [
                            'error'=> false,
                            'code'=> md5(time() . rand(0, time())),
                            'type'=> $template['type'],
                            'title'=> $template['title'],
                            'buttons'=> $template['buttons'],
                        ];
                    break;
                }
            }
            $result['blocks'][] = [
                'code'=> $item->blo_code,
                'title'=> $item->blo_title,
                'error'=> false,
                'templates'=> $templates,
            ];
        }
        return $this->response($result);
    }
    
}
