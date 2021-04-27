<?php
declare (strict_types = 1);

namespace app\common;


use app\BaseController;
use app\middleware\CheckSign;

class Backend extends BaseController
{
    // 设置当前服务
    protected $service;

    // 请求排除的变量
    protected $exceptField = ['create_time', 'update_time'];

    protected $middleware = [CheckSign::class];
    /**
     * 查询列表
     */
    public function index()
    {
        $result = $this->service->getLists();
        if ($result) {
            return success($result, 'success');
        } else {
            return error('未找到有效数据');
        }
    }

    /**
     * 获取所有数据
     */
    public function getAll() {
        $result = $this->service->getListAll();
        if ($result) {
            return success($result, 'success');
        } else {
            return error('未找到有效数据');
        }
    }

    /**
     * 添加
     */
    public function add()
    {
        $param = request()->param();
        $result = $this->service->add($param);
        if ($result) {
            return success(null, 'success');
        } else {
            return error('新增失败');
        }
    }

    /**
     * 删除数据
     * @param $id
     * @return
     */
    public function delete($id)
    {
        $result = $this->service->delete($id);
        if ($result) {
            return success(null, 'success');
        } else {
            return error('删除失败');
        }
    }

    /**
     * 更新
     * @param $id
     * @return \think\response\Json
     */
    public function update($id)
    {
        $param = request()->except($this->exceptField);
        $result = $this->service->update($id, $param);
        if ($result) {
            return success(null, 'success');
        } else {
            return error('更新失败');
        }
    }

    /**
     * 批量删除
     * @param $ids
     * @return \think\response\Json
     */
    public function multiDelete()
    {
        $ids = request()->param();
        $result = $this->service->multiDelete($ids);
        if ($result) {
            return success(null, 'Del success');
        } else {
            return error('Del failed');
        }
    }
}
