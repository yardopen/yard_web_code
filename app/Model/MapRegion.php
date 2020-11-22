<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $area_id 
 * @property string $area_name 
 * @property int $city_id 
 * @property int $sort 
 */
class MapRegion extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'map_region';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['region_id', 'region_name', 'city_id', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['region_id' => 'integer', 'city_id' => 'integer', 'sort' => 'integer'];
}