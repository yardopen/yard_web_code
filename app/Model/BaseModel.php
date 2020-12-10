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

namespace App\Model;


use Hyperf\DbConnection\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;
use Hyperf\Database\Model\Events\Creating;
use Hyperf\Database\Model\Events\Updating;
use Core\Common\Container\Session;

abstract class BaseModel extends Model implements CacheableInterface
{
    use Cacheable;

    /**
     * @Inject()
     * @var Session
     */
    private $session;

    public $timestamps = true;
    protected $dateFormat = 'U';
    /**
     * 是否启用勾子功能
     * @var bool
     */
    protected $hook = true;
    /**
     * 每个表sn字段名
     * @var string
     */
    protected $primarySn = '';


    /**
     * 创建钩子
     * @param Creating $event
     */
    public function creating(Creating $event)
    {
        if ($this->hook) {
            $account_sn = $this->session->get('account_sn');
            if ($account_sn) {
                $this->setAttribute('creater_sn', $account_sn);
                $this->setAttribute('modifyer_sn', $account_sn);
            }
            $account_name = $this->session->get('account_name');
            if ($account_name) {
                $this->setAttribute('creater_name', $account_name);
                $this->setAttribute('modifyer_name', $account_name);
            }

            $yard_sn = $this->session->get('yard_sn');
            if ($yard_sn) {
                $this->setAttribute('yard_sn', $yard_sn);
            }
            if ($this->primarySn) {
                $this->setAttribute($this->primarySn, snowFlakeId());
            }
        }

    }

    /**
     * 更新钩子
     * @param Updating $event
     */
    public function updating(Updating $event)
    {
        if ($this->hook) {
            $account_sn = $this->session->get('account_sn');
            $account_name = $this->session->get('account_name');

            if ($account_sn) {
                $this->setAttribute('modifyer_sn', $account_sn);
            }
            if ($account_name) {
                $this->setAttribute('modifyer_name', $account_name);
            }
        }
    }

}
