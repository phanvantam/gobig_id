<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MainRequest extends FormRequest
{
    protected $authorize;
    protected $rules;
    protected $messages;
    // protected $attributes;

    public function __construct(Request $request)
    {
        $action = '_'.explode('@', $request->route()[1]['uses'])[1];

        $result = method_exists($this, $action) ? call_user_func([$this, $action]) : [];

        $this->authorize    = isset($result['authorize']) ? $result['authorize'] : true;
        $this->rules        = isset($result['rules']) ? $result['rules'] : [];
        $this->data         = isset($result['data']) ? $result['data'] : [];
        $this->messages     = isset($result['messages']) ? $result['messages'] : [];
        // $this->attributes   = isset($result['attributes']) ? $result['attributes'] : [];
    }

    public function authorize()
    {
        return $this->authorize;
    }

    public function rules() {
        return $this->rules;
    }

    public function messages() {
        return $this->messages;
    }

    // public function attributes() {
    // }

    protected function failedValidation(Validator $validator) { 
        $messages = [
            'fields'=> [],
            'list' => []
        ];
        foreach($validator->errors()->messages() as $key => $value) {
            $messages['fields'][$key] = $value[0];
            $messages['list'][] = $value[0];
        }
        throw new HttpResponseException(response()->json([
            'status'=> 0,
            'messages'=> $messages,
        ])); 
    }

    protected function prepareForValidation()
    {
        $this->merge($this->data);
    }

}
