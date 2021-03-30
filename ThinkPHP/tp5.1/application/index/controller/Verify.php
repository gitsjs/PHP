<?php
namespace app\index\controller;

use app\common\validate\User;
use think\Controller;
use think\facade\Request;
// use think\Validate;
use think\facade\Validate;
use think\validate\ValidateRule;

class Verify extends Controller
{
    protected $batchValidate =true;
    protected $failException =true;

    public function index()
    {
        $data = [
            'name'  =>  '123',
            'price' =>  190,
            'email' =>  'xiaoxin163.com'
        ];

        $validate = new User();

        if (!$validate->scene('edit')->batch()->check($data)) {
            dump($validate->getError());
        }

        // $result = $this->validate([
        //     'name'  =>  '',
        //     'price' =>  190,
        //     'email' =>  'xiaoxin163.com'
        // ],'\app\common\validate\User.edit');

        // if ($result !== true) {
        //     dump($result);
        // }

        // $validate = new Validate();
        // // $validate->rule('name','require|max:10');
        // $validate->rule([
        //     'name|用户名'    =>  'require|max:10',
        //     'price'         =>  'number|between:1,100',
        //     'email'         =>  'email'
        // ]);
        // if (!$validate->batch()->check($data)) {
        //     dump($validate->getError());
        // }

        // $validate = new Validate();
        // // $validate->rule('name',ValidateRule::isRequire()->max(10));
        // $validate->rule([
        //     'name'  =>  ValidateRule::isRequire()->max(10),
        //     'price' =>  ValidateRule::isNumber()->between('1,100'),
        //     'email' =>  ValidateRule::isEmail(),
        // ]);
        // if (!$validate->batch()->check($data)) {
        //     dump($validate->getError());
        // }

        // $validate = new Validate();
        // $validate->rule([
        //     'name'  =>  function($value,$data){
        //         return $value != ''?true:'姓名不得为空';
        //     },
        //     'price' =>  function($value){
        //         return $value > 0?true:'价格不等小于零';
        //     }
        // ]);
        // if (!$validate->batch()->check($data)) {
        //     dump($validate->getError());
        // }
    }

    public function read($id)
    {
        return 'id='.$id;
    }

    public function facade()
    {
        // 验证邮箱是否合法
        // dump(Validate::isEmail('abc@163.com'));
        // 验证数值合法性
        dump(Validate::checkRule(10,'number|between:1,10'));
    }

    public function check()
    {
        $data = [
            'user' =>   input('post.user'),
            '__token__' => input('post.__token__')
        ];
        $validate = new \think\Validate();
        $validate -> rule([
            'user' =>  'require|token',
        ]);

        if (!$validate->batch()->check($data)) {
            dump($validate->getError());
        }
    }

    public function make()
    {
        dump(Validate::number(-10));
        dump(Validate::number(10));
        dump(Validate::chs('蜡笔小新'));
        dump(Validate::activeUrl('www.baidu.com'));
        dump(Validate::url('http://www.baidu.com'));
        dump(Validate::ip('127.0.0.1'));
        dump(Validate::dateFormat('20-1-1','y-m-d'));
        dump(Validate::eq('100',100));
        dump(Validate::regex('123456','\d{6}'));
        dump(Validate::file(Request::file('image')));
        dump(Validate::image(Request::file('image'),'150,150,gif'));
        dump(Validate::fileExt(Request::file('image'),'jpg,png,gif'));
    }
}
