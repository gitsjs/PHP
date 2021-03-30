<?php
namespace app\index\controller;

use think\facade\Log;
class Record
{
    public function index()
    {
        Log::record('测试日志!','error');
        Log::clear();
        $log = Log::getLog();
        dump($log);
    }
}