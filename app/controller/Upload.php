<?php
declare (strict_types = 1);

namespace app\controller;


use app\common\Backend;

class Upload extends Backend
{
    /**
     * 简易头像（文件上传）
     */
    public function upload() {
        $file = request()->file('file');  // 接收类型
        $saveName = \think\facade\Filesystem::disk('public')->putFile('topic', $file);  // 文件储存位置
        $avatar = 'http://127.0.0.1:8001/storage/' . $saveName;  // 写入完整的图片路径（域名后续可以通过config配置文件引用，这里只做示例）
        return success($avatar); // 返回图片地址信息
    }
}
