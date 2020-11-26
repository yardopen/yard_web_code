<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-20:03
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace App\Controller;


use App\Request\Auth\LoginRequest;

/**
 * Class AuthController
 * @package App\Controller
 * @property \Core\Repository\AuthaccountRepository $authaccountRepository
 */
class AuthController extends BaseController
{

    public function login(LoginRequest $request)
    {
        $param = $request->validated();
        $res = $this->authaccountRepository->login($param);
        if ($res['code'] == 200) {
            return $this->success($res['msg'], $res['data']);
        }
        return $this->error($res['msg']);
    }
}