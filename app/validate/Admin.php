<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require|regex:\w{3,16}|unique:admin', // 用户名必填 3-16个字符（不含特殊字符），在数据库中唯一
        'password' => 'require|regex:\S{6,32}', // 密码必填，最低6个字符，最高32个字符
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    /**
     * 编辑时，不检测密码必填（为空时不修改密码）
     */
    public function sceneEdit()
    {
        return $this->remove('password', 'require');
    }

    public function __construct()
    {
        // 返回提示信息
        $this->field = [
            'username' => '用户名',
            'password' => '密码'
        ];
        parent::__construct();
    }
}
