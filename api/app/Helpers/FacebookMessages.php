<?php    
namespace App\Helpers;

use App\Helpers\FacebookTemplate;
use App\Models\ScriptProcess;
use App\Models\Customer;
use App\Models\Fanpage;
use App\Models\FanpageScript;
use App\Models\Block;

class FacebookMessages {
	private $customer;
	private $fanpage;
	private $fanpage_script;
	private $block;
	private $templates;

	function __construct() {
		
	}

	private function getProcess($process_id)
	{
		$process = ScriptProcess::where('scp_id', $process_id)
										->where('scp_status', 1)
										->first();

		$this->fanpage_script = FanpageScript::where('fas_id', $process->scp_fanpage_script_id)->first();
		$this->customer = Customer::where('cus_id', $process->scp_customer_id)->first();
		$this->fanpage = Fanpage::where('fan_id', $this->fanpage_script->fas_fanpage_id)->first();
		$this->block = Block::where('blo_code', $process->scp_block_code)->first();
	}

	private function buildTemplate() {
		$facebook_template = new FacebookTemplate($this->fanpage, $this->customer, $this->fanpage_script);
		$templates = json_decode(base64_decode($this->block->blo_templates), true);
		foreach ($templates as $item) {
			switch ($item['type']) {
				case 'text':
					$this->templates[] = $facebook_template->text($item['title'], $item['buttons']);
				break;
				case 'generic':
					$this->templates[] = $facebook_template->generic($item['title'], $item['subtitle'], url($item['image']), $item['buttons']);
				break;
			}
		}
	}

	public function sendMessage($process_id)
	{
		$this->getProcess($process_id);
		$this->buildTemplate();
		dd($this->templates);
	}
}