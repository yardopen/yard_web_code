<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/11/25-21:00
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Repository;

/**
 * Class AuthaccountRepository
 * @package Core\Repository
 * @property \Core\Service\AuthaccountService $authaccountService
 */
class AuthaccountRepository extends BaseRepository
{

    public function login(array $param)
    {
        $chk = $this->authaccountService->first($param, ['yard_sn', "account_sn", "username", "account_name", "sex", "tel"]);
        if (!$chk) {
            return $this->code(400, "用户名或密码错误");
        }

        $session_res = $this->authaccountService->prodToken($chk['yard_sn'], $chk);
        if (!$session_res) {
            return $this->code(400, "会话存储失败");
        }
        return $this->code(200, "登录成功", ['token' => $session_res]);

    }

}