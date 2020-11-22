<?php


namespace App\Controller;


use App\Constants\StatusCode;
use Psr\Container\ContainerInterface;
use Hyperf\Di\Annotation\Inject;


class BaseController extends AbstractController
{

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;


    /**
     * __get
     * 隐式注入仓库类
     * User：YM
     * Date：2019/11/21
     * Time：上午9:27
     * @param $key
     * @return \Psr\Container\ContainerInterface|void
     */
    public function __get($key)
    {
        if ($key == 'app') {
            return $this->container;
        } else {
            $suffix = strstr($key, 'Repo');
            if ($suffix && ($suffix == 'Repo' || $suffix == 'Repository')) {
                $repoName = $suffix == 'Repo' ? $key . 'sitory' : $key;
                return $this->getRepositoriesInstance($repoName);
            } else {
                throw new \RuntimeException("仓库{$key}不存在，书写错误！", StatusCode::ERR_SERVER);
            }
        }
    }

    /**
     * getRepositoriesInstance
     * 获取仓库类实例
     * User：YM
     * Date：2019/11/21
     * Time：上午10:30
     * @param $key
     * @return mixed
     */
    private function getRepositoriesInstance($key)
    {
        $key = ucfirst($key);
        $module = $this->getModuleName();
        if (!empty($module)) {
            $module = "{$module}";
        } else {
            $module = "";
        }
        if ($module) {
            $filename = BASE_PATH . "/app/Core/Repositories/{$module}/{$key}.php";
            $className = "Core\\Repositories\\{$module}\\{$key}";
        } else {
            $filename = BASE_PATH . "/app/Core/Repositories/{$key}.php";
            $className = "Core\\Repositories\\{$key}";
        }

        if (file_exists($filename)) {
            return $this->container->get($className);
        } else {
            throw new \RuntimeException("仓库{$key}不存在，文件不存在！", StatusCode::ERR_SERVER);
        }
    }

    /**
     * getModuleName
     * 获取所属模块
     * User：YM
     * Date：2019/11/21
     * Time：上午9:32
     * @return string
     */
    private function getModuleName()
    {
        $className = get_called_class();
        $name = substr($className, 15);
        $space = explode('\\', $name);
        if (count($space) > 1) {
            return $space[0];
        } else {
            return '';
        }
    }

}