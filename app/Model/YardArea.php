<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $area_id 
 * @property string $area_sn 
 * @property string $area_no 
 * @property string $area_name 
 * @property float $area_size 
 * @property int $area_type 
 * @property int $is_Investment 
 * @property int $orientations 
 * @property float $rental_price 
 * @property int $rental_unit 
 * @property int $renovation_type 
 * @property int $layout_type 
 * @property int $bedroom_num 
 * @property int $wc_room_num 
 * @property int $drawing_room_num 
 * @property string $introduce_imgs 
 * @property string $layout_img 
 * @property string $introduce_video 
 * @property string $yard_sn 
 * @property string $build_sn 
 * @property string $floor_sn 
 * @property int $creater_id 
 * @property string $creater_name 
 * @property int $modifyer_id 
 * @property string $modifyer_name 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $status 
 * @property string $remark 
 * @mixin \App_Model_YardArea
 */
class YardArea extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'yard_area';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['area_id', 'area_sn', 'area_no', 'area_name', 'area_size', 'area_type', 'is_Investment', 'orientations', 'rental_price', 'rental_unit', 'renovation_type', 'layout_type', 'bedroom_num', 'wc_room_num', 'drawing_room_num', 'introduce_imgs', 'layout_img', 'introduce_video', 'yard_sn', 'build_sn', 'floor_sn', 'creater_id', 'creater_name', 'modifyer_id', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['area_id' => 'integer', 'area_size' => 'float', 'area_type' => 'integer', 'is_Investment' => 'integer', 'orientations' => 'integer', 'rental_price' => 'float', 'rental_unit' => 'integer', 'renovation_type' => 'integer', 'layout_type' => 'integer', 'bedroom_num' => 'integer', 'wc_room_num' => 'integer', 'drawing_room_num' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer'];
}