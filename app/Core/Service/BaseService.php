<?php


/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-20:53
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Service;

use App\Constants\StatusCode;
use Core\Common\Container\Session;
use Core\Common\Facade\Cache;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;


/**
 * Class BaseService
 * @package Core\Service
 * @property Session $session
 * @property Cache $cache
 */
class BaseService
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;


    /**
     * __get
     * 隐式注入服务类
     * @param $key
     * @return \Psr\Container\ContainerInterface|void
     */
    public function __get($key)
    {
        if ($key == 'app') {
            return $this->container;
        } elseif (strtolower(substr($key, -5)) == 'cache') {
            return Cache::get();
        } elseif (strtolower(substr($key, -7)) == 'session') {
            return make(Session::class);
        } elseif (substr($key, -5) == 'Model') {
            // $key = strstr($key, 'BaseModel', true);
            return $this->getModelInstance($key);
        } elseif (substr($key, -7) == 'Service') {
            return $this->getServiceInstance($key);
        } else {
            throw new \RuntimeException("服务/模型{$key}不存在，书写错误！", StatusCode::ERR_SERVER);
        }
    }



    /**
     * getModelInstance
     * 获取数据模型类实例
     * @param $key
     * @return mixed
     */
    private function getModelInstance($key)
    {
        $key = ucfirst($key);
        $fileName = BASE_PATH . "/app/Core/ExModel/{$key}.php";
        $className = "Core\\ExModel\\{$key}";

        if (file_exists($fileName)) {
            //model一般不要常驻内存
            //return $this->container->get($className);
            return make($className);
        } else {
            throw new \RuntimeException("模型{$key}不存在，文件不存在！", StatusCode::ERR_SERVER);
        }
    }

    /**
     * getServiceInstance
     * 获取服务类实例
     * @param $key
     * @return mixed
     */
    private function getServiceInstance($key)
    {
        $key = ucfirst($key);
        $fileName = BASE_PATH . "/app/Core/Service/{$key}.php";
        $className = "Core\\Service\\{$key}";

        if (file_exists($fileName)) {
            return $this->container->get($className);
        } else {
            throw new \RuntimeException("服务{$key}不存在，文件不存在！", StatusCode::ERR_SERVER);
        }
    }
}