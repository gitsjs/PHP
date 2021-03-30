<?php

namespace app\index\controller;

use think\Controller;
use \app\index\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

class See extends Controller
{
    // 初始化中全局过滤
    public function initialize()
    {
        // return $this->filter(function ($content) {
        //     return str_replace('1', '<br/>', $content);
        // });
    }

    public function index()
    {
        // 自动定位
        // return $this->fetch();

        // 如果想制定一个输出的模板，可以在fetch()方法传递相应的参数
        // return $this->fetch('edit');                //指定模板
        // return $this->fetch('public/edit');         //目录下的模板
        // return $this->fetch('admin@public/edit');   //指定模块下的模板
        // return $this->fetch('/edit');               //view_path下的模板

        // 如果没有继承Controller控制器的话，可以使用助手函数view()方法
        // return view('edit');

        // 视图赋值
        // 在继承控制器基类的情况下，可以使用assign()方法进行赋值
        $this->assign('name', 'ThinkPHP');
        // 也可以通过数组的方式，进行多个变量的赋值
        $this->assign([
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
        // return $this->fetch('index');
        // assign()方法和fetch()方法也可以合二为一进行操作
        // return $this->fetch('index', [
        //     'username'      =>      '辉夜',
        //     'email'         =>      'huiye@163.com'
        // ]);

        // 使用view()助手函数实现渲染并赋值操作
        // return view('index', [
        //     'username'      =>      '辉夜',
        //     'email'         =>      'huiye@163.com'
        // ]);

        // 如果需要对模板页面输出的变量进行过滤，可以使用filter()方法
        // $this->filter(function ($content) {
        //     return str_replace('1', '<br/>', $content);
        // })->fetch();

        // return view('index')->assign([
        //     'username'      =>      '辉1夜',
        //     'email'         =>      'huiye@163.com'
        // ]);

        // 也可以使用函数实现模板变量的过滤功能
        return view()->filter(function ($content) {
            return str_replace('1', '<br/>', $content);
        });
    }

    public function testDisplay()
    {
        // 使用display()方法，可以不通过模板直接解析变量
        $content = '{$username}.{$email}';
        return $this->display($content, [
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
    }

    public function varOutput()
    {
        // 如果传递的值是数组，那么编译文件也会自动相应的对应输出方式
        $data['username']       =      '辉夜';
        $data['email']          =      'huiye@163.com';
        $this->assign('user', $data);
        // return $this->fetch('var');

        // 如果传递的值是对象，那么编译文件也会自动相应的对应输出方式
        $obj = new \stdClass();
        $obj->username = '辉夜';
        $obj->email    = 'huiye@163.com';
        $this->assign('obj', $obj);
        // return $this->fetch('var');

        // 控制器端先赋值一个密码的变量，模板区设置md5加密操作
        $this->assign('password', '123456');
        // return $this->fetch('var');

        $this->assign('time', time());
        $this->assign('number', '14');
        return $this->fetch('var');
    }

    public function loop()
    {
        $list = UserModel::all();
        $this->assign('list', $list);
        return $this->fetch('user');
    }

    public function compare()
    {
        $this->assign('username', 'Mr.lee');
        $username = 'Mr.lee';
        $this->assign('username', $username);
        $this->assign('number', 10);
        return $this->fetch('compare');
    }

    public function condition()
    {
        $this->assign('number', 20);

        $user = new \stdClass();
        $user->username = 'Mr.lee';
        $this->assign('user', $user);
        return $this->fetch('condition');
    }

    public function other()
    {
        //        $this->assign('name','ThinkPHP');
        return $this->fetch('other');
    }

    public function vali()
    {
        // 打印生成的token随机数
        echo Request::token();
        echo '<br />';
        // 打印出保存到session的token
        echo Session::get('__token__');
        return $this->fetch('vali');
    }

    public function code()
    {
        return $this->fetch('code');
    }
}
