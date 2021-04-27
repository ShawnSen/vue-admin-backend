<?php
declare (strict_types = 1);

namespace app\common;


class BaseService
{
    // 当前操作的模型
    protected $model = null;

    // 对应模型的主键，默认为id
    protected $pk = 'id';

    // 对应模型默认查询的字段
    protected $name = 'name';

    // 对应模型允许查询的字段(默认全部查询)
    protected $allowField = ['*'];

    /**
     * 根据主键获取信息
     * @param $id
     * @param bool $where 查询条件
     * @return mixed
     */
    public function getInfoById($id, $where = true)
    {
        return $this->model
            ->field($this->allowField)
            ->where($this->pk, $id)
            ->where($where)
            ->find();
    }

    /**
     * 根据默认查询字段查询
     * @param $name
     * @param bool $where
     * @return mixed
     */
    public function getInfoByName($name, $where = true)
    {
        return $this->model
            ->field($this->allowField)
            ->where($this->name, $name)
            ->where($where)
            ->find();
    }

    /**
     * 查询满足条件的数量
     * @param bool $where 查询条件
     * @return mixed
     */
    public function getTotal($where = true)
    {
        return $this->model
            ->where($where)
            ->count();
    }

    /**
     * 分页查询
     * @param bool $where 查询条件
     * @param array $order 排序规则
     * @param int $page 当前页
     * @param int $limit 每页查询数量
     * @return mixed
     */
    public function getLists($page = 1, $limit = 20, $where = true, $order = ['id' => 'asc'])
    {
        $data =  $this->model
            ->field($this->allowField)
            ->where($where)
            ->order($order)
            ->page($page, $limit)
            ->select();
        $count = $this->getTotal($where);
        return ['page' => $page, 'limit' => $limit, 'count' => $count, 'data' => $data];
    }

    /**
     * 查询所有数据
     * @param bool $where 查询条件
     * @param array $order 排序
     * @return mixed
     */
    public function getListAll($where = true, $order = ['id' => 'asc'])
    {
        return $this->model
            ->field($this->allowField)
            ->where($where)
            ->order($order)
            ->select();
    }

    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        $result = $this->model->create($data);
        if ($result) {
            return $result;
        } else {
            return  false;
        }
    }

    /**
     * 更新数据
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $result = $this->model->find($id);
        if ($result) {
            return $result->save($data);
        } else {
            return false;
        }
    }

    /**
     * 删除数据
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            return $result->delete();
        } else {
            return false;
        }
    }

    /**
     * 批量删除
     * @param $ids
     * @return boolean
     */
    public function multiDelete($ids)
    {
        $result = $this->model->destroy($ids);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
