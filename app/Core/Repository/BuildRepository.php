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
 * Class BuildRepository
 * @package Core\Repository
 * @property \Core\Service\BuildService $buildService
 * @property \Core\Service\AreaService $areaService
 */
class BuildRepository extends BaseRepository
{
    /**
     * 楼栋列表
     * @param array $param
     * @return array
     */
    public function list(array $param)
    {
        $columns = ['build_sn', 'build_name', 'build_size', 'elevator_num',];
        $res = $this->buildService->listBuild(['build_name' => $param['build_name']], $columns, $param['page'], $param['per_page']);
        return $this->code(200, "楼栋列表", $res);
    }

    /**
     * 楼栋树
     * @return array
     */
    public function tree()
    {
        $res = $this->buildService->treeBuild();
        return $this->code(200, "楼栋树", $res);
    }

    /**
     * 创建楼栋
     * @param array $param
     * @return array
     */
    public function create(array $param)
    {
        $chk = $this->buildService->first(['build_name' => $param['build_name']], ['pk_id']);
        if ($chk) {
            return $this->code(400, "楼栋已存在");
        }
        $res = $this->buildService->createBuild($param['build_name'], $param['build_size'], $param['elevator_num']);
        if (is_bool($res)) {
            return $this->code(400, "楼栋创建失败");
        }
        return $this->code(200, "楼栋创建成功", ["build_sn" => $res]);
    }


    /**
     * 修改楼栋
     * @param array $param
     * @return array
     */
    public function edit(array $param)
    {

        $chk = $this->buildService->first(['build_sn' => $param['build_sn']], ["pk_id"]);
        if (empty($chk)) {
            return $this->code(400, "楼栋不存在");
        }
        $where = [
            "build_name" => $param['build_name'],
            "build_sn" => ['<>', $param['build_sn']],
        ];
        $chk2 = $this->buildService->first($where, ["pk_id"]);
        if ($chk2) {
            return $this->code(400, "楼栋名称已存在");
        }

        $res = $this->buildService->editBuild($chk['pk_id'], $param['build_name'], $param['build_size'], $param['elevator_num']);
        if ($res) {
            return $this->code(200, "楼栋修改成功", ["build_sn" => $param['build_sn']]);

        }
        return $this->code(400, "楼栋修改失败");
    }

    /**
     * 删除楼栋
     * @param array $param
     * @return array
     */
    public function delete(array $param)
    {
        //第一步：检查楼栋是否存在
        $chk = $this->buildService->first(['build_sn' => $param['build_sn']], ["pk_id"]);
        if (empty($chk)) {
            return $this->code(400, "楼栋不存在");
        }
        //第二步：检查房间
        $chk_area = $this->areaService->first(['build_sn' => $param['build_sn'], ['pk_id']]);
        if ($chk_area) {
            return $this->code(400, "楼栋还存在区域,暂不能被删除");
        }

        //第三步：删除
        $res = $this->buildService->delBuild($chk['pk_id']);
        if ($res) {
            return $this->code(200, "楼栋删除成功", ["build_sn" => $param['build_sn']]);

        }
        return $this->code(400, "楼栋删除失败");
    }
}