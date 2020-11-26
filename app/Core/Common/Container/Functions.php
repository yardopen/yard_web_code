<?php

declare(strict_types=1);

/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/21-22:57
 * Team Name HornIOT
 *
 * 公共函数，避免功能性函数重复书写
 * 书写规范，必须使用function_exists()方法判断
 */

use Hyperf\Utils\Coroutine;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Server as SwooleServer;
use Hyperf\Utils\Context;
use Hyperf\Utils\ApplicationContext;
use Hyperf\HttpMessage\Cookie\Cookie as HyperfCookie;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Hyperf\Contract\SessionInterface;
use Jenssegers\Agent\Agent;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Utils\Arr;
use Hyperf\Cache\Listener\DeleteListenerEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

//use Core\Common\Driver\CacheDriver;
//use Core\Common\Container\Auth;
//use Core\Common\Container\Ip2Region;


if (!function_exists('requestEntry')) {

    /**
     * requestEntry
     * 根据异常返回信息，获取请求入口（模块-控制器-方法）
     * User：YM
     * Date：2019/12/15
     * Time：上午10:53
     * @param array $backTrace
     * @return mixed|string
     */
    function requestEntry(array $backTrace)
    {
        $moduleName = '';
        foreach ($backTrace as $v) {
            if (isset($v['file']) && stripos($v['file'], 'CoreMiddleware.php')) {
                $tmp = array_reverse(explode('\\', trim($v['class'])));
                if (substr(strtolower($tmp[0]), -10) == 'controller') {
                    $module = str_replace('controller', '', strtolower($tmp[1]));
                    $class = str_replace('controller', '', strtolower($tmp[0]));
                    $function = $v['function'];
                    $moduleName = $class . '-' . $function;
                    if ($module) {
                        $moduleName = $module . '-' . $moduleName;
                    }
                    break;
                }
            }
        }
        if (!$moduleName) {
            $request = ApplicationContext::getContainer()->get(RequestInterface::class);
            $uri = $request->getRequestUri();
            $moduleName = str_replace('/', '-', ltrim($uri, '/'));
        }
        $moduleName = $moduleName ?? 'hyperf';
        return $moduleName;
    }
}

if (!function_exists('getCoId')) {
    /**
     * getCoId
     * 获取当前协程id
     * User：YM
     * Date：2019/12/16
     * Time：上午12:32
     * @return int
     */
    function getCoId()
    {
        return Coroutine::id();
    }
}

if (!function_exists('getClientInfo')) {
    /**
     * getClientInfo
     * 获取请求客户端信息，获取连接的信息
     * User：YM
     * Date：2019/12/16
     * Time：上午12:39
     * @return mixed
     */
    function getClientInfo()
    {
        // 得从协程上下文取出请求
        $request = Context::get(ServerRequestInterface::class);
        $server = make(SwooleServer::class);
        return $server->getClientInfo($request->getSwooleRequest()->fd);
    }
}

if (!function_exists('getServerLocalIp')) {
    /**
     * getServerLocalIp
     * 获取服务端内网ip地址
     * User：YM
     * Date：2019/12/19
     * Time：下午5:48
     * @return string
     */
    function getServerLocalIp()
    {
        $ip = '127.0.0.1';
        $ips = array_values(swoole_get_local_ip());
        foreach ($ips as $v) {
            if ($v && $v != $ip) {
                $ip = $v;
                break;
            }
        }

        return $ip;
    }
}

if (!function_exists('setCookies')) {
    /**
     * setCookie
     * 设置cookie
     * User：YM
     * Date：2019/12/17
     * Time：下午12:16
     * @param string $key
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @param bool $raw
     * @param null|string $sameSite
     */
    function setCookies(string $key, $value = '', $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httpOnly = true, bool $raw = false, ?string $sameSite = null)
    {
        // convert expiration time to a Unix timestamp
        if ($expire instanceof \DateTimeInterface) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);
            if ($expire === false) {
                throw new \RuntimeException('The cookie expiration time is not valid.');
            }
        }
        $response = ApplicationContext::getContainer()->get(ResponseInterface::class);
        $cookie = new HyperfCookie($key, (string)$value, $expire, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
        $response = $response->withCookie($cookie);
        Context::set(PsrResponseInterface::class, $response);
        return true;
    }
}

if (!function_exists('getCookie')) {
    /**
     * getCookie
     * 获取cookie
     * User：YM
     * Date：2019/12/17
     * Time：下午12:17
     * @param string $key
     * @param null|string $default
     * @return mixed
     */
    function getCookie(string $key, ?string $default = null)
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        return $request->cookie($key, $default);
    }
}

if (!function_exists('hasCookie')) {
    /**
     * hasCookie
     * 判断cookie是否存在
     * User：YM
     * Date：2019/12/17
     * Time：下午12:20
     * @param string $key
     * @return mixed
     */
    function hasCookie(string $key)
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        return $request->hasCookie($key);
    }
}

if (!function_exists('delCookie')) {
    /**
     * delCookie
     * 删除cookie
     * User：YM
     * Date：2019/12/17
     * Time：下午12:21
     * @param string $key
     * @return bool
     */
    function delCookie(string $key): bool
    {
        if (!hasCookie($key)) {
            return false;
        }

        setCookies($key, '', time() - 1);

        return true;
    }
}


