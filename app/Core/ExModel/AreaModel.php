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
    protected $primarySn = 'area_sn';


    //定义默认值
    protected $attributes = [
        'introduce_imgs' => '[]',
        'layout_img' => '[]',
        'introduce_video' => '[]',
    ];

    protected $casts = [
        'introduce_imgs' => 'array',
        'layout_img' => 'array',
        'introduce_video' => 'array',
    ];


    /**
     * 房间朝向
     * @var string[]
     */
    public $room_orientations = [
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
    public $room_renovation = [
        0 => '未知',
        1 => '简装',
        2 => '精装',
        3 => '毛坏',
    ];

    /**
     * 房间类型
     * @var string[]
     */
    public $area_type_name = [
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
    public $layout_type_name = [
        1 => '普通',
        2 => '复式',
    ];

    /**
     * @var string[]
     */
    public $room_investment = [
        1 => '不可招商',
        2 => '可招商',
    ];

    /**
     * @var string[]
     */
    public $rental_unit_name = [
        1 => '元/㎡.月',
        2 => '元/㎡.天',
        3 => '元/月',
    ];

    /**
     * @var string[]
     */
    public $room_status=[
        1=>'自住',
        2=>'招商中',
        3=>'已招商(待服务)',
        3=>'已招商(服务中)',
        4=>'已招商(已逾期)'
    ];


    /**
     * 房间类型(户型)
     * @return string
     */
    public function getFullRoomTypeAttribute()
    {
        if ($this->area_type <> 3) {
            return $this->area_type_name[$this->area_type];
        }

        if ($this->layout_type == 2) {
            return $this->area_type_name[1] . "($this->layout_type_name[2])";
        }

        return "{$this->layout_type_name[1]}({$this->bedroom_num}房{$this->drawing_room_num}厅{$this->wc_room_num}卫)";
    }

    /**
     * 租赁单价全称
     * @return string
     */
    public function getRentalPriceNameAttribute()
    {
        if ($this->is_investment == 2) {
            return '0.00';
        }
        return "{$this->rental_price}{$this->rental_unit_name[$this->rental_unit]}";
    }


    /**
     * 房间与楼栋的关系
     * @return \Hyperf\Database\Model\Relations\BelongsTo
     */
    public function build()
    {
        return $this->belongsTo(BuildModel::class, 'build_sn', 'build_sn');
    }

    /**
     * 房间与租约的关系
     * @return \Hyperf\Database\Model\Relations\BelongsTo
     */
    public function lease()
    {
        return $this->belongsTo(LeaseModel::class, 'lease_sn', 'lease_sn');
    }


}