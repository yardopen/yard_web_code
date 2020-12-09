<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $lease_id 
 * @property string $lease_sn 租约sn
 * @property string $lease_no 租约编号
 * @property string $yard_sn 园区sn
 * @property string $creater_sn 创建人sn
 * @property int $start_date 租约开始日期
 * @property int $end_date 租约结束日期
 * @property float $wy_fee 每月物业管理费
 * @property float $lease_fee 每月房屋租赁费
 * @property string $area_json 房json,存储房sn和房号
 * @property string $tenant_sn 租赁人sn
 * @property int $tenant_type 租户类型 1个人  2企业
 * @property string $tenant_name 租户名称
 * @property string $certificate_num 租户证件号
 * @property string $contact_name 联系人姓名
 * @property string $contact_tel 联系人电话
 * @property string $creater_name 创建人名称
 * @property string $modifyer_sn 修改人sn
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
    protected $fillable = ['lease_id', 'lease_sn', 'lease_no', 'yard_sn', 'creater_sn', 'start_date', 'end_date', 'wy_fee', 'lease_fee', 'area_json', 'tenant_sn', 'tenant_type', 'tenant_name', 'certificate_num', 'contact_name', 'contact_tel', 'creater_name', 'modifyer_sn', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['lease_id' => 'integer', 'start_date' => 'integer', 'end_date' => 'integer', 'wy_fee' => 'float', 'lease_fee' => 'float', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer', 'tenant_type' => 'integer'];
}