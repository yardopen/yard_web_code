<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * 自定义业务代码规范如下：
 * 授权相关，1001……
 * 用户相关，2001……
 * 业务相关，3001……
 * @method static StatusCode getMessage(int $error_code) 获取对应状态友的错误信息
 */
class StatusCode extends AbstractConstants
{
    /**
     * @Message("ok")
     */
    const SUCCESS = 200;

    /**
     * @Message("业务逻辑异常！")
     */
    const ERR_EXCEPTION = 400;

    /**
     * @Message("Internal Server Error!")
     */
    const ERR_SERVER = 500;


    /**
     * @Message("请登录获取令牌！")
     */
    const ERR_NOT_LOGIN = 1001;

    /**
     * @Message("令牌过期！")
     */
    const ERR_EXPIRE_TOKEN = 1002;

    /**
     * @Message("令牌无效！")
     */
    const ERR_INVALID_TOKEN = 1003;
    /**
     * @Message("令牌不存在！")
     */
    const ERR_NOT_EXIST_TOKEN = 1004;


}
