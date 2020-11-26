<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-20:53
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;


/**
 * Class AuthaccountService
 * @package Core\Service
 * @property \Core\ExModel\AuthaccountModel $authaccountModel
 * @property \Hyperf\Redis\Redis $cache
 */
class AuthaccountService extends BaseService
{
    /**
     * 根据条件查询
     * @param string[] $columns
     * @param array|string $where
     * @return array|false
     */
    public function first($where, $columns = ['*'])
    {
        $obj = $this->authaccountModel::query()->where($where)->first($columns);
        if ($obj) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 登录会话缓存
     * @param string $yard_sn
     * @param array $data
     * @return false|string
     * @throws \Exception
     */
    public function prodToken(string $yard_sn, array $data = [])
    {
        $token = getUserUniqueId();
        $data['yard_sn'] = $yard_sn;
        $store = $this->cache->set($token, json_encode($data));
        if ($store) {
            return $token;
        }
        return false;

    }

    /**
     * 退出登录
     * @param string $token
     * @return bool
     */
    public function logout(string $token)
    {
        $res = $this->cache->del($token);
        if ($res > 0) {
            return true;
        }
        return false;
    }
}