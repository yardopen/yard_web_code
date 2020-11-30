<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Request\Lease;


use App\Request\AbstractRequest;

class ListRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            "tenant_name" => "string|between:1,20",
            "tenant_type" => "integer|between:0,2",
            "certificate_num" => "alpha_num|between:1,20",
            "page" => "integer|min:1",
            "per_page" => "integer|between:1,100",
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "tenant_name" => $this->input("tenant_name", ''),
            "tenant_type" => $this->input("tenant_type", 0),
            "certificate_num" => $this->input("certificate_num", ''),
            "page" => $this->input("page", 1),
            "per_page" => $this->input("per_page", 15),
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
            'build_name' => '楼栋名称',
            'page' => '页码',
            'perPage' => '第页记录数',
        ];
    }
}