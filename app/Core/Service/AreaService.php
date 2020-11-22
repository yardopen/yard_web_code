<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/23-1:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;
/**
 * Class AreaService
 * @package Core\Service
 * @property \Core\ExModel\AreaModel $areaModel
 */
class AreaService extends BaseService
{
    /**
     * 根据条件查询
     * @param $where
     * @param string[] $columns
     * @return array|false
     */
    public function first($where, $columns = ['*'])
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
        } else {
            $where .= " and yard_sn='{$yard_sn}'";
        }

        $obj = $this->areaModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }
}