<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $lease_id 
 * @property string $lease_sn 租约sn
 * @property string $lease_no 租约编号
 * @property string $yard_sn 园区sn
 * @property int $start_date 租约开始日期
 * @property int $end_date 租约结束日期
 * @property float $wy_fee 每月物业管理费
 * @property float $lease_fee 每月房屋租赁费
 * @property string $area_json 房json,存储房sn和房号
 * @property string $tenant_sn 租赁人sn
 * @property string $tenant_json 租赁人json
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
class RentalLease extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental_lease';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lease_id', 'lease_sn', 'lease_no', 'yard_sn', 'start_date', 'end_date', 'wy_fee', 'lease_fee', 'area_json', 'tenant_sn', 'tenant_json', 'creater_id', 'creater_name', 'modifyer_id', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['lease_id' => 'integer', 'start_date' => 'integer', 'end_date' => 'integer', 'wy_fee' => 'float', 'lease_fee' => 'float', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}