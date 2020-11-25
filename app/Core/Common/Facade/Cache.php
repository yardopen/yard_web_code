<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:59
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Common\Facade;


use Hyperf\Redis\Redis as RedisCache;
use Hyperf\Utils\ApplicationContext;

/**
 * 获取redis缓存
 * Class Cache
 * @package Core\Common\Facade
 */
class Cache
{
    /**
     * @return RedisCache|mixed
     */
    public static function get()
    {
        return ApplicationContext::getContainer()->get(RedisCache::class);
    }
}