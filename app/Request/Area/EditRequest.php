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

class EditRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "area_sn" => "required|digits_between:1,20", //房间编号

            "area_name" => "string|between:0,50",//区域名称
            "area_size" => "numeric|between:0,10000",//建筑面积
            "area_type" => "integer|between:0,9",//区域类型 0未知 1办公间 2商铺  3住宅 4厂房  5储物间
            "is_investment" => "required|integer|between:1,2",//是否可招商 1可以   2不可以
            "orientations" => "integer|between:0,6",//朝向 0未知  1南 2东南  3东  4西南  5北 6西
            "rental_price" => "numeric|between:0,1000", //租赁报价
            "rental_unit" => "required|integer|between:1,3",//租赁单元  1：元/㎡.月  2:元/㎡.天  3：元/月
            "renovation_type" => "integer|between:0,3", //装修 0未知  1简装   2精装   3毛坏
            "layout_type" => "required|integer|between:1,2",//户型 1：普通   2复式
            "bedroom_num" => "integer|between:0,9", //房
            "wc_room_num" => "integer|between:0,9", //卫
            "drawing_room_num" => "required|integer|between:1,9", //厅
            "introduce_imgs" => "array", //房间图片
            "layout_img" => "array", //平面图
            "introduce_video" => "array", //房间视频
        ];
    }

    /**
     * Get data to be validated from the request.
     */
    protected function validationData(): array
    {
        return [
            "area_sn" => $this->input("build_sn", ''),
            "area_name" => $this->input("area_name", 0),
            "area_size" => $this->input("area_size", 0),
            "area_type" => $this->input("area_type", 0),
            "is_investment" => $this->input("is_investment", 2),
            "orientations" => $this->input("orientations", 0),
            "rental_price" => $this->input("rental_price", 0),
            "rental_unit" => $this->input("rental_unit", 1),
            "renovation_type" => $this->input("renovation_type", 1),
            "layout_type" => $this->input("layout_type", 1),
            "bedroom_num" => $this->input("bedroom_num", 0),
            "wc_room_num" => $this->input("wc_room_num", 0),
            "drawing_room_num" => $this->input("drawing_room_num", 1),
            "introduce_imgs" => $this->input("introduce_imgs", []),
            "layout_img" => $this->input("layout_img", []),
            "introduce_video" => $this->input("introduce_video", []),
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