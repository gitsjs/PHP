<?php
namespace app\index\controller;
//use app\index\model\One;
//use app\common\Test;
use app\facade\Test;
use think\Controller;
use think\Exception;
use think\exception\HttpException;
use think\facade\Env;
use think\facade\Hook;
use think\Request;
use think\facade\Log;

class Inject extends Controller
{
    //让中间件在控制器里注册
    //    protected $middleware = ['Auth'];
    //对中间件进行限制
    protected $middleware = [
        'Auth'  =>  ['only'   =>  ['index', 'test']],
        'Check' =>  ['except' =>  ['bhv', 'read']]
    ];
    //    protected $one;
    //    public function __construct(One $one)
    //    {
    //        $this->one = $one;
    //    }
    //    public function index()
    //    {
    //        return $this->one->name;
    //    }

    public function index(Request $request)
    {
        //        bind('one', 'app\index\model\One');
        //        return app('one')->name;
        //        $one = app('one', true);
        //        return $one->name;
        //        return app('app\index\model\One')->name;

        //        批量绑定
        //        bind([
        //            'one'   =>  'app\index\model\One',
        //            'user'   =>  'app\index\model\User',
        //        ]);
        //        return app('one')->name;
        //        bind([
        //            'one'   =>  \app\index\model\One::class,
        //            'user'   =>  \app\index\model\User::class,
        //        ]);
        //        return app('one')->name;
        //        return $request->name;
        // return \think\facade\Request::param('name');

        // try {
        //     echo 0 / 0;
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        //     Log::record('被除数不得为零','error');
        // }
        // return Env::get('think_path');

        // throw new Exception("异常信息", 1);

        // throw new HttpException(404,'页面不存在');
        // abort(404,'页面不存在');
    }

    public function test()
    {
        //        $test = new Test();
        //        return $test->hello('word');
        return Test::hello('Mr.lee!');
    }

    public function bhv()
    {
        //钩子
        Hook::listen('eat', '吃饭');
    }

    public function read($id)
    {
        return 'read:' . $id;
    }
}