<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:49
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


use App\Model\YardBuild;

class BuildModel extends YardBuild
{
    protected $primaryKey = "build_id";
}