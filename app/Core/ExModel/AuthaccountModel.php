<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-20:23
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\ExModel;


class AuthaccountModel extends \App\Model\AuthAccount
{
    protected $primaryKey = 'account_id';
    protected $primarySn = 'account_sn';
}