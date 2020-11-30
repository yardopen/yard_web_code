<?php

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-19:49
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Repository;

/**
 * Class LeaseRepository
 * @package Core\Repository
 * @property \Core\Service\LeaseService $leaseService
 */
class LeaseRepository extends BaseRepository
{

    public function list(array $param)
    {
        $columns = ['build_sn', 'build_name', 'build_size', 'elevator_num',];
        $res = $this->leaseService->listLease(['build_name' => $param['build_name']], $columns, $param['page'], $param['per_page']);
        return $this->code(200, "楼栋列表", $res);
    }

    public function create(array $param)
    {

    }

    public function edit(array $param)
    {

    }

}