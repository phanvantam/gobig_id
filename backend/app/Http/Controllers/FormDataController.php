<?php 

namespace App\Http\Controllers;

use App\Repositories\FormDataRepositoryInterface;
use App\Repositories\ScriptProcessRepositoryInterface;
use App\Http\Requests\FormDataRequest;
use Validator;

class FormDataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $form_data;
    protected $script_process;
    protected $request;

    public function __construct(
        FormDataRepositoryInterface $form_data,
        ScriptProcessRepositoryInterface $script_process,
        FormDataRequest $request
    ) {
        $this->script_process = $script_process;
        $this->form_data = $form_data;
        $this->request = $request;
    }

    public function index()
    {
        $result = $this->form_data->getByFilter();
        return $this->response($result);
    }
    
    public function add()
    {
        $data = [
            'title'=> $this->request->json('title'),
            'description'=> $this->request->json('description'),
            'fields'=> $this->request->json('fields'),
        ];
        $this->form_data->add($data);
        return $this->response();
    }

    public function edit($form_data_id)
    {
        $data = [
            'title'=> $this->request->json('title'),
            'description'=> $this->request->json('description'),
            'fields'=> $this->request->json('fields'),
        ];
        $this->form_data->update($form_data_id, $data);
        return $this->response();
    }

    public function show($form_data_id)
    {
        $form_data = $this->form_data->getById($form_data_id);
        $fields = [];
        if($form_data !== null) {
            $result = json_decode(base64_decode($form_data->fod_fields), true);
            foreach ($result as $item) {
                $tmp = [
                    'label'=> $item['data']['label'],
                    'code'=> $item['data']['code'],
                    'value'=> null,
                ];
                $fields[] = $tmp;
            }
        }
        return $this->response([
            'fields'=> $fields,
            'title' => $form_data->fod_title,
            'description' => $form_data->fod_description,
        ]);
    }

    public function beforeEdit($form_data_id)
    {
        $form_data = $this->form_data->getById($form_data_id);
        return $this->response([
            'fields'=> json_decode(base64_decode($form_data->fod_fields), true),
            'title' => $form_data->fod_title,
            'description' => $form_data->fod_description,
        ]);
    }

    public function addValue($form_data_id)
    {
        $data = [
            'customer_id'=> $this->request->json('customer_id'),
            'form_data_id'=> $form_data_id,
            'scp_id'=> $this->request->json('scp_id'),
            'values'=> $this->request->json('data'),
        ];
        // $validator = [
        //     "data"=> [],
        //     "rules"=> [],
        //     "messages"=> []
        // ];
        // $form_data = $this->form_data->getById($data['form_data_id']);
        // foreach(json_decode(base64_decode($form_data->fod_fields), true) as $item) {
        //     $tmp = [
        //         $item['data']['code'] => null,
        //         "rule"=> null,
        //         "messages"=> []
        //     ];
        //     $rules = [];
        //     switch ($item['data']['null']) {
        //         case 'true':
        //            $rules[] = 'required';
        //            $tmp['messages']["{$item['data']['code']}.required"] = "Vui lòng nhập {$item['data']['label']}";
        //         break;
        //     }
        //     switch ($item['data']['format']) {
        //         case 'int':
        //            $rules[] = 'numeric';
        //            $tmp['messages']["{$item['data']['code']}.numeric"] = "{$item['data']['label']} phải là dạng số";
        //         break;
        //         case 'email':
        //            $rules[] = 'email';
        //            $tmp['messages']["{$item['data']['code']}.email"] = "{$item['data']['label']} phải là dạng mail";
        //         break;
        //         // case 'text':
        //         //    $rules[] = 'string';
        //         //    $tmp['messages']["{$item['data']['code']}.string"] = "{$item['data']['label']} phải là dạng text";
        //         // break;
        //     }
        //     if(empty($rules)) {
        //         break;
        //     }
        //     $tmp['rule'] = implode('|', $rules);
        //     foreach ($data['values'] as $value) {
        //         if($value['code'] === $item['data']['code']) {
        //             $tmp[$item['data']['code']] = $value['value'];
        //             break;
        //         }
        //     }
        //     $validator['data'][$item['data']['code']] = $tmp[$item['data']['code']];
        //     $validator['rules'][$item['data']['code']] = $tmp['rule'];
        //     foreach ($tmp['messages'] as $k => $value) {
        //         $validator['messages'][$k] = $value;
        //     }
        // }
        // $result = Validator::make($validator['data'], $validator['rules'], $validator['messages']);

        // if($result->fails()) {
        //     $messages = [];
        //     foreach($result->errors()->messages() as $key => $value) {
        //         $messages['fields'][$key] = $value[0];
        //         $messages['list'][] = $value[0];
        //     }
        //     return response()->json([
        //         'status'=> 0,
        //         'messages'=> $messages,
        //     ]);
        // }
        // $this->form_data->addValue([
        //     "customer_id"=> $data['customer_id'],
        //     "form_data_id"=> $data['form_data_id'],
        //     "values"=> $validator['data']
        // ]);
        $result = $this->script_process->nextById($data['scp_id'], $data['customer_id']);
        return $this->response($result);
    }

}
