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

    /**
     * 用户登录
     * @param array $param
     * @return array
     * @throws \Exception
     */
    public function login(array $param)
    {
        $param['password'] = encryptPassword($param['password']);
        $chk = $this->authaccountService->first($param, ['yard_sn', "account_sn", "username", 'password', "account_name", "sex", "tel"]);
        if (!$chk) {
            return $this->code(400, "用户名或密码错误");
        }
        if ($param['password'] <> $chk['password']) {
            return $this->code(400, "用户名或密码错误");
        }
        unset($chk['password']);
        $session_res = $this->authaccountService->prodToken($chk['yard_sn'], $chk);
        if (!$session_res) {
            return $this->code(400, "会话存储失败");
        }
        return $this->code(200, "登录成功", ['token' => $session_res]);

    }

    /**
     * 退出
     * @param string $token
     * @return array
     */
    public function logout(string $token)
    {
        $res = $this->authaccountService->logout($token);
        if ($res) {
            return $this->code(200, "成功退出");
        }
        return $this->code(400, "退出失败");
    }

}