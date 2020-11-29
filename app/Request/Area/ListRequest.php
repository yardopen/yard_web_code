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

class ListRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "area_sn" => "digits_between:1,20",//楼栋编号
            "page" => "digits_between:1,4",
            "per_page" => "digits_between:1,3",

        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "area_sn" => $this->input("area_sn", ''),
            "per_page" => $this->input("per_page", 15),
            "page" => $this->input("page", 1),
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