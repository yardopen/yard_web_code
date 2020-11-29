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
        return $this->areaModel->area_type_name;
    }

    /**
     * 户型
     * @return string[]
     */
    public function roomLayout()
    {
        return $this->areaModel->layout_type_name;
    }

    /**
     * 租赁单价单位
     * @return string[]
     */
    public function roomRentalUnit()
    {
        return $this->areaModel->rental_unit_name;
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


    public function listArea($where, $columns = ['*'], int $page = 1, int $perPage = 15)
    {
        $yard_sn = $this->session->get('yard_sn');
        if (is_array($where)) {
            $where['yard_sn'] = $yard_sn;
            $where = array_filter($where);
        } else {
            $where .= " and yard_sn='{$yard_sn}'";
        }


        $res = $this->areaModel::query()->where($where)->select($columns)
            ->with(['lease' => function ($query) {
                $query->select(['area_no', 'build_sn', 'start_date', 'end_date']);

            }])->with(['build' => function ($bq) {
                $bq->select(['build_name', 'build_sn']);

            }])->forPage($page, $perPage)->orderBy('sort')->orderBy('area_no')
            ->get()->all();
       return $res;
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
     * @param array $layout_img
     * @param array $introduce_video
     * @return false|mixed
     */
    public function createArea(string $build_sn, string $floor_sn, string $area_no, string $area_name = '', float $area_size = 0, int $area_type = 0,
                               int $is_investment = 1,
                               int $orientations = 0, float $rental_price = 0, int $rental_unit = 1, int $renovation_type = 0, int $layout_type = 1,
                               int $bedroom_num = 0, int $wc_room_num = 1, int $drawing_room_num = 1, array $introduce_imgs = [], array $layout_img = [],
                               array $introduce_video = [])
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


    /**
     * 修改房间
     * @param bool $is_rental 是否在租赁中
     * @param string $area_sn 房间编号
     * @param string $area_name 房间别名
     * @param float|int $area_size 房间尺寸
     * @param int $area_type 户型 1：普通   2复式
     * @param int $is_investment 是否可招商 1可以   2不可以
     * @param int $orientations 朝向 0未知  1南 2东南  3东  4西南  5北 6西
     * @param float|int $rental_price 装修 0未知  1简装   2精装   3毛坏
     * @param int $rental_unit 租赁单位  1：元/㎡.月  2:元/㎡.天  3：元/月
     * @param int $renovation_type 装修 0未知  1简装   2精装   3毛坏
     * @param int $layout_type 户型 1：普通   2复式
     * @param int $bedroom_num
     * @param int $wc_room_num
     * @param int $drawing_room_num
     * @param array $introduce_imgs
     * @param array $layout_img
     * @param array $introduce_video
     * @return bool
     */
    public function editArea(bool $is_rental, string $area_sn, string $area_name = '', float $area_size = 0, int $area_type = 0,
                             int $is_investment = 1,
                             int $orientations = 0, float $rental_price = 0, int $rental_unit = 1, int $renovation_type = 0, int $layout_type = 1,
                             int $bedroom_num = 0, int $wc_room_num = 1, int $drawing_room_num = 1, array $introduce_imgs = [], array $layout_img = [],
                             array $introduce_video = [])
    {
        $where = [
            "area_sn" => $area_sn,
            'yard_sn' => $this->session->get('yard_sn'),
        ];

        $update_db = [
            'area_name' => $area_name,
            'area_size' => $area_size,
            'orientations' => $orientations,
            'rental_price' => $rental_price,
            'rental_unit' => $rental_unit,
            'renovation_type' => $renovation_type,
            'layout_type' => $layout_type,

            //图片、视频采用json存储
            'introduce_imgs' => $introduce_imgs,
            'layout_img' => $layout_img,
            'introduce_video' => $introduce_video,
        ];

        if ($layout_type == 1) { //普通房
            $update_db['bedroom_num'] = $bedroom_num;
            $update_db['wc_room_num'] = $wc_room_num;
            $update_db['drawing_room_num'] = $drawing_room_num;
        }


        //2:检查房屋是否在租赁中
        if (!$is_rental) { //非租赁中
            $update_db['area_type'] = $area_type;
            $update_db['is_investment'] = $is_investment;
        }

        $res = $this->areaModel::query()->where($where)->update($update_db);
        if ($res) {
            return true;
        }
        return false;

    }


    /**
     * 删除房间
     * @param string $area_sn
     * @return bool
     */
    public function deleteArea(string $area_sn)
    {
        $where = [
            'yard_sn' => $this->session->get('yard_sn'),
            'area_sn' => $area_sn
        ];
        $res = $this->areaModel::query()->where($where)->delete();
        if ($res) {
            return true;
        }
        return false;
    }
}