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
     * @param string $msg
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function success($msg = '', $data = [])
    {
        return $this->response->success($data, $msg);
    }

    /**
     * error
     * 业务相关错误结果返回
     * @param string $msg
     * @param int $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function error($msg = '', $code = StatusCode::ERR_EXCEPTION)
    {
        return $this->response->error($code, $msg);
    }
}
