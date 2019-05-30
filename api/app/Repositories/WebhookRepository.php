<?php

namespace App\Repositories;
 
use App\Repositories\FanpageRepositoryInterface;
use App\Repositories\FacebookRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
use App\Repositories\ScriptProcessRepositoryInterface;
use App\Repositories\WebhookRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;

class WebhookRepository implements WebhookRepositoryInterface {
    
    private $block;
    private $facebook;
    private $fanpage;
    private $script_process;
    private $customer;

    public function __construct(
        BlockRepositoryInterface $block, 
        FacebookRepositoryInterface $facebook, 
        FanpageRepositoryInterface $fanpage,
        CustomerRepositoryInterface $customer,
        ScriptProcessRepositoryInterface $script_process
    ) {
        $this->block = $block;
        $this->fanpage = $fanpage;
        $this->facebook = $facebook;
        $this->script_process = $script_process;
        $this->customer = $customer;
    }

    public function replyBlock($fanpage_id, $block_code)
    {
        $fanpage = $this->fanpage->getById($fanpage_id);
        $block = $this->block->getByCode($block_code);
        $result = null;
        if($block !== null) {
            $templates = json_decode(base64_decode($block->blo_templates), true);
            foreach ($templates as $item) {
                switch ($item['type']) {
                    case 'text':
                        $result = $this->facebook->sendTemplateText($fanpage->fan_token, $item);
                    break;
                    case 'generic':
                        $result = $this->facebook->sendTemplateGeneric($fanpage->fan_token, $item);
                    break;
                }
            }
        }
        
        return $result;
    }



}	
