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
            "area_sn" => "digits_between:1,20",
            "build_sn" => "digits_between:1,20",
            "room_orientations" => "between:0,6",
            "area_type" => "between:0,5",
            "room_status" => "between:0,5",
            "page" => "between:0,100000",
            "per_page" => "between:1,100",

        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "area_sn" => $this->input("area_sn", ''),//房间编号
            "build_sn" => $this->input("build_sn", ''),//楼栋编号
            "room_orientations" => $this->input("room_orientations", 0), //朝向
            "area_type" => $this->input("area_type", 0), //类型
            "room_status" => $this->input("room_status", 0), //状态
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