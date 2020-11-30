<?php

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/26-20:47
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Controller;


use App\Request\Area\CreateRequest;
use App\Request\Area\DeleteRequest;
use App\Request\Area\EditRequest;
use App\Request\Area\ListRequest;

/**
 * Class AreaController
 * @package App\Controller
 * @property \Core\Repository\AreaRepository $areaRepo
 */
class AreaController extends BaseController
{
    /**
     * 房间列表
     * @param ListRequest $listRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function list(ListRequest $listRequest)
    {
        $param = $listRequest->validated();
        $res = $this->areaRepo->listArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);

    }

    /**
     * 创建房间
     * @param CreateRequest $createRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(CreateRequest $createRequest)
    {
        $param = $createRequest->validated();
        $res = $this->areaRepo->createArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

    /**
     * 编辑房间
     * @param EditRequest $editRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit(EditRequest $editRequest)
    {
        $param = $editRequest->validated();
        $res = $this->areaRepo->editArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

    /**
     * 删除房间
     * @param DeleteRequest $deleteRequest
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(DeleteRequest $deleteRequest)
    {
        $param = $deleteRequest->validated();
        $res = $this->areaRepo->deleteArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }
}