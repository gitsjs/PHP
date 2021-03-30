<?php

namespace app\index\controller;

use think\Controller;
use think\facade\Env;
use think\Db;
use \app\index\model\User;

class Index extends Controller
{
    // 数据库事件
    public function initialize()
    {
        Db::event('before_select',function ($query){
            echo '执行了批量查询操作!';
        });
        Db::event('after_update',function ($query){
            echo '执行了修改操作';
        });
    }
    public function index()
    {
        return Env::get('app_path');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function getNotModelData()
    {
        // $data = Db::table('tp_user')->select();
        // name()方法使用配置的表前缀
        $data = DB::name('user')->select();
        return json($data);
    }

    public function getModelData()
    {
        // 使用User模型对象调用表名
        $data = User::select();
        return json($data);
    }

    public function getData()
    {
        // 使用find()方法查询一条数据
        // $data = Db::table('tp_user')->find();

        // 使用where()方法查询指定数据
        // $data = Db::table('tp_user')->where('id',27)->find();

        // 使用findOrFail()方法查询一条数据，没有数据时抛出一个异常
        // $data = Db::table('tp_user')->where('id',1)->findOrFail();

        // 使用findOrEmpty()方法查询一条数据，没有数据时返回一个空数组
        // $data = Db::table('tp_user')->where('id',1)->findOrEmpty();

        // 使用select()方法查询多列数据
        $data = Db::table('tp_user')->select();

        // 多列数据查询到没有数据时，返回空数组，使用selectOrFail抛出异常
        // $data = Db::table('tp_user')->where('id',1)->selectOrFail();

        // 如果在数据库配置文件中设置了前缀，那么可以使用name()方法忽略前缀
        // $data = Db::name('user')->selectOrFail();

        // TinkPHP提供助手函数db查询数据
        // $data = \db('user')->select();

        // 通过valuse()方法可以查询指定字段的值（单个），没有数据返回null
        // $data = Db::name('user')->where('id',27)->value('username');

        // 通过column()方法可以查询指定字段的值（多个），没有数据返回null
        // $data = Db::name('user')->column('username');

        // 指定id作为列值的索引
        // $data = Db::name('user')->column('username','id');

        // 保存对象实例，方便反复调用
        $user = Db::name('user');
        $data = $user->select();

        // 使用Db::getLastSql()方法查询最近一条SQL的原生语句
        // $data = Db::getLastSql();
        // return json($data);

        // 当一个对象实例化第二查询后，会保留第一次查询的值
        $data1 = $user->where('id', 27)->order('id', 'desc')->find();
        // $data2 = $user->find();

        // 使用removeOption()方法，可以清理掉上一次查询保留的值
        $data2 = $user->removeOption('where')->removeOption('order')->find();
        return Db::getLastSql();
        // return json($data2);
    }

    public function insert()
    {
        // $data = [
        // 'username' => '辉夜',
        // 'password' => '123',
        // 'gender' => '女',
        // 'email' => 'huiye@163.com',
        // 'price' => 90, 'details' => '123',
        // 'create_time' => date('Y-m-d H:i:s')
        // ];
        // $flag = Db::name('user')->insert($data);
        // return $flag;

        // 使用data()方法设置添加的数据数组
        // Db::name('user')->data($data)->insert();

        // 如果采用的是MySQL数据库，支持REPLACE写入
        // Db::name('user')->insert($data,true);

        // 使用insertGetId()方法，可以在新增成功后犯规当前数据ID
        // Db::name('user')->insertGetId($data);

        $data = [
            [
                'username' => '辉夜1',
                'password' => '123',
                'gender' => '女',
                'email' => 'huiye@163.com',
                'price' => 90, 'details' => '123',
                'create_time' => date('Y-m-d H:i:s')
            ],
            [
                'username' => '辉夜2',
                'password' => '123',
                'gender' => '女',
                'email' => 'huiye@163.com',
                'price' => 90, 'details' => '123',
                'create_time' => date('Y-m-d H:i:s')
            ]
        ];
        // 使用insertAll()方法，可以批量新增数据
        // Db::name('user')->insertAll($data);

        // 批量新增也支持data()方法
        // Db::name('user')->data($data)->insertAll();

        // 批量新增也支持replce写入
        Db::name('user')->insertAll($data, true);
    }

    public function update()
    {
        // $data = [
        //     'username' => '李白',
        //     'email' => Db::raw('UPPER(email)'),
        //     'price' => Db::raw('price - 3'),
        //     'id' => 233
        // ];
        // $data = Db::name('user')->where('id',233)->update($data);
        // return $data;

        // 使用data()啊方法传入要修改的数组
        // Db::name('user')->where('id',233)->data($data)->update(['password'=>'456']);

        // 如果修改数组中包含主键，那么可以直接修改
        // Db::name('user')->data($data)->update(['password'=>'4567']);

        // 使用inc()方法可以对字段增值，dec()方法可以对字段进行减值
        // Db::name('user')->inc('price')->update($data);
        // Db::name('user')->dec('price',3)->update($data);

        // exp()方法可以在字段中使用MySQL函数
        // Db::name('user')->exp('email','UPPER(email)')->update($data);

        // 使用ram()方法修改更新
        // Db::name('user')->update($data);

        // 使用setField()方法可以更新一个字段值
        Db::name('user')->where('id', 233)->setField('username', '辉夜');
    }

    public function delete()
    {
        Db::name('user')->delete(225);

        // 根据主键，删除多条记录
        Db::name('user')->delete([234, 235, 236]);

        // 通过where()方法删除
        Db::name('user')->where('id', 237)->delete();
    }
}
