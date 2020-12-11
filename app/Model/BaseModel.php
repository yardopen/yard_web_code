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
     * 通过主键id获取信息
     * @param array|int $id
     * @param bool $useCache
     * @return array
     */
    public function getInfo($id, $useCache = true)
    {
        $instance = make(get_called_class());
        if ($useCache === true) {
            $modelCache = is_array($id) ? $instance->findManyFromCache($id) : $instance->findFromCache($id);
            return isset($modelCache) && $modelCache ? $modelCache->toArray() : [];
        }
        $query = $instance->query()->find($id);
        return $query ? $query->toArray() : [];
    }

    /**
     * 创建/修改记录
     * @param array $data 保存数据
     * @return string
     */
    public function saveInfo($data)
    {
        $id = empty($data[$this->primaryKey]) ? 0 : $data[$this->primaryKey];
        $primarySn = $this->primarySn;
        $instance = make(get_called_class());
        if ($id) {
            $instance = $instance->query()->find($id);
        }
        foreach ($data as $k => $v) {
            $instance->$k = $v;
        }
        $res = $instance->save();
        return $res ? $instance->$primarySn : '';


    }

    /**
     * getInfoByWhere
     * 根据条件获取结果
     * User：YM
     * Date：2020/1/9
     * @param array $where
     * @param array $columns
     * @param bool $more 是否查询多条
     * @return array
     */
    public function getInfoByWhere($where, $columns = ['*'], $more = false)
    {
        $instance = make(get_called_class());
        foreach ($where as $k => $v) {
            $instance = is_array($v) ? $instance->where($k, $v[0], $v[1]) : $instance->where($k, $v);
        }
        $instance->where("yard_sn", $this->session->get("yard_sn"));  //

        $instance = $more ? $instance->get($columns) : $instance->first($columns);

        return $instance ? $instance->toArray() : [];
    }

    /**
     * deleteInfo
     * 删除/恢复
     * User：YM
     * Date：2020/2/3
     * Time：下午8:22
     * @param $ids 删除的主键ids
     * @param string 删除delete/恢复restore
     * @return int
     */
    public function deleteInfo($ids, $type = 'delete')
    {
        $instance = make(get_called_class());
        if ($type == 'delete') {
            return $instance->destroy($ids);
        } else {
            $count = 0;
            $ids = is_array($ids) ? $ids : [$ids];
            foreach ($ids as $id) {
                if ($instance::onlyTrashed()->find($id)->restore()) {
                    ++$count;
                }
            }

            return $count;
        }
    }


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
