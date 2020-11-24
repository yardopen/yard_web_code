<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $floor_id 楼层ID
 * @property string $floor_sn 楼层编号
 * @property int $floor_no 楼层号
 * @property string $floor_img 楼层平面图
 * @property string $build_sn 栋sn
 * @property string $yard_sn 园区sn
 * @property int $creater_id 创建人ID
 * @property string $creater_name 创建人名称
 * @property int $modifyer_id 修改人ID
 * @property string $modifyer_name 修改人名称
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 修改时间
 * @property int $status 状态 1正常
 * @property string $remark 备注
 * @property int $sort 排序
 */
class YardFloor extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'yard_floor';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['floor_id', 'floor_sn', 'floor_no', 'floor_img', 'build_sn', 'yard_sn', 'creater_id', 'creater_name', 'modifyer_id', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['floor_id' => 'integer', 'floor_no' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}