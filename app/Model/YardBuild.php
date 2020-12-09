<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $build_id 
 * @property string $build_sn 楼栋编号
 * @property string $build_name 楼栋名称
 * @property float $build_size 建筑面积
 * @property int $elevator_num 电梯数量
 * @property int $build_pid 上级ID
 * @property string $yard_sn 园区编号
 * @property string $creater_sn 创建人sn
 * @property string $creater_name 创建人名称
 * @property string $modifyer_sn 修改人sn
 * @property string $modifyer_name 修改人名称
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 修改时间
 * @property int $status 状态 1正常
 * @property string $remark 备注
 * @property int $sort 排序
 */
class YardBuild extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'yard_build';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['build_id', 'build_sn', 'build_name', 'build_size', 'elevator_num', 'build_pid', 'yard_sn', 'creater_sn', 'creater_name', 'modifyer_sn', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['build_id' => 'integer', 'build_size' => 'float', 'elevator_num' => 'integer', 'build_pid' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}