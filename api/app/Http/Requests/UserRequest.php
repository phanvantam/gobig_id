<?php

namespace App\Http\Requests;

use App\Http\Requests\MainRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends MainRequest
{

    public function _create()
    {
        // 
    	$data = [
            'fullname' => Request::json('fullname'),
            'email' => Request::json('email'),
            'password' => Request::json('password'),
            'position_id' => Request::json('position_id'),
        ];
        $rules = [
            'fullname'=> 'required',
            'email' => [
                'required',
                'email',
                'unique:'. with(new \App\Models\User)->getTable() .',use_email'
            ],
            'password' => [
                'required',
                //Tối thiểu tám ký tự, ít nhất một chữ cái và một số:
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
            ],
            'position_id' => [
                'required',
                'exists:'. with(new \App\Models\Position)->getTable() .',pos_id'
            ]
        ];
        $messages = [
            'fullname.required'=> 'Vui lòng nhập họ tên',
            'email.required'=> 'Vui lòng nhập địa chỉ mail',
            'email.email'=> 'Địa chỉ mail không hợp lệ',
            'email.unique'=> 'Địa chỉ mail đã được sử dụng',
            'password.required'=> 'Vui lòng nhập mật khẩu',
            'password.regex'=> 'Mật khẩu không hợp lệ',
            'position_id.exists'=> 'Vui lòng chọn chức vụ'
        ];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _update()
    {
        $result = $this->_create();
        $data = $result['data'];
        $messages = $result['messages'];
        $rules = $result['rules'];
        
        unset($rules['password']);
        if(!empty($data['password'])) {
            $rules['password'] = $result['rules']['password'];
        }

        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _profileUpdate()
    {
        $data = [
            'fullname' => Request::json('fullname'),
        ];
        $rules = [
            'fullname'=> 'required',
        ];
        $messages = [
            'fullname.required'=> 'Vui lòng nhập họ tên',
        ];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _profileUpdatePassword()
    {
        $user = new \App\Repositories\UserRepository;
        $user_detail = $user->getByCode(USER_CODE);

        $data = [
            'password' => Request::json('password'),
            'password_old' => Request::json('password_old'),
            'password_confirm' => Request::json('password_confirm'),
        ];
        $rules = [
            'password'=> [
                'required',
                //Tối thiểu tám ký tự, ít nhất một chữ cái và một số:
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
            ],
            'password_old'=> 'required',
            'password_confirm'=> 'required|same:password',
        ];
        if(!empty($data['password_old'])) {
            $data['password_code'] = $user->makePasswordCode($data['password_old'], $user_detail->use_salt);
            $data['db_password_code'] = $user_detail->use_password_code;
            $rules['db_password_code'] = 'same:password_code';
        }
        $messages = [
            'password.required'=> 'Vui lòng nhập mật khẩu mới',
            'password_old.required'=> 'Vui lòng nhập mật khẩu cũ',
            'password_confirm.required'=> 'Vui lòng xác nhận mật khẩu mới',
            'password_confirm.same'=> 'Mật khẩu xác nhận không khớp với mật khẩu mới',
            'password.regex'=> 'Mật khẩu mới không hợp lệ',   
            'db_password_code.same'=> 'Mật khẩu cũ không chính xác',   
        ];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _childCreate()
    {
        $data = [
            'child_id' => Request::json('child_id'),
            'child_id_v2' => Request::json('child_id'),
            'parent_id' => Request::json('parent_id'),
        ];
        $rules = [
            'child_id'=> 'exists:'. with(new \App\Models\User)->getTable() .',use_id',
            // 'child_id_v2'=> Rule::exists(with(new \App\Models\UserChild)->getTable() , 'usc_child_id')                     
            //     ->where(function ($query) use ($data) {  
            //         $query->where('usc_parent_id', $data['parent_id']);                  
            //     }),
            'parent_id' => 'exists:'. with(new \App\Models\User)->getTable() .',use_id',
        ];
        $messages = [
            'child_id.exists'=> 'Vui lòng chọn nhân viên',
            'parent_id.exists'=> 'Vui lòng chỉ định cấp cha',
        ];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }

    public function _permissionCreate()
    {
        $data = [
            'permission_id' => Request::json('permission_id'),
            'user_id' => Request::json('user_id'),
            'project_id' => Request::json('project_id'),
        ];
        $rules = [
            'permission_id'=> 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ];
        $messages = [];
        
        return [
            'authorize'=> true,
            'rules'=> $rules,
            'messages'=> $messages,
            'data'=> $data
        ];
    }
}
