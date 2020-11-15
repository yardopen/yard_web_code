<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Constants\StatusCode;
use Core\Common\Container\Response;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class AbstractController
{


    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var Response
     */
    protected $response;

    /**
     * success
     * 成功返回请求结果
     * User：YM
     * Date：2019/11/20
     * Time：下午3:56
     * @param array $data
     * @param null $msg
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success($data = [], $msg = null)
    {
        return $this->response->success($data,$msg);
    }

    /**
     * error
     * 业务相关错误结果返回
     * User：YM
     * Date：2019/11/20
     * Time：下午3:56
     * @param int $code
     * @param null $msg
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function error($code = StatusCode::ERR_EXCEPTION, $msg = null)
    {
        return $this->response->error($code,$msg);
    }
}
