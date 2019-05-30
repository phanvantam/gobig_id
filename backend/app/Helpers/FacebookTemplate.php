<?php    
namespace App\Helpers;

use App\Helpers\FacebookButton;
use App\Models\FormDataValue;

class FacebookTemplate {

    private $customer;
    private $fanpage;
    private $fanpage_script;

    function __construct($fanpage, $customer, $fanpage_script) {
        $this->fanpage = $fanpage;    
        $this->customer = $customer;
        $this->fanpage_script = $fanpage_script;
        $this->facebook_button = new FacebookButton($fanpage, $customer, $fanpage_script); 
    }

    public function text($title, $buttons) {
        $message = $this->replaceField($title['value_text'], $title['label_data']);
        if(empty($buttons)) {
            return [
                'text'=> $message
            ];
        } else {
            return [
                'attachment'=>[
                    'type'=> 'template',
                    'payload'=> [
                        'template_type'=> 'button',
                        'text'=> $message,
                        'buttons'=> $this->facebook_button->build($buttons)
                    ]
                ]
            ];
        }
    }

    public function generic($title, $subtitle, $image, $buttons) {
        return [
            'attachment'=> [
                'type'=> 'template',
                'payload'=> [
                    'template_type'=> 'generic',
                    'elements'=> [
                        [
                            'title'=> $this->replaceField($title['value_text'], $title['label_data']),
                            'subtitle'=> $this->replaceField($subtitle['value_text'], $subtitle['label_data']),
                            'image_url'=> $image,
                            'buttons'=> $this->facebook_button->build($buttons)  
                        ]
                    ]
                ]
            ]
        ];
    }

    private function replaceField($text, $fields)
    {
        $message = $text;
        if(!empty($fields)) {
            foreach ($fields as $item) {
                switch ($item['data']['type']) {
                    case 'name':
                        $message = str_replace('{{'. $item['code'] .'}}', " {$this->customer->cus_name} ", $message);
                    break;
                    case 'form_data':
                        $value = $item['default'];

                        $result = FormDataValue::where('fdv_form_data_id', $item['data']['id'])
                                    ->where('fdv_customer_id', $this->customer->cus_id)
                                    ->first();
                        if($result === null) {
                            $result = json_decode(base64_decode($result->fdv_values), true);
                            foreach ($result as $code => $v) {
                                if($item['data']['code'] === $code) {
                                    $value = $v;
                                    break;
                                }
                            }
                        }
                        $message = str_replace('{{'. $item['code'] .'}}', " {$value} ", $message);
                    break;
                }
            }
        }
        return $message;
    }

}