<?php
declare (strict_types = 1);

namespace app\controller;


use app\common\Backend;
use app\service\RoleService;

class Role extends Backend
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        // 实例化角色组服务
        $this->service = new RoleService();
    }

    /**
     * 新增角色组
     */
    public function add()
    {
        $param = request()->param();
        $param['rules'] = implode(',', $param['rules']); // 将数组转化为字符串，以','分割
        $result = $this->service->add($param);  // 调用服务中新增方法
        if ($result) {
            return success(null, '新增成功');
        } else {
            return error('新增失败');
        }
    }

    /**
     * 查询角色组（含权限路由）
     */
    public function getRoles()
    {
        $result = $this->service->roleWithRoutes();
        if ($result) {
            return success($result, 'success');
        } else {
            return error('未找到有效数据');
        }
    }
}
