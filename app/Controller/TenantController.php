<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:47
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Controller;

use App\Request\Tenant\ListRequest;

/**
 * Class TenantController
 * @package App\Controller
 * @property \Core\Repository\TenantRepository $tenantRepo
 */
class TenantController extends BaseController
{
    /**
     * 租户列表
     * @param ListRequest $listRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function list(ListRequest $listRequest)
    {
        $param = $listRequest->validated();
        $res = $this->tenantRepo->listTenant($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

    public function edit()
    {

    }
}