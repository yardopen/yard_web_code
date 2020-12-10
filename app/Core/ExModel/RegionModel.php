<?php

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:57
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


use App\Model\MapRegion;

class RegionModel extends MapRegion
{
    protected $primaryKey = "region_id";
    protected $hook = false;
}