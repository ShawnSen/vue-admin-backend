<?php
declare (strict_types = 1);

namespace app\service;


use app\common\BaseService;
use app\model\Routes;

class RoutesService extends BaseService
{
    public function __construct()
    {
        // 实例化路由模型
        $this->model = new Routes();

        // 设置查询路由字段
        $this->name = 'title';
    }

    public function routesByTree($uid)  // 传入用户ID
    {
        $user = (new AdminService())->getInfoById($uid); // 查询当前用户
        $role_id = $user->role_id; // 当前用户角色组id
        $role = (new RoleService())->getInfoById($role_id); //当前用户角色组
        // 根据当前传入uid
        $where[] = $role['rules'] == '*' ? true : ['id', 'in', explode(',', $role['rules'])];
        $order = ['sort' => 'desc'];  // 按排序序号由大到小排序（0-99）
        $result = $this->getListAll($where, $order)->toArray();   // 获取所有路由列表
        $result = tree($result);  // 调用公共助手函数tree()方法，将查询到的所有路由按id-pid转换为树形结构
        return $result;
    }

    /**
     * 通过角色组获取路由
     * @param $rules
     * @return array|bool
     */
    public function routesByRules($rules)
    {
        $where = [];
        // 如果角色组rules为*,则代表拥有所有路由访问权限
        if ($rules != '*') {
            $where[] = ['id', 'in', explode(',', $rules)]; // 查询条件
        }
        $routes = $this->getListAll($where)->toArray();
        if (!empty($routes) && is_array($routes)) {
            $routes = tree($routes);  // 将路由转换为树形结构
        }
        return $routes;
    }
}
