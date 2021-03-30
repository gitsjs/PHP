<?php
namespace app\index\controller;

use think\Controller;
//use think\Request;
use think\facade\Request;
use think\facade\Url;

class Rely extends Controller
{
//    public function index()
//    {
//        return $this->request->param('name');
//    }

//    public function index(Request $request)
//    {
//        return $request->param('name');
//    }

//    protected $request;
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }

    public function index()
    {
//        return $this->request->param('name');
//        // 获取完整URL地址 不带域名
//        return Request::url();
//        // 获取完整URL地址 包含域名
//        return Request::url(true);
//        // 获取当前URL（不含QUERY_STRING） 不带域名
//        return Request::baseFile();
//        // 获取当前URL（不含QUERY_STRING） 包含域名
//        return Request::baseFile(true);
//        // 获取URL访问根地址 不带域名
//        return Request::root();
//        // 获取URL访问根地址 包含域名
//        return Request::root(true);
//
//        dump(Request::has('id', 'get'));
//        dump(Request::has('username', 'post'));
//
//        //获取请求为name的值，过滤
//        dump(Request::param('name'));
//        //获取所有的请求变量，以数组形式，过滤
//        dump(Request::param());
//        //获取所有请求的变量(原始变量)，不包含上传变量，不过滤
//        dump(Request::param(false));
//        //获取所有请求的变量，包含上传变量，过滤
//        dump(Request::param(true));
//
//        //如果获取不到值，支持请求的变量设置一个默认值
//        dump(Request::param('name', 'nodata'));
//
//        //使用 only()方法，可以获取指定的变量，也可以设置默认值
//        dump(Request::only('id,name'));
//        dump(Request::only(['id','name']));
//        dump(Request::only(['id'=>1,'name'=>'nodeta']));
//
//        //为了简化操作，Request 对象提供了助手函数
//        //判断get下的id是否存在
//        dump(input('?get.id'));
//        //判断post下的name是否存在
//        dump(input('?post.name'));
//        //获取param下的name值
//        dump(input('param.name'));
//        //默认值
//        dump(input('param.name', 'nodate'));
//        //过滤值
//        dump(input('param.name','','htmlspecialchars'));
//        //设置强制转化
//        dump(input('param.id/d'));

//        return Request::method(true);
//        dump(Request::isAjax());
//        dump(Request::header());
//        dump(Request::header('host'));

    }

    public function read(\think\Request $request)
    {
        return $request->name;
    }

    public function edit($id)
    {
        dump(Request::param());
        dump(Request::route());
        dump(Request::get());
    }
//    public function index()
//    {
//        return Request::param('name');
//    }

//    public function index()
//    {
//        return request()->param('name');
//    }

    public function url()
    {
        //使用Url::build()方法获取当前的url路径
        return Url::build();
        //使用Request::ext()方法得到当前伪静态
        return Request::ext();
    }

//    public function get($id = 0)
//    {
//        return 'get:'.$id;
//    }

    public function get($id,$name)
    {
        return 'get:'.$id.','.$name;
    }

    public function res()
    {
            $data = 'hello world';
            // return response($data);
            // return response($data,201);
            // return response($data)->code(202);
            // return json($data,201);
            // return json($data)->code(202);
            return json($data)->code(202)->header(['Cache-control' => 'no-cache,must-revalidate']);
    }

    public function rdc()
    {
        // return redirect('http://www.baidu.com');
        // return redirect('edit/5');
        return redirect('/index/address/details/id/5');

    }
}