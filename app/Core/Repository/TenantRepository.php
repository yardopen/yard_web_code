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
 * Class TenantRepository
 * @package Core\Repository
 * @property \Core\Service\TenantService $tenantService
 */
class TenantRepository extends BaseRepository
{
    /**
     * 租户列表
     * @param array $param
     * @return array
     */
    public function listTenant(array $param)
    {
        $where = array_filter([
            'tenant_name' => $param['tenant_name'],
            'tenant_type' => $param['tenant_type'],
            'certificate_num' => $param['certificate_num'],
        ]);
        $cloumn = ['tenant_sn', 'tenant_type', 'tenant_name', 'certificate_num', 'contact_name', 'contact_tel'];
        $res = $this->tenantService->listTenant($where, $cloumn, $param['page'], $param['per_page']);
        return $this->code(200, "租户信息列表", $res);
    }

    /**
     * 编辑租户
     * @param array $param
     * @return array
     */
    public function editTenant(array $param)
    {
        //1:查询租户
        $where = [
            "tenant_sn" => $param['tenant_sn'],
        ];
        $tenant_chk_res = $this->tenantService->first($where, ['pk_id']);
        if (!$tenant_chk_res) {
            return $this->code(400, "租户不存在");
        }


        //2：修改租户信息
        $tenant_res = $this->tenantService->editTenant($tenant_chk_res['pk_id'], $param['tenant_type'], $param['tenant_name'], $param['certificate_num'], $param['contact_name'], $param['contact_tel']);
        if (!$tenant_res) {
            return $this->code(400, "租户信息修改失败");
        }
        //3:修改租户关联的正常的租约记录


        return $this->code(200, "租户信息修改成功");
    }
}