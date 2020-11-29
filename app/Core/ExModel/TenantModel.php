<?php


/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:57
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


use App\Model\RentalTenant;

class TenantModel extends RentalTenant
{
    protected $primaryKey = 'tenant_id';


    /**
     * 一个人可以有多个租约
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function lease()
    {
        return $this->hasMany(LeaseModel::class, 'tenant_sn', 'tenant_sn');
    }

}