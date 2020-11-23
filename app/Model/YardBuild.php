<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $build_id 
 * @property string $build_sn 
 * @property string $build_name 
 * @property float $build_size 
 * @property int $elevator_num 
 * @property int $build_pid 
 * @property string $yard_sn 
 * @property int $creater_id 
 * @property string $creater_name 
 * @property int $modifyer_id 
 * @property string $modifyer_name 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $status 
 * @property string $remark 
 * @property int $sort 
 */
class YardBuild extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'yard_build';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['build_id', 'build_sn', 'build_name', 'build_size', 'elevator_num', 'build_pid', 'yard_sn', 'creater_id', 'creater_name', 'modifyer_id', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['build_id' => 'integer', 'build_size' => 'float', 'elevator_num' => 'integer', 'build_pid' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}