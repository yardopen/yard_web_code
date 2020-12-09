<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $area_id 区域ID
 * @property string $area_sn 区域sn编号
 * @property string $area_no 区数字编号
 * @property string $area_name 区域名称
 * @property float $area_size 建筑面积
 * @property int $area_type 区域类型 0未知 1办公间 2商铺  3住宅 4厂房  5储物间
 * @property int $is_investment 是否可招商 1可以   2不可以
 * @property int $orientations 朝向 0未知  1南 2东南  3东  4西南  5北 6西
 * @property float $rental_price 租赁报价
 * @property int $rental_unit 租赁单元  1：元/㎡.月  2:元/㎡.天  3：元/月
 * @property int $renovation_type 装修 0未知  1简装   2精装   3毛坏
 * @property int $layout_type 户型 1：普通   2复式
 * @property int $bedroom_num 卧室数量
 * @property int $wc_room_num 卫生间数量
 * @property int $drawing_room_num 厅数量(客厅或饭厅)
 * @property string $introduce_imgs 区域图片
 * @property string $layout_img 户型图
 * @property string $introduce_video 区域视频
 * @property string $yard_sn 园区编号
 * @property string $creater_sn 创建人sn
 * @property string $build_sn 楼栋编号
 * @property string $floor_sn 楼层编号
 * @property string $lease_sn 租约sn
 * @property string $creater_name 创建人名称
 * @property string $modifyer_sn 修改人sn
 * @property string $modifyer_name 修改人名称
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 修改时间
 * @property int $status 状态 1正常
 * @property string $remark 备注
 * @property int $sort  排序
 */
class YardArea extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'yard_area';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['area_id', 'area_sn', 'area_no', 'area_name', 'area_size', 'area_type', 'is_investment', 'orientations', 'rental_price', 'rental_unit', 'renovation_type', 'layout_type', 'bedroom_num', 'wc_room_num', 'drawing_room_num', 'introduce_imgs', 'layout_img', 'introduce_video', 'yard_sn', 'creater_sn', 'build_sn', 'floor_sn', 'lease_sn', 'creater_name', 'modifyer_sn', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
}