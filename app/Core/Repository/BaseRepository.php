<?php

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:57
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Repository;


use App\Constants\StatusCode;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

class BaseRepository
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Created by PhpStorm.
     * 可以实现自动注入的业务容器
     */
    protected $businessContainerKey = ['auth', 'adminPermission'];


    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function code(int $code = 200, string $msg = '', array $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
    }

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
        } elseif (in_array($key, $this->businessContainerKey)) {
            return $this->getBusinessContainerInstance($key);
        } elseif (substr($key, -7) == 'Service') {
            return $this->getServiceInstance($key);
        } else {
            throw new \RuntimeException("服务{$key}不存在，书写错误！", StatusCode::ERR_SERVER);
        }
    }

    /**
     * getBusinessContainerInstance
     * 获取业务容器实例
     * @param $key
     * @return mixed
     */
    private function getBusinessContainerInstance($key)
    {
        $key = ucfirst($key);
        $fileName = BASE_PATH . "/app/Core/Common/Container/{$key}.php";
        $className = "Core\\Common\\Container\\{$key}";

        if (file_exists($fileName)) {
            return $this->container->get($className);
        } else {
            throw new \RuntimeException("通用容器{$key}不存在，文件不存在！", StatusCode::ERR_SERVER);
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