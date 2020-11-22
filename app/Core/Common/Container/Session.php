<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:57
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Common\Container;

use Core\Common\Facade\Cache;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 获取当前会话内容
 * Class Session
 * @package App\Core\Common\Container
 */
class Session
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * 获取当前会话
     * @param string $key
     * @return false|string|array
     */
    public function get(string $key = '')
    {
        $token = $this->request->getHeaderLine('token'); //100%存在，在中间件已完成校验
        $cache = Cache::get()->get($token);
        if (empty($cache)) {
            return false;
        }
        $cache_arr = json_decode($cache, true);
        if (empty($cache_arr)) {
            return false;
        }
        if (empty($key)) {
            return $cache_arr;
        }
        if (array_key_exists($key, $cache_arr)) {
            return $cache_arr[$key];
        }
        return false;

    }

}