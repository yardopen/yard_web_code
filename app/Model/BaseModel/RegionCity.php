<?php

declare (strict_types=1);
namespace App\Model\BaseModel;

/**
 * @property int $city_id 
 * @property string $city_name 
 * @property int $province_id 
 * @property int $sort 
 */
class RegionCity extends \App\Model\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'region_city';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['city_id', 'city_name', 'province_id', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['city_id' => 'integer', 'province_id' => 'integer', 'sort' => 'integer'];
}