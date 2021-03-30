<?php

namespace app\index\controller;

use \app\index\model\User as UserModel;
use think\Db;
use think\Controller;

class User extends Controller
{
    public function index()
    {
        // $result = UserModel::select();

        // 删除以uid为主键的数据
        // UserModel::destroy('2');

        // return $result;
        // print_r($result);

        // 模型获取器
        // $user = UserModel::get(21);
        // return $user->status;
        // return $user->nothing;
        // 如果定义了获取器，并且想获得原始值，可以使用getDate()方法
        // return $user->getData('status');
        // 直接输出无参数的getData()，得到原始值，而$user输出的是改变后的值
        // dump($user->getData());
        // dump($user);

        // 使用WithAttr在控制器端实现动态获取器
        // $result = UserModel::WithAttr('email', function ($value) {
        //     return strtoupper($value);
        // })->select();
        // return json($result);

        // $result = UserModel::WithAttr('status', function ($value) {
        //     $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        //     return $status[$value];
        // })->select();
        // return json($result);

        // 模型搜索器 通过withSearch()方法静态方法实现模型搜索器的调用
        // $result = UserModel::withSearch(['email', 'create_time'], [
        //     'email' => 'xiao',
        //     'create_time' => ['2014-1-1', '2017-1-1']
        // ])->select();

        // 想在搜索器查询的基础上在增加查询条件，直接使用链式查询即可
        // $result = UserModel::withSearch(['email', 'create_time'], [
        //     'email' => 'xiao',
        //     'create_time' => ['2014-1-1', '2017-1-1']
        // ])->where('gender', '女')->select();

        // 在搜索器添加一个可以排序的功能
        // $result = UserModel::withSearch(['email', 'create_time'], [
        //     'email' => 'xiao',
        //     'create_time' => ['2014-1-1', '2017-1-1'],
        //     'sort' => ['price' => 'desc']
        // ])->select();
        // return json($result);

        // 模型数据集 判断数据集是否为空，我们需要采用isEmpty()方法
        // $result = UserModel::where('id', 111)->select();
        // if ($result->isEmpty()) {
        //     return '没有数据';
        // }

        // 使用模型方法hidden()可以隐藏某个字段，使用visible()只显示某个字段
        // 使用append()可以添加某个获取器的字段，使用withAttr()对字段进行函数处理
        // $result = UserModel::select();
        // $result->hidden(['password'])->append(['nothing'])->withAttr('email', function ($value) {
        //     return strtoupper($value);
        // });
        // return json($result);

        // 使用模型方法filter()对筛选的数据进行过滤
        // $result = UserModel::select()->filter(function ($data) {
        //     return $data['price'] > 100;
        // });
        // return json($result);

        // 也可以使用数据集之后链接where()方法来代替filter()方法
        // $result = UserModel::select()->where('price', '>', '100');
        // return json($result);

        // 数据集甚至还可以使用oder()方法进行排序
        // $result = UserModel::select()->order('price', 'desc');
        // return json($result);

        // 使用diff()和intersect()方法可以计算两个数据集的差集和交集
        // $result1 = UserModel::where('price', '>', '80')->select();
        // $result2 = UserModel::where('price', '<', '100')->select();
        // return json($result1->diff($result2));
        // return json($result1->intersect($result2));
    }

    public function insert()
    {
        // 实例化模型对象
        $user = new UserModel();
        // $user = new \app\index\model\User();

        // 用save()方法写入到数据库中，save()返回布尔值
        $user->username     = '李白';
        $user->password     = '123';
        $user->gender       = '男';
        $user->email        = 'libai@163.com';
        $user->price        = 100;
        $user->details      = '123';
        $user->uid          = 1011;
        $user->create_time  = date('Y-m-d H:i:s');
        $user->save();

        // 通过save()传递数据数组的方式，来新增数据
        // $user ->save([
        //     'username'     => '李白',
        //     'password'     => '123',
        //     'gender'       => '男',
        //     'email'        => 'libai@163.com',
        //     'price'        => 100,
        //     'details'      => '123',
        //     'uid'          => 1011,
        //     'create_time'  => date('Y-m-d H:i:s')
        // ]);
        // 当新增成功后，使用$user->id,可以获得自增ID
        // echo $user->id;

        // print_r($user);

        // 使用save()方法，可以批量新增数据
        // $dataAll = [
        //     [
        //         'username'     => '李白',
        //         'password'     => '123',
        //         'gender'       => '男',
        //         'email'        => 'libai@163.com',
        //         'price'        => 100,
        //         'details'      => '123',
        //         'uid'          => 1011,
        //         'create_time'  => date('Y-m-d H:i:s')
        //     ],
        //     [
        //         'username'     => '李白',
        //         'password'     => '123',
        //         'gender'       => '男',
        //         'email'        => 'libai@163.com',
        //         'price'        => 100,
        //         'details'      => '123',
        //         'uid'          => 1011,
        //         'create_time'  => date('Y-m-d H:i:s')
        //     ]
        // ];
        // $user = new UserModel();
        // print_r($user->saveAll($dataAll));

        // 除了在模型端设置，也可以动态设置只读字段
        // $user->readonly(['username', 'email'])->save();
    }

