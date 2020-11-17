<?php

declare (strict_types=1);
namespace App\Model\BaseModel;

/**
 * @property int $area_id 
 * @property string $area_name 
 * @property int $city_id 
 * @property int $sort 
 */
class RegionArea extends \App\Model\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'region_area';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['area_id', 'area_name', 'city_id', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['area_id' => 'integer', 'city_id' => 'integer', 'sort' => 'integer'];
}