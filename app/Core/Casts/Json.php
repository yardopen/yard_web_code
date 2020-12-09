<?php
/**
 * YardOpen
 * Created by 大宇  Mars
 * Create Date 2020/12/9-22:24
 * Team Name HornIOT
 **/
declare (strict_types=1);

namespace Core\Casts;

use Hyperf\Contract\CastsAttributes;

class Json implements CastsAttributes
{
    /**
     * 将取出的数据进行转换
     */
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }

    /**
     * 转换成将要进行存储的值
     */
    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}