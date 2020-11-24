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
     * 户型
     * @return string[]
     */
    public function roomLayout()
    {
        return $this->areaModel->room_layout;
    }

    /**
     * 租赁单价单位
     * @return string[]
     */
    public function roomRentalUnit()
    {
        return $this->areaModel->room_rental_unit;
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
     * 创建房间
     * @param string $build_sn
     * @param string $floor_sn
     * @param string $area_no
     * @param string $area_name
     * @param float|int $area_size
     * @param int $area_type
     * @param int $is_investment
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
     * @return false|mixed
     */
    public function createArea(string $build_sn, string $floor_sn, string $area_no, string $area_name = '', float $area_size = 0, int $area_type = 0,
                               int $is_investment = 1,
                               int $orientations = 0, float $rental_price = 0, int $rental_unit = 1, int $renovation_type = 0, int $layout_type = 1,
                               int $bedroom_num = 0, int $wc_room_num = 1, int $drawing_room_num = 1, array $introduce_imgs = [], string $layout_img = '',
                               string $introduce_video = '')
    {
        $insert_db = [
            "area_sn" => snowFlakeId(),
            'area_no' => $area_no,
            'area_name' => $area_name,
            'yard_sn' => $this->session->get('yard_sn'),
            'build_sn' => $build_sn,
            'floor_sn' => $floor_sn,
            'area_size' => $area_size,

            'area_type' => $area_type,
            'is_investment' => $is_investment,
            'orientations' => $orientations,
            'rental_price' => $rental_price,
            'rental_unit' => $rental_unit,
            'renovation_type' => $renovation_type,
            'layout_type' => $layout_type,

            'bedroom_num' => $bedroom_num,
            'wc_room_num' => $wc_room_num,
            'drawing_room_num' => $drawing_room_num,

            //图片、视频采用json存储
            'introduce_imgs' => $introduce_imgs,
            'layout_img' => $layout_img,
            'introduce_video' => $introduce_video,
        ];
        $res = $this->areaModel->insert($insert_db);
        if ($res) {
            return $insert_db['area_sn'];
        }
        return false;
    }
}