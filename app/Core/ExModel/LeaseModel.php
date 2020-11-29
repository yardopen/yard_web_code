<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/24-21:46
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


use App\Model\RentalLease;

class LeaseModel extends RentalLease
{
    protected $primaryKey = "lease_id";

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'area_json' => 'array',
        'tenant_json' => 'array'
    ];


}