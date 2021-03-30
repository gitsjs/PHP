<?php

namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        // 'name|用户名'   =>  'require|max:20|checkName:小明',
        // 'price|价格'    =>  'number|between:1,100',
        // 'email|邮箱'    =>  'email'
        'id'           => 'number|between:1,10'
    ];

    // protected $rule = [
    //     'name'  =>  [
    //         'require',
    //         'max'       =>  10,
    //         'checkName' =>  '小明'
    //     ],
    //     'price' =>  [
    //         'number',
    //         'between'   =>  '1,100'
    //     ],
    //     'email' =>  'email'
    // ];


    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'  =>  '姓名不能为空',
        'name.max'      =>  '姓名不得大于20位',
        'price.number'  =>  '价格必须是数字',
        'price.between' =>  '价格必须1-100之间',
        'email'         =>  '邮箱的格式错误'
    ];

    // 场景验证设置
    // protected $scene = [
    //     'insert' => ['name','price','email'],
    //     'edit'   => ['name','price']
    // ];

    // 公共方法的场景验证
    public function sceneEdit()
    {
        // $edit = $this->only(['name','price'])->remove('name','max|checkName')->append('name','number');
        // return $edit;
    }

    // 自定义规则，名称不能是小明
    protected function checkName($value,$rule,$data,$filed,$title)
    {
        // dump($data);
        // dump($filed);
        // dump($title);

        // return $rule != $value?true:'名称不能是小明';
    }
}
