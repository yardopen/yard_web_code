<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-12:30
 * Team Name HornIOT
 **/

namespace Core\Service;


/**
 * Class LeaseService
 * @package Core\Service
 * @property \Core\ExModel\LeaseModel $leaseModel
 */
class LeaseService extends BaseService
{
    /**
     * 根据条件查询
     * @param string[] $columns
     * @param array|string $where
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

        $obj = $this->leaseModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 列表
     * @param $where
     * @param string[] $columns
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function listLease($where, $columns = ['*'], int $page = 1, int $perPage = 15)
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
            $where = array_filter($where);

        } else {
            $where .= " and  yard_sn='{$yard_sn}'";
        }
        $res = $this->leaseModel::query()->where($where)->select($columns)
            ->forPage($page, $perPage)->orderBy('sort')->orderBy('lease_id', 'desc')
            ->get()->all();
        return $res;
    }


    public function createLease()
    {

    }

    public function editLease()
    {

    }

}