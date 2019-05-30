<?php

namespace App\Http\Controllers;

use App\Repositories\ScriptRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Repositories\WebhookRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\FanpageRepositoryInterface;
use App\Repositories\FanpageScriptRepositoryInterface;
use App\Repositories\FacebookRepositoryInterface;
use App\Repositories\ScriptProcessRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\WebhookLog;

class WebhookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $script;
    protected $block;
    protected $request;
    protected $webhook;
    protected $customer;
    protected $fanpage;
    protected $fanpage_script;
    private $script_process;

    public function __construct(
        ScriptRepositoryInterface $script,
        Request $request,
        BlockRepositoryInterface $block,
        CustomerRepositoryInterface $customer,
        FanpageRepositoryInterface $fanpage,
        FanpageScriptRepositoryInterface $fanpage_script,
        FacebookRepositoryInterface $facebook,
        ScriptProcessRepositoryInterface $script_process,
        WebhookRepositoryInterface $webhook
    ) {
        $this->script = $script;
        $this->block  = $block;
        $this->request  = $request;
        $this->webhook  = $webhook;
        $this->customer  = $customer;
        $this->fanpage  = $fanpage;
        $this->fanpage_script  = $fanpage_script;
        $this->facebook  = $facebook;
        $this->script_process = $script_process;
    }

    public function index()
    {
        if($this->request->input('hub_verify_token') === env('FB_WEBHOOK_KEY')) {
            return $this->request->input('hub_challenge');
        }
    }
    
    public function reply()
    {
        $this->addLog();
        $data = [
            'sender_id'=> $this->request->json('entry.0.messaging.0.sender.id'),
            'message'=> trim($this->request->json('entry.0.messaging.0.message.text')),
            'payload'=> $this->request->json('entry.0.messaging.0.postback.payload'),
            'fanpage_id'=> $this->request->json('entry.0.messaging.0.recipient.id'),
        ];

        $fanpage = $this->fanpage->getByFacebookId($data['fanpage_id']);
        if($fanpage === null) {
            return 'hehe';
        }
        if(!$this->customer->checkIssetByFacebookId($data['sender_id'])) {
            $result = $this->facebook->getUserById($fanpage->fan_token, $data['sender_id']);
            $this->customer->add([
                'name'=> $result['name'],
                'avatar'=> $result['profile_pic'],
                'facebook_id'=> $result['id'],
                'fanpage_id'=> $fanpage->fan_id
            ]);
        }
        $customer = $this->customer->getByFacebookId($data['sender_id']);

        $result = [];
        if(!empty($data['message'])) {
            $data['payload'] = [
                'type'=> 'message',
                'data'=> [
                    'value'=> $data['message']
                ]
            ];
            $data['payload'] = base64_encode(json_encode($data['payload']));
        }

        /*Khởi tạo action*/
        $action = [
            'type'=> null
        ];
        if(!empty($data['payload'])) {
            $payload = json_decode(base64_decode($data['payload']), true);
            if(is_array($payload)) {
                $payload['type'] = empty($payload['type']) ? '' : $payload['type'];
                switch ($payload['type']) {
                    case 'started':
                        $fanpage_script = $this->fanpage_script->getByFanpageIdAndMethodStarted($fanpage->fan_id);
                        if($fanpage_script !== null) {
                            $block = $this->block->getByScriptId($fanpage_script->fas_script_id)->first();
                            $script_process_id = $this->script_process->add([
                                'fanpage_script_id'=> $fanpage_script->fas_id,
                                'block_code'=> $block->blo_code,
                                'customer_id'=> $customer->cus_id
                            ]);
                            $action = [
                                'type'=> 'reply_block',
                                'data'=> [
                                    'script_process_id'=> $script_process_id
                                ]
                            ];
                        }
                    break;
                    case 'next_script_process': 
                        $action = [
                            'type'=> 'reply_block',
                            'data'=> [
                                'script_process_id'=> empty($payload['data']['script_process_id']) ? 0 : $payload['data']['script_process_id']
                            ]
                        ];
                    break;
                    case 'message':
                        $fanpage_script = $this->fanpage_script->getByFanpageIdAndKeyword($fanpage->fan_id, $payload['data']['value']);
                        if($fanpage_script !== null) {
                            $block = $this->block->getByScriptId($fanpage_script->fas_script_id)->first();
                            if($block !== null) {
                                $script_process_id = $this->script_process->add([
                                    'fanpage_script_id'=> $fanpage_script->fas_id,
                                    'block_code'=> $block->blo_code,
                                    'customer_id'=> $customer->cus_id
                                ]);
                                $action = [
                                    'type'=> 'reply_block',
                                    'data'=> [
                                        'script_process_id'=> $script_process_id
                                    ]
                                ]; 
                            }
                        }
                    break;
                }
            }
        }
        // dd($action);
        switch ($action['type']) {
            case 'reply_block': 
                $script_process = $this->script_process->getById($action['data']['script_process_id']);
                // dd($script_process);
                /*Validate script process*/
                if(!empty($script_process) && $script_process->scp_status === 1) {
                    $this->script_process->closeById($action['data']['script_process_id']);
                    define('FB_RECIPIENT_ID', $customer->cus_facebook_id);
                    define('FB_FANPAGE_SCRIPT_ID', $script_process->scp_fanpage_script_id);
                    $result = $this->webhook->replyBlock($fanpage->fan_id, $script_process->scp_block_code);
                }
            break;
        }

        return $this->response($result);
    }

    public function addLog()
    {
        $data = [
            'POST'=> empty($_POST) ? [] : $_POST,
            'GET'=> empty($_GET) ? [] : $_GET,
            'RAW'=> $this->request->json()->all()
        ];
        WebhookLog::insert([
            'wel_method'=> $_SERVER['REQUEST_METHOD'],
            'wel_data'=> base64_encode(json_encode($data))
        ]);
    }

    public function log()
    {
        $result = WebhookLog::paginate(5)->toArray()['data'];
        $data = [];
        foreach ($result as $item) {
            $data[] = [
                'time'=> $item['wel_created_at'],
                'data'=> json_decode(base64_decode($item['wel_data']), true)
            ];
        }
        return $this->response($data);
    }
    
}

