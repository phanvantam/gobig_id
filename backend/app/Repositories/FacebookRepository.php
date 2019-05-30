<?php

namespace App\Repositories;
 
use App\Repositories\FacebookRepositoryInterface;
use App\Repositories\ScriptProcessRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\FormDataRepositoryInterface;

class FacebookRepository implements FacebookRepositoryInterface 
{
    private $script_process;
    private $customer;
    private $form_data;

    public function __construct(
        CustomerRepositoryInterface $customer,
        FormDataRepositoryInterface $form_data,
        ScriptProcessRepositoryInterface $script_process
    ) {
        $this->script_process = $script_process;
        $this->customer = $customer;
        $this->form_data = $form_data;
    }

    public function getUserById($token, $value)
    {
        $url = $this->getUrl($token, [$value], ['fields'=> 'name,profile_pic']);
        return $this->curlRequest($url);
    }

    protected function curlRequest($url, $method='GET', $data=[])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            break;
        }

        $result=curl_exec ($ch);
        
        return json_decode($result, true);
    }

    protected function getUrl($token, $fields =[], $params =[]) 
    {
        $params['access_token'] = $token;
        $params = http_build_query($params);
        $fields  = implode('/', $fields);
        $base_url = 'https://graph.facebook.com';
        return $base_url ."/{$fields}?{$params}";
    }

    public function makeButton($buttons)
    {
        $result = [];
        foreach ($buttons as $item) {
            switch ($item['type']) {
                case 'reply_block':
                    $result[] = $this->buttonReplyBlock([
                        'title'=> $item['label'],
                        'block'=> $item['block'],
                    ]);
                break;
                case 'call':
                    $result[] = $this->buttonCall([
                        'title'=> $item['label'],
                        'phone'=> $item['phone'],
                    ]);
                break;
                case 'url':
                    $result[] = $this->buttonUrl([
                        'title'=> $item['label'],
                        'url'=> $item['url'],
                    ]);
                break;
                case 'share':
                    $result[] = $this->buttonShare();
                break;
                case 'form_data':
                    $result[] = $this->formData([
                        'title'=> $item['label'],
                        'form'=> $item['form'],
                        'block'=> $item['block'],
                    ]);
                break;
            }
        }
        return $result;
    }

    public function setStarted($token, $payload=['type'=> 'started'])
    {
        $data = [
            "get_started"=> [
                "payload"=> base64_encode(json_encode($payload))
            ]
        ];
        $url = $this->getUrl($token, ['v2.6', 'me', 'messenger_profile']);
        return $this->curlRequest($url, 'POST', $data);
    }

    public function removeStarted($token)
    {
        $data = [
            "fields"=> ["get_started"]
        ];
        $url = $this->getUrl($token, ['v2.6', 'me', 'messenger_profile']);
        return $this->curlRequest($url, 'DELETE', $data);
    }

    public function sendTemplateText($token, $input) {
        $data = [
            'recipient'=> [
                'id'=> FB_RECIPIENT_ID
            ],
            'message'=> []
        ];

        if(count($input['buttons'])) {
            $buttons = $this->makeButton($input['buttons']);
            $data['message'] = [
                'attachment'=>[
                    'type'=> 'template',
                    'payload'=> [
                        'template_type'=> 'button',
                        'text'=> $this->replaceField($input['title']),
                        'buttons'=> $buttons
                    ]
                ]
            ];
        } else {
            $data['message'] = [
                'text'=> $this->replaceField($input['title'])
            ];
        }
        // dd($data);
        $url = $this->getUrl($token, ['v2.6', 'me', 'messages']);
        return $this->curlRequest($url, 'POST', $data);
    }

    public function replaceField($input)
    {
        $input = [
            'value'     => $input['value'],
            'value_text'=> $input['value_text'],
            'label_data'=> $input['label_data'],
        ];
        $result = $input['value_text'];
        if(!empty($input['label_data'])) {
            foreach ($input['label_data'] as $item) {
                switch ($item['data']['type']) {
                    case 'name':
                        $customer = $this->customer->getByFacebookId(FB_RECIPIENT_ID);
                        $name = $customer === null ? $item['default'] : $customer->cus_name;
                        $result = str_replace('{{'. $item['code'] .'}}', " {$name} ", $result);
                    break;
                    case 'form_data':
                        $customer = $this->customer->getByFacebookId(FB_RECIPIENT_ID);
                        $form_data_value = $this->form_data->getValueByFormDataIdAndCustomerId($item['data']['id'], $customer->cus_id);
                        $values = json_decode(base64_decode($form_data_value->fdv_values), true);
                        $value = $item['default'];
                        foreach ($values as $code => $v) {
                            if($item['data']['code'] === $code) {
                                $value = $v;
                                break;
                            }
                        }
                        $result = str_replace('{{'. $item['code'] .'}}', " {$value} ", $result);
                    break;
                }
            }
        }
        return $result;
    }

    public function sendTemplateGeneric($token, $input) {
        $buttons = $this->makeButton($input['buttons']);
        $data = [
            'recipient'=> [
                'id'=> FB_RECIPIENT_ID
            ],
            'message'=> [
                'attachment'=> [
                    'type'=> 'template',
                    'payload'=> [
                        'template_type'=> 'generic',
                        'elements'=> [
                            [
                                'title'=> $this->replaceField($input['title']),
                                'subtitle'=> $this->replaceField($input['subtitle']),
                                'image_url'=> url($input['image']),
                                'buttons'=> $buttons       
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        $url = $this->getUrl($token, ['v2.6', 'me', 'messages']);
        return $this->curlRequest($url, 'POST', $data);
    }


    protected function buttonReplyBlock($input)
    {
        $customer = $this->customer->getByFacebookId(FB_RECIPIENT_ID);
        $script_process_id = $this->script_process->add([
            'fanpage_script_id'=> FB_FANPAGE_SCRIPT_ID,
            'block_code'=> $input['block'],
            'customer_id'=> $customer->cus_id
        ]);
        return [
            'type'=> 'postback',
            'title'=> $input['title'],
            'payload'=> base64_encode(json_encode([
                'type'=> 'next_script_process',
                'data'=> [
                    'script_process_id'=> $script_process_id,
                ]
            ]))
        ];
    }

    protected function buttonUrl($input)
    {
        return [
            'type'=> 'web_url',
            'title'=> $input['title'],
            'url'=> $input['url']
        ];
    }

    protected function buttonShare()
    {
        return [
            'type'=> 'element_share',
        ];
    }

    protected function buttonCall($input)
    {
        return [
            'type'=> 'phone_number',
            'title'=> $input['title'],
            'payload'=> $input['phone']
        ];
    }

    protected function formData($input)
    {
        $customer = $this->customer->getByFacebookId(FB_RECIPIENT_ID);
        $script_process_id = $this->script_process->add([
            'fanpage_script_id'=> FB_FANPAGE_SCRIPT_ID,
            'block_code'=> $input['block'],
            'customer_id'=> $customer->cus_id,
        ]);
        return [
            'type'=> 'web_url',
            'title'=> $input['title'],
            'url'=> "http://localhost:8080/#/nhap-lieu/them-gia-tri/?form={$input['form']}&scp_id={$script_process_id}&customer_id={$customer->cus_id}"
        ];
    }

    public function send()
    {
        $url = $this->getUrl(['v2.6', 'me', 'messages']);
        return $this->curlRequest($url, 'POST', $this->data_send);
    }

}	
