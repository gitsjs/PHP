<?php


namespace app\index\controller;
use think\Request;

class Error
{
    public function index(Request $r)
    {
        return '此控制器不存在' . $r->controller();
    }
    public function miss()
    {
        return '路由不存在,404';
    }
}