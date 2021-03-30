<?php

namespace app\index\controller;

use think\facade\Request;

class Upload
{
    public function index()
    {
        // 获取表单上传的数据
        $file = Request::file('image');
        // 移动到应用目录uploads下
        $info = $file->move('../application/uploads');
        // $info = $file->validate([
        //     'size' =>   102400,
        //     'ext'  =>   'jpg,gif,png',
        //     // 'type' =>   'text/html'
        // ])->move('../application/uploads');

        // 判断上传信息
        if ($info) {
            // 输出上传信息
            echo $info->getExtension();
            echo '<br>';
            echo $info->getSaveName();
            echo '<br>';
            echo $info->getFilename();
        } else {
            // 输出错误信息
            echo $file->getError();
        }
    }

    // public function uploads()
    // {
    //     $files = Request::file('image');
    //     foreach ($files as $file) {
    //         $info = $file->move('../application/uploads');
    //         if ($info) {
    //             echo $info->getExtension();
    //             echo '<br>';
    //             echo $info->getSaveName();
    //             echo '<br>';
    //             echo $info->getFilename();
    //         } else {
    //             echo $file->getError();
    //         }
    //     }
    // }
}