    public function delete()
    {
        // 使用get()方法，通过主键(id)查询到想要删除的数据
        // $user = UserModel::get(247);
        // 再通过delete()方法，将数据删除，返回布尔值
        // $user->delete();

        // 使用静态方法调用destroy()方法，通过主键(id)删除数据
        // UserModel::destroy(253);

        // 静态方法destroy()方法，也可以批量删除数据
        // UserModel::destroy('250,251,252');
        // UserModel::destroy([250,251,252]);

        // 通过数据库类的查询条件删除
        UserModel::where('id', '>', 248)->delete();

        // 使用闭包的方式进行删除
        UserModel::destroy(function ($query) {
            $query->where('id', '=', 248);
        });
    }

    public function update()
    {
        // 使用get()方法通过主键获取数据，再通过save()方法保存修改
        $user = UserModel::get(76);
        $user->username  = '李黑';
        $user->email     = 'lihe@163.com';
        $user->save();

        // 通过where()方法结合find()方法的查询条件获取数据，进行修改
        $user = UserModel::where('username', '李黑')->find();
        $user->username  = '李白';
        $user->email     = 'libai@163.com';
        $user->save();
        // 强制更新数据，可以使用force()方法
        $user->force()->save();

        // DB::raw()执行SQL函数的方式修改数据
        $user->price  = Db::raw('price+1');

        // 只是单纯的增减数据，可以使用Inc/dec
        $user->pirce  = ['inc', 1];
        $user->save();

        // 直接通过save([],[])两个数组参数方式更新数据
        $user->save([
            'username'  => '李黑',
            'email'     =>  'lihe@163.com'
        ], ['id' => '76']);

        // 通过savaAll()方法,可以批量修改数据，返回被修改的数据集合
        $list = [
            ['id' => 76, 'username' => '李白', 'email' => 'libai@163.com'],
            ['id' => 77, 'username' => '李白', 'email' => 'libai@163.com'],
            ['id' => 78, 'username' => '李白', 'email' => 'libai@163.com']
        ];
        $user->saveAll($list);

        // 使用静态方法结合update()方法更新数据，返回的是影响行数
        UserModel::where('id', 77)->update([
            'username'  => '李黑',
            'email'     => 'lihei@163.com'
        ]);

        // 另外一种静态方法update(),返回的是对象实例
        UserModel::update([
            'id'        => '78',
            'username'  => '李黑',
            'email'     => 'lihei@163.com'
        ]);
    }

    public function select()
    {
        // 使用get()方法，通过主键(id)查询到想要的数据
        // $user = UserModel::get(76);
        // return json($user);

        // 通过where()方法进行条件筛选查询数据
        // $user = UserModel::where('username', '李白')->find();
        // return json($user);
        // 通过模型->符号，可以得到单独的字段数据
        // return $user->username;

        // 如果在模型内部获取数据，请不要用$this->username
        // $user = new UserModel;
        // return $user->getUserName();

        // 通过all()方法，实现IN模式的多数据获取
        // $user = UserModel::all('76,77,78');
        // $user = UserModel::all([76, 77, 128]);
        // return json($user);

        // 使用链式查询得到数据
        // $user = UserModel::where('gender', '男')->order('id', 'asc')->limit(2)->select();
        // return json($user);

        // 获取某个字段或者某个列的值
        // $user = UserModel::where('id', 77)->value('username');
        // $user = UserModel::whereIn('id', [77, 78, 79])->column('username', 'id');
        // return json($user);

        // 模型支持动态查询：getBy*, *带代表字段名
        // $user = UserModel::getByUsername('李白');
        // $user = UserModel::getByEmail('lihei@163.com');
        // return json($user);

        // 模型支持聚合查询
        // $user = UserModel::max('price');
        // return json($user);
    }

    public function typeConversion()
    {
        $user = UserModel::get(21);
        var_dump($user->price);
        var_dump($user->status);
        var_dump($user->create_time);
    }

    // 模型查询范围
    public function queryScope()
    {
        // $result = UserModel::scope('gendermale')->select();
        // $result = UserModel::genderMale()->select();

        // $result = UserModel::emailLike('xiao')->priceGreater(80)->select();

        // 在定义了全局查询后，如果某些不需要全局查询可以使用useGlobalScope取消
        $result = UserModel::useGlobalScope(false)->emailLike('xiao')->priceGreater(80)->select();

        return json($result);
    }

