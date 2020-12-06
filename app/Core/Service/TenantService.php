<?php


/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-20:53
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;

/**
 * Class TenantService
 * @package Core\Service
 * @property \Core\ExModel\TenantModel $tenantModel
 */
class TenantService extends BaseService
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

        $obj = $this->tenantModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 租户列表
     * @param $where
     * @param string[] $columns
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function listTenant($where, $columns = ['*'], int $page = 1, int $perPage = 15)
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
            $where = array_filter($where);

        } else {
            $where .= " and  yard_sn='{$yard_sn}'";
        }
        $res = $this->tenantModel::query()->where($where)->select($columns)->with(['lease' => function ($query) {
            $query->select(['lease_no', 'start_date', 'end_date', 'area_json', 'tenant_sn',]);

        }])->forPage($page, $perPage)->orderBy('sort')->orderBy('tenant_id', 'desc')
            ->get()->all();
        $data = [];
        foreach ($res as $key => $val) {
            if ($val['tenant_sn']) {
                $lease = $val['lease'];
                unset($val['lease']);
                $data[] = array_merge($val, $lease);
            }
        }
        return $data;
    }


    /**
     * 修改租户信息
     * @param string $tenant_sn
     * @param int $tenant_type
     * @param string $tenant_name
     * @param string $certificate_num
     * @param string $contact_name
     * @param string $contact_tel
     * @return bool
     */
    public function editTenant(string $tenant_sn, int $tenant_type, string $tenant_name, string $certificate_num, string $contact_name, string $contact_tel)
    {
        $where = [
            'yard_sn' => $this->session->get('yard_sn'),
            'tenant_sn' => $tenant_sn,
        ];
        $update_db = [
            'tenant_type' => $tenant_type,
            'tenant_name' => $tenant_name,
            'certificate_num' => $certificate_num,
            'contact_name' => $contact_name,
            'contact_tel' => $contact_tel
        ];
        $res = $this->tenantModel::query()->where($where)->update($update_db);
        if ($res) {
            return true;
        }
        return false;
    }
}