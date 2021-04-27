<?php
declare (strict_types = 1);

namespace app\service;


use app\common\BaseService;
use app\model\Role;

class RoleService extends BaseService
{
    public function __construct()
    {
        // 实例化角色组模型
        $this->model = new Role();
    }

    public function roleWithRoutes()
    {
        $result = $this->getListAll()->toArray();  // 获取所有角色组列表
        foreach ($result as &$item) {
            $routes = (new RoutesService())->routesByRules($item['rules']); // 查询每个角色组方法
            $item['routes'] = $routes;
        }
        return $result;
    }
}
