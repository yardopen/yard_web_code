<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/23-0:51
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


use App\Model\YardArea;

class AreaModel extends YardArea
{
    protected $primaryKey = "area_id";

    /**
     * 房间朝向
     * @var string[]
     */
    public static $room_orientations = [
        0 => '未知',
        1 => '南',
        2 => '东南',
        3 => '东',
        4 => '西南',
        5 => '北',
        6 => '西',
    ];

    /**
     * 房间装修
     * @var string[]
     */
    public static $room_renovation = [
        0 => '未知',
        1 => '简装',
        2 => '精装',
        3 => '毛坏',
    ];

    /**
     * 房间类型
     * @var string[]
     */
    public static $room_area_type = [
        0 => '未知',
        1 => '办公间',
        2 => '商铺',
        3 => '住宅',
        4 => '厂房',
        5 => '存物间',
    ];

    /**
     * 房间户型
     * @var string[]
     */
    public static $room_layout = [
        1 => '普通',
        2 => '复式',
    ];

    public static $room_investment = [
        1 => '不可招商',
        2 => '可招商',
    ];


    public function build()
    {
        return $this->hasMany(BuildModel::class, 'build_sn', 'build_sn');
    }


}