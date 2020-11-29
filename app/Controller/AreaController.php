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
    public function list(ListRequest $listRequest)
    {
        $param = $listRequest->validated();
        $res = $this->areaRepo->listArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);

    }

    public function create(CreateRequest $createRequest)
    {
        $param = $createRequest->validated();
        $res = $this->areaRepo->createArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }


    public function edit(EditRequest $editRequest)
    {
        $param = $editRequest->validated();
        $res = $this->areaRepo->editArea($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }

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