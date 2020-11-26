<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Request\Area;


use App\Request\AbstractRequest;

class DeleteRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "build_sn" => "required|digits_between:1,20",//楼栋编号
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "build_sn" => $this->input("build_sn", ''),
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

        ];
    }
}