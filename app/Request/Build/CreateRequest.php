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

class CreateRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "build_name" => "required|string|between:1,20",
            "elevator_num" => "integer|between:0,99",
            "build_size" => "numeric|between:0,100000",
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "build_name" => $this->input("build_name", ''),
            "build_size" => $this->input("build_size", 0),
            "elevator_num" => $this->input("elevator_num", 0),
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
            'build_size' => '楼栋建筑面积',
            'elevator_num' => '楼栋电梯数量',
        ];
    }
}