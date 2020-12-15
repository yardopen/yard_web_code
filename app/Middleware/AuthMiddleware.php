<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\StatusCode;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Core\Common\Facade\Cache;
use Core\Common\Container\Response;

class AuthMiddleware implements MiddlewareInterface
{


    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    public function __construct(Response $response, RequestInterface $request)
    {

        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $isValidToken = $this->tokenVaild();
        if ($isValidToken === StatusCode::SUCCESS) {
            return $handler->handle($request);
        }

        return $this->response->error($isValidToken);
    }

    /**
     * 判断当前tokn是否效
     * @return int
     */
    private function tokenVaild()
    {

        $token = $this->request->getHeaderLine('token');
        if (empty($token)) {
            return StatusCode::ERR_NOT_LOGIN;
        }
        $cache = Cache::get();
        $token_json = $cache->get($token);
        if (empty($token_json)) {
            return StatusCode::ERR_EXPIRE_TOKEN;
        }
        try {
            $cache->expire($token, Cache::maxIdelTime());
            $token_arr = json_decode($token_json, true);
            if (is_array($token_arr) && !empty($token_arr['yard_sn'])) {
                return StatusCode::SUCCESS;
            }
        } catch (\Exception $e) {
            return StatusCode::ERR_INVALID_TOKEN;
        }

    }
}