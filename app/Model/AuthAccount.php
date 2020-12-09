<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $account_id 
 * @property string $account_sn 
 * @property string $username 
 * @property string $password 
 * @property string $account_name 姓名
 * @property int $sex 性别  0未知  1男  2女
 * @property string $tel 电话号码
 * @property string $yard_sn 园区sn
 * @property string $creater_sn 创建人sn
 * @property string $creater_name 创建人名称
 * @property string $modifyer_sn 修改人sn
 * @property string $modifyer_name 修改人名称
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 修改时间
 * @property int $status 状态 1正常
 * @property string $remark 备注
 * @property int $sort 排序
 */
class AuthAccount extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_account';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'account_sn', 'username', 'password', 'account_name', 'sex', 'tel', 'yard_sn', 'creater_sn', 'creater_name', 'modifyer_sn', 'modifyer_name', 'created_at', 'updated_at', 'status', 'remark', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['account_id' => 'integer', 'sex' => 'integer', 'creater_id' => 'integer', 'modifyer_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'sort' => 'integer'];
}