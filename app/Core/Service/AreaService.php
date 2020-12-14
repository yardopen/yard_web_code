<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/23-1:10
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;

use Core\ExModel\AreaModel;
use Hyperf\Di\Annotation\Inject;

/**
 * Class AreaService
 * @package Core\Service
 */
class AreaService extends BaseService
{
    /**
     * @Inject()
     * @var AreaModel
     */
    private $areaModel;

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
     * @param array $where
     * @param string[] $columns
     * @return array
     */
    public function first(array $where, $columns = ['*'])
    {

        return $this->areaModel->getInfoByWhere($where, $columns);
    }

    /**
     * 房间列表
     * @param $where
     * @param string[] $columns
     * @param int $page
     * @param int $perPage
     * @return array
     */
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
                $query->select(['lease_sn', 'tenant_name', 'lease_no', 'start_date', 'end_date']);

            }])->with(['build' => function ($bq) {
                $bq->select(['build_name', 'build_sn']);

            }])->forPage($page, $perPage)->orderBy('sort')->orderBy('area_no')
            ->get();
        $res_arr = $res->all();
        foreach ($res as $key => $val) {

            //房间全名称
            $res_arr[$key]["full_room_name"] = "{$val->build->build_name}-{$val->area_no}";
            if (empty($val->lease_sn)) {
                $res_arr[$key]["full_room_name"] .= $val->area_name ? "($val->area_name)" : "";
            } else {
                $res_arr[$key]["full_room_name"] .= $val->lease->tenant_name ? "({$val->lease->tenant_name})" : "";
            }

            //房屋类型(户型)
            $res_arr[$key]["full_room_type"] = $val->full_room_type;
            $res_arr[$key]["rental_price_name"] = $val->rental_price_name;

            $res_arr[$key]["introduce_imgs"] = $val->introduce_imgs ?? [];
            $res_arr[$key]["layout_img"] = $val->layout_img ?? [];
            $res_arr[$key]["introduce_video"] = $val->introduce_video ?? [];

            //房间当前状态
            $res_arr[$key]["room_status"] = '自住';
            if (empty($val->lease_sn)) {
                $res_arr[$key]["room_status"] = $val->is_investment == 1 ? '招商中' : "自住";
            } elseif (time() > strtotime((string)$val->lease->end_date)) {
                $res_arr[$key]["room_status"] = "已招商(已逾期)";
            } else {
                $res_arr[$key]["room_status"] = "已招商({$val->lease->start_date}至{$val->lease->end_date})";
            }

            //

            unset($res_arr[$key]["build"], $res_arr[$key]["lease"], $res_arr[$key]["build_sn"]);

        }
        return $res_arr;
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
        $create_data = [
            "area_no" => $area_no,
            "area_name" => $area_name,
            "build_sn" => $build_sn,
            "floor_sn" => $floor_sn,
            "area_size" => $area_size,
            "area_type" => $area_type,
            "is_investment" => $is_investment,
            "orientations" => $orientations,
            "rental_price" => $rental_price,
            "rental_unit" => $rental_unit,
            "renovation_type" => $renovation_type,
            "layout_type" => $layout_type,
            "bedroom_num" => $bedroom_num,
            "wc_room_num" => $wc_room_num,
            "drawing_room_num" => $drawing_room_num,
            "introduce_imgs" => $introduce_imgs,
            "layout_img" => $layout_img,
            "introduce_video" => $introduce_video,
        ];
        return $this->areaModel->saveInfo($create_data);
    }


    /**
     * 修改房间
     * @param int $area_id 房间ID
     * @param bool $is_rental 是否在租赁中
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
    public function editArea(int $area_id, bool $is_rental, string $area_name = '', float $area_size = 0, int $area_type = 0,
                             int $is_investment = 1,
                             int $orientations = 0, float $rental_price = 0, int $rental_unit = 1, int $renovation_type = 0, int $layout_type = 1,
                             int $bedroom_num = 0, int $wc_room_num = 1, int $drawing_room_num = 1, array $introduce_imgs = [], array $layout_img = [],
                             array $introduce_video = [])
    {


        $update_data = [
            "area_id" => $area_id,

            "area_name" => $area_name,
            "area_size" => $area_size,
            "orientations" => $orientations,
            "rental_price" => $rental_price,
            "rental_unit" => $rental_unit,
            "renovation_type" => $renovation_type,
            "layout_type" => $layout_type,

            "introduce_imgs" => $introduce_imgs,
            "layout_img" => $layout_img,
            "introduce_video" => $introduce_video,
        ];


        if ($layout_type == 1) { //普通房
            $update_data['bedroom_num'] = $bedroom_num;
            $update_data['wc_room_num'] = $wc_room_num;
            $update_data['drawing_room_num'] = $drawing_room_num;
        }
        //2:检查房屋是否在租赁中
        if (!$is_rental) { //非租赁中
            $update_data['area_type'] = $area_type;
            $update_data['is_investment'] = $is_investment;

        }
        return $this->areaModel->saveInfo($update_data);

    }


    /**
     * 删除房间
     * @param array|int $area_id
     * @return int
     */
    public function deleteArea($area_id)
    {
        return $this->areaModel->deleteInfo($area_id);
    }
}