    // 通过模板进行数据输出
    public function view()
    {
        $user = UserModel::get(21);
        // $this->assign('user', $user);
        // return $this->fetch();

        // 使用toArray()方法，将对象按照数组的方式输出
        // print_r($user->toArray());

        // 和之前的数据集一样，它也支持hidden、append、visible等方法
        // print_r($user->hidden(['password,update_time'])->toArray());

        // toArray()方法也支持all()和select()等列表数据
        // print_r(UserModel::select()->toArray());

        // 使用toJson()方法将数据对象进行序列化操作，也支持hidden等方法
        print_r($user->toJson());
    }

    // 数据库写入JSON字段，直接通过数组的方式即可完成
    // public function json()
    // {
    //     // $data = [
    //     //     'username'  => '辉夜',
    //     //     'password'  => '123',
    //     //     'gender'    => '女',
    //     //     'email'     => 'huiye@163.com',
    //     //     'price'     => 90,
    //     //     // 'details' => '123',
    //     //     'details'   => ['content' => 123],
    //     //     'uid'       => 1011,
    //     //     'status'    => 1,
    //     //     'list'      => ['username' => '辉夜', 'gender' => '女', 'email' => 'huiye@163.com']
    //     // ];
    //     // Db::name('user')->json(['details'])->insert($data);

    //     // 在查询上，也可以使用->json(['list,details'])方法来获取数据
    //     // $user = Db::name('user')->json(['list', 'details'])->where('id', 280)->find();
    //     // 如果将json字段里的数据作为查询条件，可以通过如下方式实现
    //     // $user = Db::name('user')->json(['list', 'details'])->where('list->username', '辉夜')->find();
    //     // return json($user);
    //     // 完全修改json数据
    //     // $data['list'] = ['username' => '李白', 'gender' => '男'];
    //     // Db::name('user')->json(['list'])->where('id', 279)->update($data);
    //     // 只修改json数据里的某一个项目
    //     $data['list->username'] = '李黑';
    //     Db::name('user')->json(['list'])->where('id', 279)->update($data);
    // }

    // 使用模型方式去对新增包含json数据的字段
    public function json()
    {
        $user = new UserModel();
        $user->username = '李白';
        $user->password = '123';
        $user->gender = '男';
        $user->email = 'libai@163.com';
        $user->price = 100;
        $user->uid = 1011;
        $user->status = 1;
        $user->details = ['content' => 123];
        $user->list = ['username' => '辉夜', 'gender' => '女 ', 'email' => 'huiye@163.com', 'uid' => 1011];
        $user->save();

        // 也可以通过对象的方式，进行对json字段的写入操作
        $list = new \StdClass();
        $list->username = '辉夜';
        $list->gender = '女';
        $list->email = 'huiye@163.com';
        $list->uid = 1011;
        $user->list = $list;
        $user->save();

        // 通过对象调用方式，直接获取json里面的数据
        // $user = UserModel::get(279);
        // return $user->list->username;

        // 通过json的数据查询，获取一条数据
        // $user = UserModel::where('list->username', '辉夜')->find();
        // return $user->list->email;

        // 更新修改json数据，直接通过对象方式即可
        // $user = UserModel::get(279);
        // $user->list->username = '李白';
    }

    public function softDelete()
    {
        // 数据库软删除
        // Db::name('user')->where('id', 78)
        //     ->useSoftDelete('delete_time', date('Y-m-d H:i:s'))
        //     ->delete();
        // return Db::getLastSql();

        // 模型软删除
        // User::destroy(1);
        // // 真实删除
        // User::destroy(1, true);

        // $user = User::get(1);
        // // 软删除
        // $user->delete();
        // // 真实删除
        // $user->delete(true);

        // 默认情况下，开启了软删除功能的查询，模型会自动屏蔽被软删除的数据
        // $user = UserModel::select();
        // return json($user);

        // 在开启软删除功能的前提下，使用withTrashed()方法取消屏蔽软删除的数据
        // $user = UserModel::WithTrashed()->select();
        // return json($user);

        // 如果只想查询软删除的数据，使用onlyTrashed()方法即可
        // $user = UserModel::onlyTrashed()->select();
        // return json($user);

        // 如果想让某一条软删除的数据恢复到正常数据，可以使用restore()方法
        // $user = UserModel::onlyTrashed()->find();
        // $user->restore();

        // 如果想让一条软删除的数据真正删除，在恢复正常后，使用 delete(true);
        // $user = UserModel::onlyTrashed()->get(78);
        // $user->restore();
        // $user->delete(true);
    }
}
