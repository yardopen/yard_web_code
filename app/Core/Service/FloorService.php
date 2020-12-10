<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/24-21:42
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;

use Core\ExModel\FloorModel;
use Hyperf\Di\Annotation\Inject;

/**
 * Class FloorService
 * @package Core\Service
 */
class FloorService extends BaseService
{
    /**
     * @Inject()
     * @var FloorModel
     */
    private $floorModel;

    /**
     * 根据条件查询
     * @param $where
     * @param string[] $columns
     * @return false|array
     */
    public function first($where, $columns = ['*'])
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
        } else {
            $where .= " and yard_sn='{$yard_sn}'";
        }

        $obj = $this->floorModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 创建楼层
     * @param string $build_sn 楼栋sn
     * @param int $floor_no
     * @param string $floor_img
     * @return false|mixed
     */
    public function createFloor(string $build_sn, int $floor_no, string $floor_img = '')
    {
        $this->floorModel->build_sn = $build_sn;
        $this->floorModel->floor_no = $floor_no;
        $this->floorModel->floor_img = $floor_img;

        $res = $this->floorModel->save();
        if ($res) {
            return $this->floorModel->floor_sn;
        }
        return false;
    }
}