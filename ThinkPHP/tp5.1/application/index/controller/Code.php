<?php
namespace app\index\controller;

use think\captcha\Captcha;
use think\Controller;
use think\facade\Request;

class Code extends Controller
{
    public function index()
    {
        $data = [
            'code' => Request::post('code')
        ];

        $flag = $this->validate($data,[
            'code|验证码' => 'require|captcha'
        ]);
        dump($flag);
    }
    public function show()
    {
        // $config =    [
        //     // 验证码字体大小
        //     'fontSize'    =>    30,
        //     // 验证码位数
        //     'length'      =>    3,
        //     // 关闭验证码杂点
        //     'useNoise'    =>    false,
        // ];
        $captcha = new Captcha();
        $captcha->fontSize = 30;
        $captcha->length   = 3;
        $captcha->useNoise = false;
        return $captcha->entry();
    }
    public function check()
    {
        $captcha = new Captcha();
        dump($captcha->check(Request::post('code')));
    }
}