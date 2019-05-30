<?php

namespace App\Repositories;
 
use App\Repositories\ScriptProcessRepositoryInterface;
use App\Repositories\BlockRepositoryInterface;
// use App\Repositories\FanpageRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
// use App\Repositories\FacebookRepositoryInterface;
use App\Models\ScriptProcess;

class ScriptProcessRepository implements ScriptProcessRepositoryInterface {
    
    private $block;
    private $customer;
    private $fanpage;
    private $facebook;

    public function __construct(
        BlockRepositoryInterface $block,
        // FanpageRepositoryInterface $fanpage,
        CustomerRepositoryInterface $customer
        // FacebookRepositoryInterface $facebook
    ){
        $this->block = $block;
        $this->customer = $customer;
        // $this->fanpage = $fanpage;
        // $this->facebook = $facebook;
    }

    public function add($values)
    {
        $data = [
            'scp_fanpage_script_id' => $values['fanpage_script_id'],
            'scp_block_code'        => $values['block_code'],
            'scp_customer_id'       => $values['customer_id'],
            'scp_status'=> 1
        ];
        return ScriptProcess::insertGetId($data);
    }

    public function closeById($value)
    {
        ScriptProcess::where('scp_id', $value)->update(['scp_status'=> 0]);
    }

    public function nextById($id, $customer_id)
    {
        $script_process = $this->getById($id);
        $customer = $this->customer->getById($customer_id);
        // dd($script_process);
        /*Validate script process*/
        if(!empty($script_process) && $script_process->scp_status === 1) {
            // $this->closeById($id);
            define('FB_RECIPIENT_ID', $customer->cus_facebook_id);
            define('FB_FANPAGE_SCRIPT_ID', $script_process->scp_fanpage_script_id);

            $fanpage = $this->fanpage->getById(1);
            $block = $this->block->getByCode($script_process->scp_block_code);
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

    public function getById($value)
    {
        $result = ScriptProcess::where('scp_id', $value)->first();
        return $result;
    }
    
    public function getByFanpageScriptIdAndCustomerId($fanpage_script_id, $customer_id)
    {
        $result = ScriptProcess::where('scp_fanpage_script_id', $fanpage_script_id)->where('scp_customer_id', $customer_id)->orderBy('scp_created_at', 'DESC')->first();
        return $result;
    }

}	
