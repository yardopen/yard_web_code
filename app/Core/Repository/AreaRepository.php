<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/24-20:58
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Repository;

/**
 * Class AreaRepository
 * @package Core\Repository
 * @property \Core\Service\AreaService $areaService
 * @property \Core\Service\FloorService $floorService
 */
class AreaRepository extends BaseRepository
{

    /**
     * 房间添加编辑选项数据
     * @return array
     */
    public function areaAddEditList()
    {
        $res = [
            "orientations" => $this->areaService->orientations(), //朝向
            'renovation' => $this->areaService->renovation(), //装修
            'room_area_type' => $this->areaService->roomAreaType(), //房间类型
            'room_layout' => $this->areaService->roomLayout(), //户型
            'room_rental_unit' => $this->areaService->roomRentalUnit(), //租赁单价单位
        ];
        return $this->code(200, "楼栋列表", $res);
    }


    public function listArea(array $param)
    {
        // $columns=["area_no","area_name","area_size",'area_type','rental_price','rental_unit','orientations','renovation_type','layout_type',''];

        $where = [

        ];
        $res = $this->areaService->listArea($where, ['*'], $param['page'], $param['per_page']);
        return $this->code(200, "房间列表", $res);
    }

    /**
     * 创建房间
     * @param array $param
     * @return array
     */
    public function createArea(array $param)
    {

        //1:检查房屋是否存在
        $chk_area_res = $this->areaService->first(['area_sn' => $param['area_sn']], ['area_no']);
        if ($chk_area_res) {
            return $this->code(400, "房间已存在");
        }

        //获取楼层sn
        $floor_sn = $this->getFloorSn($param['area_no'], $param['build_sn']);

        //3:创建房间
        $area_res = $this->areaService->createArea($param['build_sn'], $floor_sn, $param['area_no'], $param['area_name'], $param['area_size'], $param['area_type'],
            $param['is_investment'], $param['orientations'], $param['rental_price'], $param['rental_unit'], $param['renovation_type'], $param['layout_type']
            , $param['bedroom_num'], $param['wc_room_num'], $param['drawing_room_num'], $param['introduce_imgs'], $param['layout_img'], $param['introduce_video']
        );
        if ($area_res) {
            return $this->code(200, "房间创建成功", ['area_sn' => $area_res['area_sn']]);
        }
        return $this->code(400, "房间创建失败");
    }

    public function editArea(array $param)
    {
        //1:检查房屋是否存在
        $chk_area_res = $this->areaService->first(['area_sn' => $param['area_sn']], ['lease_sn']);
        if (!$chk_area_res) {
            return $this->code(400, "房间不存在");
        }
        //房间是否在租赁中
        $is_rental = empty($chk_area_res['lease_sn']) ? false : true;

        //修改房间数据
        $area_res = $this->areaService->editArea($is_rental, $param['area_sn'], $param['area_name'], $param['area_size'], $param['area_type'],
            $param['is_investment'], $param['orientations'], $param['rental_price'], $param['rental_unit'], $param['renovation_type'], $param['layout_type'],
            $param['bedroom_num'], $param['wc_room_num'], $param['drawing_room_num'], $param['introduce_imgs'], $param['layout_img'], $param['introduce_video']);
        if ($area_res) {
            return $this->code(200, "房间编辑成功", ['area_sn' => $param['area_sn']]);
        }
        return $this->code(400, "房间编辑失败");


    }

    /**
     * @param array $param
     * @return array
     */
    public function deleteArea(array $param)
    {
        $where = ["area_sn" => $param['area_sn']];
        $chk_res = $this->areaService->first($where, ['lease_sn']);
        if (!$chk_res) {
            return $this->code(400, "房间不存在");
        }
        //2:查询房间否在租赁当中
        if (!empty($chk_res['lease_sn'])) {
            return $this->code(400, "租赁中不能被删除");
        }
        //3:执行删除操作
        $del_res = $this->areaService->deleteArea($param['area_sn']);
        if ($del_res) {
            return $this->code(200, "房间删除成功");
        }
        return $this->code(400, "房间删除失败");

    }

    /**
     * 获取指定楼栋，房号所在的楼层sn
     * @param string $area_no 房号
     * @param string $build_sn 楼栋sn
     * @return array|mixed
     */
    private function getFloorSn(string $area_no, string $build_sn)
    {
        $floor_no = (int)substr(sprintf("%04d", $area_no), 0, 2);
        $floor_chk = [
            'build_sn' => $build_sn,
            'floor_no' => $floor_no,
        ];
        //1:检查楼层是否存在，若不存在则创建
        $chk_floor_res = $this->floorService->first($floor_chk);
        if ($chk_floor_res) {
            $floor_sn = $chk_floor_res['floor_sn'];
        } else {
            $add_floor_res = $this->floorService->createFloor($build_sn, $floor_no);
            if (!$add_floor_res) {
                return $this->code(400, "楼层创建失败");
            }
            $floor_sn = $add_floor_res['floor_sn'];
        }
        return $floor_sn;
    }
}