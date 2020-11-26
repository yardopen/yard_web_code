<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $tenant_id 租户ID
 * @property string $tenant_sn 租户sn
 * @property int $tenant_type 租户类型 1个人  2企业
 * @property string $tenant_name 租户名称
 * @property string $certificate_num 租户证件号
 * @property string $contact_name 联系人姓名
 * @property string $contact_tel 联系人电话
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
class RentalTenant extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental_tenant';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tenant_id', 'tenant_sn', 'tenant_type', 'tenant_name', 'certificate_num', 'contact_name', 'contact_tel', 'yard_sn', 'creater_id', 'creater_name', 'modifyer_id', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['tenant_id' => 'integer', 'tenant_type' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}