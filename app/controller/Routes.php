<?php
declare (strict_types = 1);

namespace app\controller;


use app\common\Backend;
use app\service\RoutesService;

class Routes extends Backend
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        // 实例化路由服务
        $this->service = new RoutesService();
    }

    public function index()
    {
        $uid = request()->uid; // 中间件传值
        $result = $this->service->routesByTree($uid);  // 调用路由服务中树形结构
        if ($result) {
            return success($result, 'success');
        } else {
            return error('未找到有效数据');
        }
    }
}