if (!function_exists('getLogArguments')) {
    /**
     * getLogArguments
     * 获取要存储的日志部分字段，monolog以外的业务信息
     * User：YM
     * Date：2019/12/20
     * Time：下午12:57
     * @param float $executionTime 程序执行时间，运行时才能判断这里初始化为0
     * @param int $rbs 响应包体大小，初始化0，只有正常请求响应才有值
     * @return array
     */
    function getLogArguments($executionTime = null, $rbs = 0)
    {
        if (Context::get('http_request_flag') === true) {
            $request = ApplicationContext::getContainer()->get(RequestInterface::class);
            $requestHeaders = $request->getHeaders();
            $serverParams = $request->getServerParams();
            $arguments = $request->all();
            if (isset($arguments['password'])) {
                unset($arguments['password']);
            }
            // $auth = ApplicationContext::getContainer()->get(Auth::class);
            // $userId = $auth->check(false);
            $uuid = getCookie('HYPERF_SESSION_ID');
            $url = $request->fullUrl();
        } else {
            $requestHeaders = $serverParams = $arguments = [];
            $uuid = $userId = $url = '';
        }
        $agent = new Agent();
        $agent->setUserAgent($requestHeaders['user-agent'][0] ?? '');
        $ip = $requestHeaders['x-real-ip'][0] ?? $requestHeaders['x-forwarded-for'][0] ?? '';
        // ip转换地域
        if ($ip && ip2long($ip) != false) {
            $location = getIpLocation($ip);
            $cityId = $location['city_id'] ?? 0;
        } else {
            $cityId = 0;
        }
        return [
            'qid' => $requestHeaders['qid'][0] ?? '',
            'server_name' => $requestHeaders['host'][0] ?? '',
            'server_addr' => getServerLocalIp() ?? '',
            'remote_addr' => $serverParams['remote_addr'] ?? '',
            'forwarded_for' => $requestHeaders['x-forwarded-for'][0] ?? '',
            'real_ip' => $ip,
            'city_id' => $cityId,
            'user_agent' => $requestHeaders['user-agent'][0] ?? '',
            'platform' => $agent->platform() ?? '',
            'device' => $agent->device() ?? '',
            'browser' => $agent->browser() ?? '',
            'url' => $url,
            'uri' => $serverParams['request_uri'] ?? '',
            'arguments' => $arguments ? json_encode($arguments) : '',
            'method' => $serverParams['request_method'] ?? '',
            'execution_time' => $executionTime,
            'request_body_size' => $requestHeaders['content-length'][0] ?? '',
            'response_body_size' => $rbs,
            'uuid' => $uuid,
            'user_id' => $userId ?? '',
            'referer' => $requestHeaders['referer'][0] ?? '',
            'unix_time' => $serverParams['request_time'] ?? '',
            'time_day' => isset($serverParams['request_time']) ? date('Y-m-d', $serverParams['request_time']) : '',
            'time_hour' => isset($serverParams['request_time']) ? date('Y-m-d H:00:00', $serverParams['request_time']) : '',
        ];
    }
}

if (!function_exists('getIpLocation')) {
    /**
     * getIpLocation
     * 获取ip对应的城市信息
     * User：YM
     * Date：2020/2/19
     * Time：下午8:42
     * @param $ip
     * @return mixed
     */
    function getIpLocation($ip)
    {
        /*       $dbFile = BASE_PATH . '/app/Core/Common/Container/ip2region.db';
               $ip2regionObj = new Ip2Region($dbFile);
               $ret = $ip2regionObj->binarySearch($ip);
               return $ret;*/
        return $ip;
    }
}

if (!function_exists('isStdoutLog')) {
    /**
     * isStdoutLog
     * 判断日志类型是否允许输出
     * User：YM
     * Date：2019/12/21
     * Time：下午7:13
     * @param string $level
     * @return bool
     */
    function isStdoutLog(string $level)
    {
        $config = config(StdoutLoggerInterface::class, ['log_level' => []]);
        return in_array(strtolower($level), $config['log_level'], true);
    }
}

