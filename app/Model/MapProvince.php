<?php

declare (strict_types=1);
namespace App\Model;


/**
 * @property int $province_id 
 * @property string $province_name 
 * @property int $sort 
 * @property string $remark 
 */
class MapProvince extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'region_province';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['province_id', 'province_name', 'sort', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['province_id' => 'integer', 'sort' => 'integer'];
}