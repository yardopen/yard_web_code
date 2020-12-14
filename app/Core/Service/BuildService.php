<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-12:30
 * Team Name HornIOT
 **/

namespace Core\Service;

use Hyperf\Di\Annotation\Inject;
use Core\ExModel\BuildModel;

/**
 * Class BuildService
 * @package App\Core\Service
 */
class BuildService extends BaseService
{
    /**
     * @Inject()
     * @var BuildModel
     */
    private $buildModel;

    /**
     * @param array|string $where
     * @param string[] $columns
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function listBuild($where, $columns = ['*'], int $page = 1, int $perPage = 15)
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
            $where = array_filter($where);
            $where['build_pid'] = 0;
        } else {
            $where .= " and   build_pid=0 and yard_sn='{$yard_sn}'";
        }

        $res = $this->buildModel::query()->where($where)->select($columns)->with(['area' => function ($query) {
            $query->select(['area_no', 'build_sn']);

        }])->forPage($page, $perPage)->orderBy('sort')->orderBy('build_name')
            ->get()->all();
        $data = [];
        foreach ($res as $key => $val) {
            $val['area_num'] = count($val['area']);
            $max_no = max(array_column(json_decode($val['area'], true), "area_no")); //获取最大区域号
            $sub_len = strlen($max_no) == 4 ? 2 : 1;
            $val['floor_num'] = (int)substr($max_no, 0, $sub_len);//获取楼层高楼
            unset($val['area']);
            $data[] = $val;
        }

        return $data;

    }

    /**
     * 楼栋树
     * @return array
     */
    public function treeBuild()
    {
        $yard_sn = $this->session->get('yard_sn');
        $where = ["yard_sn" => $yard_sn, "build_pid" => 0];
        $res = $this->buildModel::query()->where($where)->select(['build_sn', 'build_name'])
            ->orderBy('sort')->orderBy('build_name')
            ->get()->all();
        return $res;
    }


    /**
     * 根据条件查询
     * @param string[] $columns
     * @param array|string $where
     * @return array|false
     */
    public function first(array $where, $columns = ['*'])
    {
        return $this->buildModel->getInfoByWhere($where, $columns);
    }

    /**
     * 创建楼栋,创建成功返
     * @param string $build_name
     * @param float|int $build_size
     * @param int $elevator_num
     * @return false|string
     */
    public function createBuild(string $build_name, float $build_size = 0, int $elevator_num = 0)
    {

        $insert_data = [
            "build_name" => $build_name,
            "build_size" => $build_size,
            "elevator_num" => $elevator_num,
        ];

        return $this->buildModel->saveInfo($insert_data);
    }


    /**
     * 通过楼栋编号修改楼栋信息
     * @param int $build_id
     * @param string $build_name
     * @param float|int $build_size
     * @param int $elevator_num
     * @return bool
     */
    public function editBuild(int $build_id, string $build_name, float $build_size = 0, int $elevator_num = 0)
    {
        $update_data = [
            "build_name" => $build_name,
            "build_size" => $build_size,
            "elevator_num" => $elevator_num,
            "build_id" => $build_id,
        ];

        return $this->buildModel->saveInfo($update_data);
    }

    /**
     * 删除楼栋
     * @param int $build_id
     * @return bool|null
     */
    public function delBuild(int $build_id)
    {
        return $this->buildModel->deleteInfo($build_id);
    }


}