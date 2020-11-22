<?php


namespace Core\Service;

/**
 * Class RegionService
 * @package Core\Service
 * @property \Core\ExModel\ProvinceModel $provinceModel
 * @property \Core\ExModel\CityModel $cityModel
 * @property \Core\ExModel\RegionModel $regionModel
 */
class RegionService extends BaseService
{
    public function provinceList()
    {
        return $this->provinceModel::query()->orderBy('sort')->get(['province_id', 'province_name', 'sort'])->all();
    }

    /**
     * 城市列表
     * @param int $province_id
     * @return array
     */
    public function cityList(int $province_id)
    {
        return $this->cityModel::query()->where(['province_id' => $province_id])->orderBy('sort')->get(['city_id', 'city_name',])->all();
    }


    /**
     * 区县列表
     * @param int $city_id
     * @return array
     */
    public function areaList(int $city_id)
    {
        return $this->regionModel::query()->where(['city_id' => $city_id])->orderBy('sort')->get(['area_id', 'area_name',])->all();

    }
}