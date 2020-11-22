<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-20:47
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Controller\House;


use App\Controller\BaseController;
use App\Request\Build\CreateRequest;
use App\Request\Build\DeleteRequest;
use App\Request\Build\EditRequest;


/**
 * Class BuildController
 * @package App\Controller\House
 * @property \Core\Repository\BuildRepository $buildRepo
 */
class BuildController extends BaseController
{
    /**
     * 创建
     * @param CreateRequest $createRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(CreateRequest $createRequest)
    {
        $param = $createRequest->validated();
        $res = $this->buildRepo->create($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

    /**
     * 修改
     * @param EditRequest $editRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit(EditRequest $editRequest)
    {
        $param = $editRequest->validated();
        $res = $this->buildRepo->create($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

    /**
     * 删除
     * @param DeleteRequest $deleteRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(DeleteRequest $deleteRequest)
    {
        $param = $deleteRequest->validated();
        $res = $this->buildRepo->create($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }
}