<?php    
namespace App\Helpers;

use App\Models\ScriptProcess;

class FacebookButton {

    private $customer;
    private $fanpage;
    private $fanpage_script;

    function __construct($fanpage, $customer, $fanpage_script) {
        $this->fanpage = $fanpage;    
        $this->customer = $customer;
        $this->fanpage_script = $fanpage_script;
    }

    public function build($data) {
        $result = [];
        foreach ($data as $item) {
            switch ($item['type']) {
                case 'url':
                    $result[] = $this->url($item['label'], $item['url']);
                break;
                case 'call':
                    $result[] = $this->call($item['label'], $item['phone']);
                break;
                case 'reply_block':
                    $result[] = $this->replyBlock($item['label'], $item['block']);
                break;
                case 'form_data':
                    $result[] = $this->formData($item['label'], $item['block'], $item['form']);
                break;
            }            
        }
        return $result;
    }

    private function url($label, $link) {
        return [
            'type'=> 'web_url',
            'title'=> $label,
            'url'=> $link
        ];
    }

    private function call($label, $phone) {
        return [
            'type'=> 'phone_number',
            'title'=> $label,
            'payload'=> $phone
        ];
    }

    private function replyBlock($label, $block_code)
    {
        $process_data = [
            'scp_fanpage_script_id' => $this->fanpage_script->fas_id,
            'scp_block_code'        => $block_code,
            'scp_customer_id'       => $this->customer->cus_id,
            'scp_status'=> 1
        ];
        $process_id = 1;//ScriptProcess::insertGetId($process_data);
        return [
            'type'=> 'postback',
            'title'=> $label,
            'payload'=> base64_encode(json_encode([
                'type'=> 'next_script_process',
                'data'=> [
                    'script_process_id'=> $process_id,
                ]
            ]))
        ];
    }

    private function formData($label, $block_code, $form_id)
    {
        $process_data = [
            'scp_fanpage_script_id' => $this->fanpage_script->fas_id,
            'scp_block_code'        => $block_code,
            'scp_customer_id'       => $this->customer->cus_id,
            'scp_status'=> 1
        ];
        $process_id = 1;//ScriptProcess::insertGetId($process_data);
        return [
            'type'=> 'web_url',
            'title'=> $label,
            'url'=> "http://localhost:8080/#/nhap-lieu/them-gia-tri/?form={$form_id}&scp_id={$process_id}&customer_id={$this->customer->cus_id}"
        ];
    }

}