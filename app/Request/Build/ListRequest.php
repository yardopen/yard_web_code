<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Request\Build;


use App\Request\AbstractRequest;

class ListRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "build_name" => "string|between:0,20",
            "page" => "integer|min:1",
            "perPage" => "integer|between:1,100",
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "build_name" => $this->input("build_name", ''),
            "page" => $this->input("page", 1),
            "perPage" => $this->input("perPage", 15),
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
        ];
    }
}