<?php
namespace app\http\middleware;

use think\Request;

class Auth
{
    public function handle(Request $request, \Closure $next,$name)
    {
        echo $name;
        if ($request->param('id') == 10)
        {
            $request->name = 'Mr.lee';
            echo '是管理员，提供后台权限并跳转操作!';
        }
        return $next($request);
    }
}
