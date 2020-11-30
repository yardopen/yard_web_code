<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:11
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Request\Tenant;


use App\Request\AbstractRequest;

class EditRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "tenant_sn" => "required|digits_between:1,20",
            "tenant_type" => "required|integer|between:1,2",
            "tenant_name" => "required|string|between:1,50",
            "certificate_num" => "required|digits_between:1,30",
            "contact_name" => "required|string|between:1,20",
            "contact_tel" => "required|digits_between:1,20",
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "tenant_sn" => $this->input("tenant_sn", ''),
            "tenant_name" => $this->input("tenant_name", ''),
            "tenant_type" => $this->input("tenant_type", 0),
            "certificate_num" => $this->input("certificate_num", ''),
            "contact_name" => $this->input("certificate_num", ''),
            "contact_tel" => $this->input("certificate_num", ''),
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [

        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'tenant_sn' => '租户编号',
            'tenant_name' => '租户名称',
            'tenant_type' => '租户类型',
            'certificate_num' => '证件号',
            'contact_name' => '联系人',
            'contact_tel' => '联系电话',
        ];
    }
}