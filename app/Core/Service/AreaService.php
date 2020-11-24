<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/23-1:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;
/**
 * Class AreaService
 * @package Core\Service
 * @property \Core\ExModel\AreaModel $areaModel
 */
class AreaService extends BaseService
{
    /**
     * 朝向
     * @return string[]
     */
    public function orientations()
    {
        return $this->areaModel->room_orientations;
    }

    /**
     * 装修
     * @return string[]
     */
    public function renovation()
    {
        return $this->areaModel->room_renovation;
    }

    /**
     * 房间类型
     * @return string[]
     */
    public function roomAreaType()
    {
        return $this->areaModel->room_area_type;
    }


    /**
     * 根据条件查询
     * @param $where
     * @param string[] $columns
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

        $obj = $this->areaModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * @param string $build_sn
     * @param string $area_no
     * @param string $area_name
     * @param float|int $area_size
     * @param int $area_type
     * @param int $is_Investment
     * @param int $orientations
     * @param float|int $rental_price
     * @param int $rental_unit
     * @param int $renovation_type
     * @param int $layout_type
     * @param int $bedroom_num
     * @param int $wc_room_num
     * @param int $drawing_room_num
     * @param array $introduce_imgs
     * @param string $layout_img
     * @param string $introduce_video
     */
    public function createArea(string $build_sn, string $area_no, string $area_name = '', float $area_size = 0, int $area_type = 0, int $is_Investment = 1,
                               int $orientations = 0, float $rental_price = 0, int $rental_unit = 1, int $renovation_type = 0, int $layout_type = 1,
                               int $bedroom_num = 0, int $wc_room_num = 1, int $drawing_room_num = 1, array $introduce_imgs = [], string $layout_img = '',
                               string $introduce_video = '')
    {
        $floor_no = substr(sprintf("%04d", $area_no), 0, 2);
    }
}