if (!function_exists('isMobileNum')) {
    /**
     * isMobileNum
     * 判断是否为手机号
     * User：YM
     * Date：2020/1/10
     * Time：上午12:21
     * @param $v
     * @return bool
     */
    function isMobileNum($v)
    {
        $search = '/^0?1[3-9][0-9]\d{8}$/';
        if (preg_match($search, $v)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('encryptPassword')) {
    /**
     * encryptPassword
     * 加密密码
     * @param string $password 用户输入的密码
     * @access public
     * @return void
     */
    function encryptPassword($password)
    {
        $len = intval(strlen($password) / 2);
        $pass01 = substr(md5(substr($password, 0, $len)), 16);
        $pass02 = substr(md5(substr($password, $len)), 16);
        return $pass01 . $pass02;
    }
}

if (!function_exists('checkPassword')) {
    /**
     * checkPassword
     * 检测密码
     * @param $value
     * @param $hashedValue
     * @return bool
     */
    function checkPassword($value, $hashedValue)
    {
        if (strlen($hashedValue) != 32) {
            return false;
        }
        return encryptPassword($value)==$hashedValue;
    }
}

if (!function_exists('getUserUniqueId')) {
    /**
     * getUserUniqueId
     * 获取用户唯一标示，用户ID生成规则，32位
     * @access public
     * @return string
     * @throws Exception
     */
    function getUserUniqueId()
    {
        // 前缀3位
        $prefix = config('app_uid_prefix');
        $prefix = substr($prefix, 0, 3);
        //随机字符串14位
        $rand = substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes(14))), 0, 14);
        //根据当前时间生成的随机字符串11位
        $uniqid = substr(uniqid(), 2);
        //当前服务器ip后4位
        $ip = getServerLocalIp();
        $ipList = explode('.', $ip);
        if (empty($ipList) || count($ipList) < 4) {
            $ipStr = '01';
        } else {
            $ipStr = $ipList[2] . $ipList[3];
        }
        $ip = dechex($ipStr);
        $ip = str_pad($ip, 6, 'f', STR_PAD_LEFT);
        if (PHP_SAPI != 'cli') {
            $ip = substr($ip, -4);
        } else {
            $ip = 'z' . substr($ip, -3);
        }

        //总共32位字符串
        return strtolower($prefix . $ip . $rand . $uniqid);
    }
}

if (!function_exists('handleTreeList')) {
    /**
     * handleTreeList
     * 建立数组树结构列表
     *
     * @datetime 2019/1/8 下午5:56
     * @param array $arr 数组
     * @param int $pid 父级id
     * @param int $depth 增加深度标识
     * @param string $p_sub 父级别名
     * @param string $d_sub 深度别名
     * @param string $c_sub 子集别名
     * @return array
     * @author YM
     * @access public
     */
    function handleTreeList($arr, $pid = 0, $depth = 0, $p_sub = 'parent_id', $c_sub = 'children', $d_sub = 'depth')
    {
        $returnArray = [];
        if (is_array($arr) && $arr) {
            foreach ($arr as $k => $v) {
                if ($v[$p_sub] == $pid) {
                    $v[$d_sub] = $depth;
                    $tempInfo = $v;
                    unset($arr[$k]); // 减少数组长度，提高递归的效率，否则数组很大时肯定会变慢
                    $temp = handleTreeList($arr, $v['id'], $depth + 1, $p_sub, $c_sub, $d_sub);
                    if ($temp) {
                        $tempInfo[$c_sub] = $temp;
                    }
                    $returnArray[] = $tempInfo;
                }
            }
        }
        return $returnArray;
    }
}

if (!function_exists('array_pluck')) {
    /**
     * Pluck an array of values from an array.
     * 从数组中提取值组成新数组
     *
     * @param array $array
     * @param string|array $value
     * @param string|array|null $key
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}

if (!function_exists('flushAnnotationCache')) {
    /**
     * flushAnnotationCache
     * 刷新注解缓存，清楚注解缓存
     * User：YM
     * Date：2020/2/4
     * Time：下午12:13
     * @param string $listener
     * @param array $keys
     * @return bool
     */
    function flushAnnotationCache($listener = '', $keys = [])
    {
        if (!$listener || !$keys) {
            throw new \RuntimeException('参数不正确！');
        }
        $keys = is_array($keys) ? $keys : [$keys];
        $dispatcher = ApplicationContext::getContainer()->get(EventDispatcherInterface::class);
        foreach ($keys as $key) {
            $dispatcher->dispatch(new DeleteListenerEvent($listener, [$key]));
        }
        return true;
    }
}


if (!function_exists('formatBytes')) {
    /**
     * formatBytes
     * 字节->兆转换
     * 字节格式化
     * User：YM
     * Date：2020/2/15
     * Time：下午7:29
     * @param $bytes
     * @return string
     */
    function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
        } elseif ($bytes >= 1048576) {
            $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
        } elseif ($bytes >= 1024) {
            $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
        } else {
            $bytes = $bytes . 'Bytes';
        }
        return $bytes;
    }
}

if (!function_exists('durationFormat')) {
    /**
     * durationFormat
     * 时间格式化，格式化秒
     * User：YM
     * Date：2020/2/15
     * Time：下午10:33
     * @param $number
     * @return string
     */
    function durationFormat($number)
    {
        if (!$number) {
            return '0分钟';
        }
        $newTime = '';
        if (floor($number / 3600) > 0) {
            $newTime .= floor($number / 3600) . '小时';
            $number = $number % 3600;
        }
        if ($number / 60 > 0) {
            $newTime .= floor($number / 60) . '分钟';
            $number = $number % 60;
        }
        if ($number < 60) {
            $newTime .= $number . '秒';
        }
        return $newTime;
    }

    /**
     * 雪花算法ID生成
     * @return string
     */
    function snowFlakeId()
    {
        $id = ApplicationContext::getContainer()->get(Hyperf\Snowflake\IdGeneratorInterface::class)->generate();
        return (string)$id;
    }


}




