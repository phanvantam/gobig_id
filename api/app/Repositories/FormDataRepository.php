<?php

namespace App\Repositories;
 
use App\Repositories\FormDataRepositoryInterface;
use App\Models\FormData;
use App\Models\FormDataValue;

class FormDataRepository implements FormDataRepositoryInterface 
{

    public function getByFilter()
    {
        $result = FormData::get();
        return $result;
    }

    public function add($input)
    {
        $data = [
            'fod_title'=> $input['title'],
            'fod_description'=> $input['description'],
            'fod_fields'=> base64_encode(json_encode($input['fields']))
        ];
        return FormData::insertGetId($data);;
    }

    public function update($id, $input)
    {
        $data = [
            'fod_title'=> $input['title'],
            'fod_description'=> $input['description'],
            'fod_fields'=> base64_encode(json_encode($input['fields']))
        ];
        return FormData::where('fod_id', $id)->update($data);;
    }

    public function getById($value)
    {
        $result = FormData::where('fod_id', $value)->first();
        return $result;
    }

    public function getBy($value)
    {
        $result = FormData::where('fod_id', $value)->first();
        return $result;
    }


    public function addValue($input)
    {
        $this->removeValueByFormDataIdAndCustomerId($input['form_data_id'], $input['customer_id']);
        $data = [
            'fdv_customer_id'=> $input['customer_id'],
            'fdv_form_data_id'=> $input['form_data_id'],
            'fdv_values'=> base64_encode(json_encode($input['values']))
        ];
        return FormDataValue::insertGetId($data);;
    }

    public function getValueByFormDataIdAndCustomerId($form_data_id, $customer_id)
    {
        return FormDataValue::where('fdv_form_data_id', $form_data_id)->where('fdv_customer_id', $customer_id)->first();
    }

    public function removeValueByFormDataIdAndCustomerId($form_data_id, $customer_id)
    {
        return FormDataValue::where('fdv_form_data_id', $form_data_id)->where('fdv_customer_id', $customer_id)->delete();
    }

}	
