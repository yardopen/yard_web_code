<?php


namespace Core\Service;

/**
 * Class RegionService
 * @package Core\Service
 * @property \App\Model\ExModel\ProvinceModel $provinceModel
 */
class RegionService extends BaseService
{
    public function provinceList()
    {
       return $this->provinceModel::all();
    }
}