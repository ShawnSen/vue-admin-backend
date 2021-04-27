<?php
declare (strict_types = 1);

namespace app\service;


use app\common\BaseService;
use app\model\Admin;
use app\utils\JwtUtil;

class AdminService extends BaseService
{
    // 构造方法
    public function __construct()
    {
        // 当前服务模型实例化
        $this->model = new Admin();

        // 设置当前对应模型默认查询字段
        $this->name = 'username';

        // 设置默认允许查询的字段，密码信息为敏感信息，管理员账户查询时默认不查询密码和密码盐
        $this->allowField = ['id', 'username', 'role_id', 'status', 'avatar', 'create_time'];
    }

    public function getWithRole()
    {
        $roleService = new RoleService();  //角色组服务
        $result = $this->getListAll();
        if (!empty($result)) {
            foreach ($result as &$item) {
                $role = $roleService->getInfoById($item['role_id']); // 通过角色组ID查询角色组信息
                $item['role_name'] = $role->name; // 角色组名称
            }
        }
        return $result;
    }

    /**
     * 管理员登录
     * @param $username
     * @param $password
     * @return array|bool
     */
    public function login($username, $password)
    {
        $this->allowField = ['*']; // 临时允许所有字段，需要对密码进行验证
        $info = $this->getInfoByName($username);  // 通过用户名查找用户信息
        if (!$info) {   // 未找到该用户名
            return false;
        }
        $password = md5(md5($password) . $info->salt); // 加密密码，（与新增管理员加密方式一致）
        if ($password != $info->password) { // 与存入加密后的密码进行对比，如果不一致则密码错误
            return false;
        }
        // 以上验证都通过后对管理员签发登录证书
        $roleService = new RoleService();
        $role_key = $roleService->getInfoById($info->role_id)['key']; // 获取角色组key
        $jwt = JwtUtil::issue($info->id, $role_key);  // 调用jwt工具类中issue()方法，传入用户ID，模拟传入角色组关键词
        return ['token' => $jwt];  // 返回登录token
    }

    /**
     * 更新管理员信息
     * @param $id
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function update($id, $data)
    {
        $result = $this->model->find($id);
        if ($result) {
            // 如果密码不为空时，重新md5加密，不改变密码盐
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = md5(md5($data['password']) . $result['salt']);
            }
            return $result->save($data);
        } else {
            return false;
        }
    }
}
