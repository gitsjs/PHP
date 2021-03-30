<?php
namespace app\index\controller;
use think\Db;

class Chain{
    public function index()
    {
        // 表达式查询，where()方法的基础查询方式
        $result = Db::name('user')->where('id','>',70)->select();

        // 关联数组查询，通过数组键值对匹配的查询方式
        $result = Db::name('user')->where([
            'gender'    =>  '男',~
            'price'     =>  100
            // 'price'     =>  [60,70,80]
        ])->select();

        // 索引数组查询，通过数组里的数组拼装方式来查询
        $result = Db::name('user')->where([
            ['gender','=','男'],
            ['price','=','100']
        ])->select();

        // 将复杂数组组装后，通过变量传递
        $map[] = ['gender','=','男'];
        $map[] = ['price','in',[60,70,80]];
        $result = Db::name('user')->where($map)->select();

        // 字符串形式传递
        $result = Db::name('user')->where('gender="男" AND price IN (60,70,80)')->select();

        // 使用field()方法，可以指定要查询的字段
        $result = Db::name('user')->field('id,username,email')->select();
        $result = Db::name('user')->field(['id','username','email'])->select();

        // 使用field()方法，给指定的字段设置别名
        $result = Db::name('user')->field('id,username as name')->select();
        $result = Db::name('user')->field(['id','username'=>'name'])->select();

        // 在field()方法里，可以直接给字段设置MySQL函数
        $result = Db::name('user')->field('id,SUM(price)')->select();

        // 对于更加复杂的MySQL函数，必须使用字段数组形式
        $result = Db::name('user')->field(['id','LEFT(email,5)'=>'leftemail'])->select();

        // 使用field(true)的布尔参数，可以显式的查询获取所有字段，而不是*
        $result = Db::name('user')->field(true)->select();

        // 使用field()方法中字段排除，可以屏蔽掉想要不显示的字段
        $result = Db::name('user')->field('details,email',true)->select();
        $result = Db::name('user')->field(['details','email'],true)->select();

        // 使用alias()方法，给数据库起一个别名
        $result = Db::name('user')->alias('a')->select();

        // 使用limit()方法，限制获取输出数据的个数
        $result = Db::name('user')->limit(5)->select();

        // 分页模式，即传递两个参数，比如第3条开始显示5条limt(2,5)
        $result = Db::name('user')->limit(2,5)->select();

        // 实现分页，需要严格计算每页显示的条数，然后从第几条开始
        // 第一页
        $result = Db::name('user')->limit(0,5)->select();
        // 第二页
        $result = Db::name('user')->limit(5,5)->select();

        // page()分页方法，优化了limit()方法，无需计算分页条数
        // 第一页
        $result = Db::name('user')->page(1,5)->select();
        // 第二页
        $result = Db::name('user')->page(2,5)->select();

        // 使用order()方法，可以指定排序方式，没有指定第二参数，默认asc
        $result = Db::name('user')->order('id','desc')->select();

        // 支持数组方式，对多个字段进行排序
        $result = Db::name('user')->order(['id'=>'desc','price'=>'asc'])->select();

        // 使用group()方法，给性别不同的人进行price字段的总和统计
        $result = Db::name('user')->field('gender,SUM(price)')->group('gender')->select();

        // 多字段分组统计
        $result = Db::name('user')->field('gender,SUM(price)')->group('gender,password')->select();

        // 使用gruop()分组后，再使用having()进行筛选
        $result = Db::name('user')
                ->field('gender,SUM(price)')
                ->group('gender')
                ->having('SUM(price)>600')
                ->select();

        return Db::getLastSql();
        return json($result);
    }

    public function insert()
    {
        $data  = [
            'username' => '辉夜',
            'password' => '123',
            'gender' => '女',
            'email' => 'huiye@163.com',
            'price' => 90, 'details' => '123',
            'create_time' => date('Y-m-d H:i:s')
        ];
        // 使用field()方法在新增时，验证字段的合法性
        $insert = Db::name('user')->field('username,password,email,details')->insert($data);
        return $insert;
    }
}