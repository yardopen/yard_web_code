<?php

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:59
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Common\Facade;

use Hyperf\Utils\ApplicationContext;
use Hyperf\Logger\LoggerFactory;

/**
 * Log
 * 日志类
 * @package Core\Common\Facade
 */
class Log
{

    /**
     * get
     * 获取区分channel的日志实例
     * @param string $name
     * @return mixed
     */
    public static function get(string $name = 'hyperf')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name);
    }
}