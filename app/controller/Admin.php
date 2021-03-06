<?php
declare (strict_types = 1);

namespace app\controller;


use app\common\Backend;
use app\service\AdminService;
use think\exception\ValidateException;

class Admin extends Backend
{
    // 初始化
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        // 当前控制器服务实例化
        $this->service = new AdminService();
    }

    public function getAll()
    {
        $result = $this->service->getWithRole();
        if ($result) {
            return success($result, 'success');
        } else {
            return error('未找到有效数据');
        }
    }

    public function add()
    {
        $param = request()->param();   // 获取请求中传入的参数
        try {
            validate(\app\validate\Admin::class)->check($param); // 验证输入信息
            // 规则验证通过后对密码进行加密（采用md5 + 密码盐方式进行加密）
            $param['salt'] = alnum();  // 调用公共助手函数中alnum()方法，随机生成密码盐，默认6个字符
            $param['password'] = md5(md5($param['password']) . $param['salt']); // 先对原始密码md5加密，加上密码盐后再次md5加密
            $result = $this->service->add($param);  // 加密密码后调用服务中add()方法将密码盐和加密后的密码与用户名存入对应模型数据库中
            if ($result) {
                return success(null, '添加管理员成功');
            } else {
                return error('添加失败');
            }
        } catch (ValidateException $e) {
            return error($e->getMessage());
        }
    }

    public function update($id)
    {
        $param = request()->except($this->exceptField);
        try {
            // 验证器验证，启用编辑验证
            validate(\app\validate\Admin::class)->scene('edit')->check($param);
            $result = $this->service->update($id, $param);
            if ($result) {
                return success(null, '更新成功');
            } else {
                return error('更新失败');
            }
        } catch (ValidateException $e) {
            return error($e->getMessage());
        }
    }

    // 获取用户信息
    public function userInfo()
    {
        $uid = request()->uid;  // 中间件传值，用户id
        $role = request()->role_key;  // 中间件传值，角色组key
        $result = $this->service->getInfoById($uid);  // 调用管理员服务中通过id获取用户信息方法
        if ($result) {
            $result['roles'] = [$role]; // 用户角色组
            return success($result, 'success');
        } else {
            return error('未找到用户信息');
        }
    }
}
