<?php
namespace app\index\controller;
use think\Db;

class Select{
    public function index(){
        // where方法查询
        // $result = Db::name('user')->where('id',20)->find();
        // $result = Db::name('user')->where('id','=',20)->find();

        // 使用<>、>、<、<=、<=可以筛选出各种符合比较值的数据列表
        // $result = Db::name('user')->where('id','<>',20)->select();

        // 使用like表达式进行模糊查询
        // $result = Db::name('user')->where('email','like','xiao%')->select();

        // like表达式还可以支持数组传递进行模糊查询
        // $result = Db::name('user')->where('email','like',['xiao%','wu%'],'or')->select();

        // like表达式有两个快捷方式whereLike()和whereNotLike()
        // $result = Db::name('user')->whereLike('email','xiao%')->select();
        // $result = Db::name('user')->whereNotLike('email','xiao%')->select();

        // between表达式有两个快捷方式whereBetween()和whereNotBetween()
        // $result = Db::name('user')->where('id','between','19,25')->select();
        // $result = Db::name('user')->where('id','between',[19,25])->select();
        // $result = Db::name('user')->whereBetween('id',[19,25])->select();
        // $result = Db::name('user')->whereNotBetween('id',[19,25])->select();

        // in表达式有两个快捷方式whereIn()和whereNotIn()
        // $result = Db::name('user')->where('id','in','19,21,29')->select();
        // $result = Db::name('user')->whereIn('id','19,21,29')->select();
        // $result = Db::name('user')->whereNotIn('id','19,21,29')->select();

        // null表达式有两个快捷方式whereNull()和whereNotNull()
        // $result = Db::name('user')->where('uid','null')->select();
        // $result = Db::name('user')->where('uid','not null')->select();
        // $result = Db::name('user')->whereNull('uid')->select();
        // $result = Db::name('user')->whereNotNull('uid')->select();

        // 使用exp可以自定义字段后的SQL语句
        // $result = Db::name('user')->where('id','exp','IN (19,21,25)')->select();
        // $result = Db::name('user')->whereExp('id','IN (19,21,25)')->select();

        // 使用>、<、>=、<=来筛选匹配时间的数据
        // $result = Db::name('user')->where('create_time','> time','2018-1-1')->select();

        // 使用between关键字开设置时间的区间
        // $result = Db::name('user')->where('create_time','between time',['2018-1-1','2019-1-1'])->select();
        // $result = Db::name('user')->where('create_time','not between time',['2018-1-1','2019-1-1'])->select();

        //  时间查询的快捷方式为whereTime(),直接使用>、<、>=、<=
        // $result = Db::name('user')->whereTime('create_time','>','2018-1-1')->select();

        // 快捷方式也可以使用 between和not between
        // $result = Db::name('user')->whereBetween('create_time',['2018-1-1','2019-1-1'])->select();

        // 另一种快捷方式为：whereBetweenTime()，如果只有一个参数就表示一天
        // $result = Db::name('user')->whereBetweenTime('create_time','2018-1-1','2019-1-1')->select();

        // 固定查询时间
        // $result = Db::name('user')->whereTime('create_time','d')->select();
        // $result = Db::name('user')->whereTime('create_time','y')->select();

        // 查询指定时间的数据，比如两小时内
        // $result = Db::name('user')->whereTime('create_time','-2 hour')->select();

        // 查询两个时间字段时间有效的数据，比如会员开始到结束的期间
        // $result = Db::name('user')->whereBetweenTimeField('create_time','update_time')->select();

        // 使用count()方法，可以求出所查询数据的数量
        $result = Db::name('user')->count();

        // count()可设置指定id
        $result = Db::name('user')->count('uid');

        // 使用max()方法，求出所查询数据字段的最大值
        $result = Db::name('user')->max('price');

        // 如果max()方法，求出的值不是数值，则通过第二参数强制转换
        $result = Db::name('user')->max('price',false);

        // 使用min()方法，求出所查询数据字段的最小值，也可以强制转换
        $result = Db::name('user')->min('price');

        // 使用avg()方法，求出所查询数据字段的平均值
        $result = Db::name('user')->avg('price');

        // 使用sum()方法，求出所查询数据字段的总和
        $result = Db::name('user')->sum('price');

        // 使用fetchSql()方法，可以设置不执行SQL，而返回SQL语句，默认为true
        $result = Db::name('user')->fetchSql(true)->select();

        // 使用buidSql()方法，也是返回SQL语句，但不需要在执行select()，且有括号
        $result = Db::name('user')->buildSql(true);

        // 子查询
        $subQuery = Db::name('two')->field('uid')->where('gender','男')->buildSql(true);
        $result = Db::name('one')->where('id','exp','IN '.$subQuery)->select();

        // 使用闭包方式执行子查询
        $result = Db::name('one')->where('id','in',function($query){
            $query->name('two')->where('gender','男')->field('uid');
        })->select();

        // 使用query()方法，进行原生SQL查询，适用于读取操作，SQL错误返回false
        $result = Db::query('select * from tp_user');

        // 使用execute()方法，进行原生SQL更新写入等，SQL错误返回false
        Db::execute('update tp_user set username="孙悟空" where id = 29');

        // return Db::getLastSql();
        // return $subQuery;
        // return $result;
        // return json($result);

    }
}
