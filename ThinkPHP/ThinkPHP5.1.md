# ThinkPHP5.1

## 简介

1.TP框架是免费开源的、轻量级、简单快速且敏捷的PHP框架；

2.ThinkPHP5.1要求PHP版本是5.6以上；

3.还需要PHP开启PDO数据库引擎和MBstring字符串扩展。

## 安装

1. 官网不提供软件包下载，采用 Composer 和 git 方式下载和更新； 

2.  windows 安装，Mac 和 Linux 方法参考一下手册；

3. 打开 windows 下的运行：cmd，然后运行如下代码（Mac 和 Linux 控制台）：

   ```
   composer config -g repo.packagist composer https://packagist.phpcomposer.com
   ```

4. 如果上述地址产生阻碍，可以使用国内的： 

   ```
   composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
   ```

5. 现在，先启用服务器环境，测试本地 Web 环境是否正常； 

6. 如果你是首次安装 ThinkPHP5.1，那么先从 cmd 中切换到你要加载的目录；

   ```
    composer create-project topthink/think=5.1.* tp5.1
   ```

7. 通过访问 `http://localhost/tp5.1/public` 测试是否进入首页；

8. 如果要更新你的项目版本，直接进入项目根目录，然后直接如下代码： 

   ```
   composer update topthink/framework
   ```

## 目录

```
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  ├─config          配置目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行定义文件
│  ├─common.php         公共函数文件
│  └─tags.php           应用行为扩展定义文件
│
├─config                应用配置目录
│  ├─module_name        模块配置目录
│  │  ├─database.php    数据库配置
│  │  ├─cache           缓存配置
│  │  └─ ...            
│  │
│  ├─app.php            应用配置
│  ├─cache.php          缓存配置
│  ├─cookie.php         Cookie配置
│  ├─database.php       数据库配置
│  ├─log.php            日志配置
│  ├─session.php        Session配置
│  ├─template.php       模板引擎配置
│  └─trace.php          Trace配置
│
├─route                 路由定义目录
│  ├─route.php          路由定义
│  └─...                更多
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  └─logo.png           框架LOGO文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
```

## URL解析模式

### 1、URL解析

1.ThinkPHP框架很多的操作是通过URL来实现的

```
http://servername/index.php/模块/控制器/操作/参数/值...
```

index.php：是入口文件，在public目录下；

模块：application目录下默认的index目录，就是一个模块；

控制器：index目录下有一个controller控制器目录的Index.php控制器，Index.php控制器的类名必须是class Index，否则会报错；

操作：控制器class Index类里的方法；

2.完整的形式为：`publilc/index.php/index/index/index`

### 2、URL模式

1.如果wamp环境没有开启伪静态，那么ThinkPHP不支持URL重写；

2.Apache没有开启URL重写，只能使用 PATH_INFO模式：`publlic/index.php?s=index/index/index`

3.Apache开启URL重写，打开httpd.conf文件，把mod_rewrite.so前面的#去掉；

4.开启URL重写后，public目录下`.htaccess`文件的URL重写规则生效；

> 如果使用是phpStudy，想要隐藏入口文件index.php，那么`.htaccess`规则:
>

```
<IfModule mod_rewrite.c> 
Options +FollowSymlinks -Multiviews 
RewriteEngine on 
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1] 
</IfModule>
```

## 模块设计

### 1、目录结构

1.ThinkPHP5.1默认是多模块架构，也可以设置为模块操作；

2.所有的命名空间以app作为根命名空间(通过环境变量更改)；

3.标准的应用和模块目录结构如下 ：

```
├─application           应用目录（可设置）
│  ├─common             公共模块目录（可选）
│  ├─module1            模块1目录
│  │  ├─common.php      模块函数文件
│  │  ├─config	      	模块配置目录（可选）
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录（可选）
│  │  ├─view            视图目录（可选）
│  │  └─ ...            更多类库目录
│  │ 
│  ├─module2            模块2目录
│  │  ├─common.php      模块函数文件
│  │  ├─config	      	模块配置目录（可选）
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录（可选）
│  │  ├─view            视图目录（可选）
│  │  └─ ...            更多类库目录
```

4.模块下的类库文件命名空间统一为：app\模块名，例如：app\index\controller\Index

5.多模块设计在访问URL时，必须指定相应的模块名，例如：public/**index**/index/index;

6.如果只有index模块时，可以绑定这个模块，从而缩略写法；

打开publicx.php文件，追加一个方法：

```php
Container::get('app')->bind('index')->run()->send(); 
```

此时，URL调用就变成了：public/index/index，访问的是index模块

> http://serverName/index.php/控制器/操作/[参数名/参数值...]

7.如果你的应用特别简单，只有一个模块，一个控制器，那改写追加的方法：

```php
Container::get('app')->bind('index/index')->run()->send(); 
```

此时，URL调用就变成了：public/index，其他控制器则无法访问；

> http://serverName/index.php/操作/[参数名/参数值...]

### 2、空模块

1.可以通过环境变量这种空目录，将不存在的目录统一指向指定目录；

2.在config目录下的app.php修改：

```
     // 默认的空模块名
     'empty_module'           => 'home',
```

如果访问一个不存在的模块，系统会指向home模块进行访问；

3.空模块只有在开启了多模块访问，并且没有绑定模块的情况下生效。

### 3、单一模块

1.如果你的应用一个模块，那么可以直接设置成单模块；

在config目录下的app.php修改：

         // 是否支持多模块
         'app_multi_module'       => false,
调整应用目录的结构为如下： 

```
├─application        应用目录（可设置）
│  ├─controller      控制器目录
│  ├─model           模型目录
│  ├─view            视图目录
│  ├─ ...            更多类库目录
│  └─common.php      函数文件
```

4.URL访问地址变成:

> http://serverName/index.php（或者其它应用入口）/控制器/操作/[参数名/参数值...]

此时URL地址为public/index/index，即：控制器/操作；

单一模块的命名空间也变更为app/controller；

### 4、环境变量

5.1版本取消了所有的系统常量，原来的系统路径变量改为使用`Env`类获取（需要引入`think\facade\Env`）：

例如：

```php
// 获取应用目录（不区分大小写）
echo Env::get('app_path');
// 或者
echo Env::get('APP_PATH');
```

支持获取的系统路径变量包括：

| 系统路径     | Env参数名称  |
| ------------ | ------------ |
| 应用根目录   | root_path    |
| 应用目录     | app_path     |
| 框架目录     | think_path   |
| 配置目录     | config_path  |
| 扩展目录     | extend_path  |
| composer目录 | vendor_path  |
| 运行缓存目录 | runtime_path |
| 路由目录     | route_path   |
| 当前模块目录 | module_path  |

## 控制器的定义

### 1、控制器定义

1.控制器，即controller，控制器文件存放在controller目录下；

2.类名和文件名大小写保持一致，并采用驼峰式（首字母大写）：

```php
<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'index';
    }
}
```

为了更方便使用，控制器类建议继承系统的控制器基类think\Controller；

控制器类文件的实际位置是:

```
application\index\controller\Index.php
```

访问URL地址是（假设没有定于路由的情况下）

```
http://localhost/public/index.php/index
```

3.如果创建的类名是双字母组合，比如：class HelloWorld;

控制器类文件的实际位置是:

```
application\index\controller\HelloWorld.php
```

访问URL地址是（假设没有定于路由的情况下）

```
http://localhost/public/index.php/index/hello_world
```

如果你想原样的方式访问URL，则需要关闭配置文件中的自动转换

```
     // 是否自动转换URL中的控制器和操作名
     'url_convert'            => false,
```

此时URL访问地址可以为：

```
http://localhost/public/index.php？s=index/hello_world
```

### 2.渲染输出

1.ThinkPHP在方法内采用return返回的方式直接就输出了;

2.使用json输出，直接采用json函数；

```php
    $data = array('a'=>1,'b'=>2,'c'=>3);
    return json($data);
```
可以更改配置文件config/app.php默认输出类型为：json

        // 默认输出类型
        'default_return_type'    => 'json',
一般情况下，正常页面都是html输出。

3.使用view()函数输出模板，开启错误提示，可知道创建模板的默认路径

```php
return view();
```

4，控制器基类Controller中的initialize()方法会在调用控制器方法之前执行；

```php
<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{

    protected function initialize()
    {
        echo 'init<br/>';
    }
    
    public function hello()
    {
        return 'hello';
    }
    
    public function data()
    {
        return 'data';
    }
}
```

initialize()方法不需要任何返回值，输出用PHP方式，return无效；

## 控制器操作

### 1、前置操作

可以为某个或某些操作指定前置执行的操作方法，设置beforeArtionList属性可以指定某个方法为其他方法的前置操作。

```php
<?php
namespace app\index\controller;

use think\Controller;

class Before extends Controller
{
    protected $beforeActionList = [
        'first',
        // 表示hello方法不使用前置方法second
        'second'=>['except'=>'hello'],
        // 表示hello,data方法不使用前置方法three
        'three'=>['only'=>'hello,data']
    ];
    protected function first()
    {
        echo 'first<br/>';
    }
    protected function second()
    {
        echo 'second<br/>';
    }
    protected function three()
    {
        echo 'three<br/>';
    }
    public function hello()
    {
        return 'index';
    }
    public function data()
    {
        return 'one';
    }
}
```

### 2、跳转和重定向

系统的\think\Controller类内置了两个跳转方法success和error，用于跳转提示。

```php
    protected $flag = true;
    public function index()
    {
        if ($this->flag) {
            // 如果不指定URL,则返回$_SERVER['HTTP_REFERER]
            $this->success('成功','../');
        } else {
            // 自动返回上一页
            $this->error('失败');
        }
        return index;
    }
```

成功或失败欧一个固定的页面模板：'thinkphp/tpl/dispatch_jump.tpl'；

在app.php配置文件中，可以更改个性化的跳转页面；

```
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
```

也可以使用项目内部的模板文件

```
    //默认错误跳转对应的模板文件
    'dispatch_error_tmpl' => 'public/error',
    //默认成功跳转对应的模板文件
    'dispatch_success_tmpl' => 'public/success',
```

模板文件可以使用模板标签，并且可以使用下面的模板变量：

| 变量  | 含义                  |
| ----- | --------------------- |
| $data | 要返回的数据          |
| $msg  | 页面提示信息          |
| $code | 返回的code            |
| $wait | 跳转等待时间 单位为秒 |
| $url  | 跳转页面地址          |

### 3、空方法和空控制器

1.当访问一个不存在的方法时，系统会报错，可以使用_mepty()来拦截；

```php
    // 访问的方法不存在时,可以使用_empty()拦截
    public function _empty($name)
    {
        return '不存在该方法'.$name;
    }
```

2.当访问一个不存在控制器时，系统也会报错，可以使用Error来拦截；

```php
<?php
namespace  app\index\controller;

use think\Request;

class Error{
    public function index(Request $request)
    {
        return '控制器不存在'.$request->controller();
    }
}
```

系统默认为Error类，若要自定义，在app.php配置文件中修改：

```
    // 默认的空控制器名
    'empty_controller'       => 'Error',
```

## 数据库与模型

### 1、连接数据库

1. ThinkPHP 采用内置抽象层将不同的数据库操作进行封装处理；
2. 数据抽象层基于 PDO 模式，无须针对不同的数据库编写相应的代码； 
3. 使用数据库的第一步，就是连接你的数据库； 
4. 在根目录的 config 下的 database.php 可以设置数据库连接信息； 

```
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'tp5.1',
    // 用户名
    'username'        => 'root',
    // 密码
    'password'        => '',
    // 端口
    'hostport'        => '',
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => 'tp_',
```

5.配置完数据库，使用如下代码在控制器段输数mysql里的数据：

```php
use think\Db;

    public function getNotModelData()
    {
        // $data = Db::table('tp_user')->select();
        // name()方法使用配置的表前缀
        $data = DB::name('user')->select();
        return json($data);
    }
```

### 2、模型定义

1.Model即模型，用于处理和配置数据库的相关信息。

2.在项目应用根目录下的index模块创建model文件夹，并且创建User.php:

```php
<?php
namespace app\index\model;
use think\Model;

class User extends Model
{

}
```

3.当创建了User模型，控制端可以直接用User模型对象调用表名；

```php
    use app\index\model\User;
    
    public function getModelData()
    {
        // 使用User模型对象调用表名
        $data = User::select();
        return json($data);
    }
```

此时需要引入User模型：use app\index\model\User;

4.很多时候，需要调试 SQL 是否正确，建议打开 Trace，可以查看原生 SQL

```
    // 应用Trace
    'app_trace'              => true,
```

## 查询数据

### 1、基本查询

```php
        // 使用find()方法查询一条数据
        $data = Db::table('tp_user')->find();

        // 使用Db::getLastSql()方法查询最近一条SQL的原生语句
        $data = Db::getLastSql();

        // 使用where()方法查询指定数据
        $data = Db::table('tp_user')->where('id',27)->find();

        // 使用findOrFail()方法查询一条数据，没有数据时抛出一个异常
        $data = Db::table('tp_user')->where('id',1)->findOrFail();

        // 使用findOrEmpty()方法查询一条数据，没有数据时返回一个空数组
        $data = Db::table('tp_user')->where('id',1)->findOrEmpty();

        // 使用select()方法查询多列数据
        $data = Db::table('tp_user')->select();

        // 多列数据查询到没有数据时，返回空数组，使用selectOrFail抛出异常
        $data = Db::table('tp_user')->where('id',1)->selectOrFail();

        // 如果在数据库配置文件中设置了前缀，那么可以使用name()方法忽略前缀
        $data = Db::name('user')->selectOrFail();
```

### 2、更多查询

```php
        // TinkPHP提供助手函数db查询数据
        $data = \db('user')->select();

        // 通过valuse()方法可以查询指定字段的值（单个），没有数据返回null
        $data = Db::name('user')->where('id',27)->value('username');

        // 通过column()方法可以查询指定字段的值（多个），没有数据返回null
        $data = Db::name('user')->column('username');

        // 指定id作为列值的索引
        $data = Db::name('user')->column('username','id');
```

## 链式查询

### 1、查询规则 

1.通过指向符号“->”多次连续调用方法称为：链式查询； 

2.当 Db::name('user')时，返回数据库对象，即可连缀数据库对应的方法； 

而每次执行一个数据库查询方法时，比如 where()，还将返回数据库对象；

只要还是数据库对象，那么就可以一直使用指向符号进行链式查询；

3.如果想要最后得到结果，可以使用 find()、select()等方法结束查询，find()和 select()是结果查询方法（放在最后），并不是链式查询方法；

```php
Db::name('user')->where('id', 27)->order('id', 'desc')->find()
```

### 2、更多查询

1.如果多次使用数据库查询，那么每次静态创建都会生成一个实例，造成浪费；

我们可以把对象实例保存下来，再进行反复调用即可； 

```php
$user = Db::name('user'); 
$data = $user->select();
```

2.当同一个对象实例第二次查询后，会保留第一次查询的值；

```php
        $data1 = $user->where('id',27)->order('id','desc')->find();
        $data2 = $user->find();
        return Db::getLastSql();       
```

SELECT * FROM `tp_user` WHERE `id` = 27 ORDER BY `id` DESC LIMIT 1 

3.使用 removeOption()方法，可以清理掉上一次查询保留

```php
       $data2 = $user ->removeOption('where')->removeOption('order')->find();
       return Db::getLastSql();
```

   SELECT * FROM `tp_user` LIMIT 1 

## 增删改操作

### 1、新增数据 

1.使用 insert()方法可以向数据表添加一条数据

```php
        $data  = [
            'username' => '辉夜',
            'password' => '123',
            'gender' => '女',
            'email' => 'huiye@163.com',
            'price' => 90, 'details' => '123',
            'create_time' => date('Y-m-d H:i:s')
        ];
        $flag = Db::name('user')->insert($data);
        return $flag;
```

如果新增成功，insert()方法会返回一个 1 值

2.使用data()方法设置添加的数据数组

```php
Db::name('user')->data($data)->insert();
```

如果你添加一个不存在的数据，会抛出一个异常 Exception

3.如果采用的是MySQL数据库，支持REPLACE写入 

```php
Db::name('user')->insert($data,true);
```

4.使用insertGetId()方法，可以在新增成功后返回当前数据ID 

```php
Db::name('user')->insertGetId($data);
```

5.使用 insertAll()方法，可以批量新增数据，但要保持数组结构一致；

```php
        $data  = [
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
        Db::name('user')->insertAll($data);
```

批量新增也支持data()方法 

```php
Db::name('user')->data($data)->insertAll();
```

批量新增也支持 replace 写入

```php
Db::name('user')->insertAll($data,true);
```

### 2、修改数据 

1.使用 update()方法来修改数据，修改成功返回影响行数，没有修改返回 0

```php
        $data = [
            'username'  =>  '李白'
        ];        
        $data = Db::name('user')->where('id',233)->update($data);
        return $data;
```

2.使用data()啊方法传入要修改的数组 

```php
Db::name('user')->where('id',233)->data($data)->update(['password'=>'456']);
```

3.如果修改数组中包含主键，那么可以直接修改 

```php
        $data = [
            'username'  =>  '李白',
            'id'        =>  233
        ];
        Db::name('user')->data($data)->update(['password'=>'4567']);
```

4.使用inc()方法可以对字段增值，dec()方法可以对字段进行减值 

```php
        Db::name('user')->inc('price')->update($data);
        Db::name('user')->dec('price',3)->update($data);
```

5.exp()方法可以在字段中使用MySQL函数 

```php
Db::name('user')->exp('email','UPPER(email)')->update($data);
```

增值和减值如果不指定第二个参数，则步长为 1

6.使用 exp()方法可以在字段中使用 mysql 函数

```php
Db::name('user')->exp('email','UPPER(email)')->update($data);
```

7.使用ram()方法修改更新 

```php
        $data = [
            'username'  =>  '李白',
            'email'     =>  Db::raw('UPPER(email)'),
            'price'     =>  Db::raw('price - 3'),
            'id'        =>  233
        ];
        Db::name('user')->update($data);
```

8.使用setField()方法可以更新一个字段值 

```php
Db::name('user')->where('id',233)->setField('username','辉夜');
```



### 3、删除数据 

1.极简删除可以根据主键直接删除，删除成功返回影响行数，否则 0； 

```php
Db::name('user')->delete(225);
```

2.根据主键，还可以删除多条记录；

```php
Db::name('user')->delete([234,235,236]);
```

3.通过where()方法删除 

```php
Db::name('user')->where('id',237)->delete();
```

4.通过 true 参数删除数据表所有数据

```php
Db::name('user')->delete(true);
```

## 查询表达式

### 1、比较查询

1.在查询数据进行筛选时，采用where()方法

```php
        // where方法查询
        $result = Db::name('user')->where('id',20)->find();
        $result = Db::name('user')->where('id','=',20)->find();
        return json($result);
```

where(字段名，查询条件)，where(字段名，表达式，查询条件)

其中，表达式不区分大小写，包括比较、区间和时间、三种类型的查询

2.使用<>、>、<、<=、<=可以筛选出各种符合比较值的数据列表

```php
$result = Db::name('user')->where('id','<>',20)->select();
```

### 2、区间查询

1.使用like表达式进行模糊查询

```php
$result = Db::name('user')->where('email','like','xiao%')->select();
```

2.like表达式还可以支持数组传递进行模糊查询

```php
$result = Db::name('user')->where('email','like',['xiao%','wu%'],'or')->select();
```

SELECT * FROM `tp_user` WHERE (`email` LIKE 'xiao%' OR `email` LIKE 'wu%')

3.like表达式有两个快捷方式whereLike()和whereNotLike()

```php
        $result = Db::name('user')->whereLike('email','xiao%')->select();
        $result = Db::name('user')->whereNotLike('email','xiao%')->select();
```

4.between表达式有两个快捷方式whereBetween()和whereNotBetween()

```php
        $result = Db::name('user')->where('id','between','19,25')->select();
        $result = Db::name('user')->where('id','between',[19,25])->select();
        $result = Db::name('user')->whereBetween('id',[19,25])->select();
        $result = Db::name('user')->whereNotBetween('id',[19,25])->select();
```

5.in表达式有两个快捷方式whereIn()和whereNotIn()

```php
        $result = Db::name('user')->where('id','in','19,21,29')->select();
        $result = Db::name('user')->whereIn('id','19,21,29')->select();
        $result = Db::name('user')->whereNotIn('id','19,21,29')->select();
```

6.null表达式有两个快捷方式whereNull()和whereNotNull()

```php
        $result = Db::name('user')->where('uid','null')->select();
        $result = Db::name('user')->where('uid','not null')->select();
        $result = Db::name('user')->whereNull('uid')->select();
        $result = Db::name('user')->whereNotNull('uid')->select();
```

### 3、其他查询

1.使用exp可以自定义字段后的SQL语句

```php
        $result = Db::name('user')->where('id','exp','IN (19,21,25)')->select();
        $result = Db::name('user')->whereExp('id','IN (19,21,25)')->select();
```

## 时间查询

### 1、传统方式

1.使用>、<、>=、<=来筛选匹配时间的数据

```php
$result = Db::name('user')->where('create_time','> time','2018-1-1')->select();
```

2.使用between关键字开设置时间的区间

```php
$result = Db::name('user')->where('create_time','between time',['2018-1-1','2019-1-1'])->select();
$result = Db::name('user')->where('create_time','not between time',['2018-1-1','2019-1-1'])->select();
```

### 2、快捷查询

1.时间查询的快捷方式为whereTime(),直接使用>、<、>=、<=

```php
$result = Db::name('user')->whereTime('create_time','>','2018-1-1')->select();
```

2.快捷方式也可以使用 between 和 not between

```php
$result = Db::name('user')->whereBetween('create_time',['2018-1-1','2019-1-1'])->select();
```

3.还有一种快捷方式为：whereBetweenTime()，如果只有一个参数就表示一天

```php
$result = Db::name('user')->whereBetweenTime('create_time','2018-1-1','2019-1-1')->select();
```

4.默认大于>,可以省略

```php
Db::name('user')->whereTime('create_time', '2018-1-1')->select();
```

### 3、固定查询

| 关键字     | 说明 |
| ---------- | ---- |
| today 或 d | 今天 |
| yesterday  | 昨天 |
| week 或 w  | 本周 |
| last week  | 上周 |
| month 或 m | 本月 |
| last month | 上月 |
| year 或 y  | 今年 |
| last year  | 去年 |

```php
        $result = Db::name('user')->whereTime('create_time','d')->select();
        $result = Db::name('user')->whereTime('create_time','y')->select();
```



### 4、其他查询

1.查询指定时间的数据，比如两小时内

```php
$result = Db::name('user')->whereTime('create_time','-2 hour')->select();
```

2.查询两个时间字段时间有效的数据，比如会员开始到结束的期间

```php
$result = Db::name('user')->whereBetweenTimeField('create_time','update_time')->select();
```

## 聚合、原生和子查询

### 1、聚合查询

1.使用count()方法，可以求出所查询数据的数量

```php
$result = Db::name('user')->count();
```

2.count()可设置指定id，比如有空值(Null)的uid，不会计算数量

```php
$result = Db::name('user')->count('uid');
```

3.使用max()方法，求出所查询数据字段的最大值

```php
$result = Db::name('user')->max('price');
```

4.如果max()方法，求出的值不是数值，则通过第二参数强制转换

```php
$result = Db::name('user')->max('price',false);
```

5.使用min()方法，求出所查询数据字段的最小值，也可以强制转换

```php
$result = Db::name('user')->min('price');
```

6.使用avg()方法，求出所查询数据字段的平均值

```php
$result = Db::name('user')->avg('price');
```

7.使用sum()方法，求出所查询数据字段的总和

```php
$result = Db::name('user')->sum('price');
```

### 2、子查询

1.使用fetchSql()方法，可以设置不执行SQL，而返回SQL语句，默认为true

```php
$result = Db::name('user')->fetchSql(true)->select();
```

2.使用buidSql()方法，也是返回SQL语句，但不需要在执行select()，且有括号

```php
$result = Db::name('user')->buildSql(true);
```

3.子查询

```php
        $subQuery = Db::name('two')->field('uid')->where('gender','男')->buildSql(true);
        $result = Db::name('one')->where('id','exp','IN '.$subQuery)->select();
```

4.使用闭包方式执行子查询

```php
        // 使用闭包方式执行子查询
        $result = Db::name('one')->where('id','in',function($query){
            $query->name('two')->where('gender','男')->field('uid');
        })->select();
```

### 3、原生查询

1.使用query()方法，进行原生SQL查询，适用于读取操作，SQL错误返回false

```php
$result = Db::query('select * from tp_user');
```

2.使用execute()方法，进行原生SQL更新写入等，SQL错误返回false

```php
Db::execute('update tp_user set username="孙悟空" where id=29'
```

## 链式查询

### 1、where

1.表达式查询，就是 where()方法的基础查询方式

```php
    public function index(){
        // 表达式查询，where()方法的基础查询方式
        $result = Db::name('user')->where('id','>',70)->select();

        // return Db::getLastSql();
        return json($result);
    }
```

2.关联数组查询，通过数组键值对匹配的查询方式

```php
        $result = Db::name('user')->where([
            'gender'    =>  '男',
            'price'     =>  100
            // 'price'     =>  [60,70,80]
        ])->select();
```

3.索引数组查询，通过数组里的数组拼装方式来查询

```php
        $result = Db::name('user')->where([
            ['gender','=','男'],
            ['price','=','100']
        ])->select();
```

4.将复杂数组组装后，通过变量传递，将增加可读性

```php
        $map[] = ['gender','=','男'];
        $map[] = ['price','in',[60,70,80]];
        $result = Db::name('user')->where($map)->select();
```

5.字符串形式传递

```php
$result = Db::name('user')->where('gender="男" AND price IN (60,70,80)')->select();
```

### 2、field

1.使用field()方法，可以指定要查询的字段

```php
$result = Db::name('user')->field('id,username,email')->select();
$result = Db::name('user')->field(['id','username','email'])->select();
```

2.使用field()方法，给指定的字段设置别名

```php
$result = Db::name('user')->field('id,username as name')->select();
$result = Db::name('user')->field(['id','username'=>'name'])->select();
```

3.在field()方法里，可以直接给字段设置MySQL函数

```php
$result = Db::name('user')->field('id,SUM(price)')->select();
```

4.对于更加复杂的MySQL函数，必须使用字段数组形式

```php
$result = Db::name('user')->field(['id','LEFT(email,5)'=>'leftemail'])->select();
```

5.使用field(true)的布尔参数，可以显式的查询获取所有字段，而不是*

```php
$result = Db::name('user')->field(true)->select();
```

SELECT `id`,`username`,`password`,`gender`,`email`,`price`,`details`,`uid`,`status`,`list`,`delete_time`,`create_time`,`update_time` FROM `tp_user`

6.使用field()方法中字段排除，可以屏蔽掉想要不显示的字段

```php
$result = Db::name('user')->field('details,email',true)->select();
$result = Db::name('user')->field(['details','email'],true)->select();
```

SELECT `id`,`username`,`password`,`gender`,`price`,`uid`,`status`,`list`,`delete_time`,`create_time`,`update_time` FROM `tp_user`

7.使用field()方法在新增时，验证字段的合法性

```php
        $data  = [
            'username' => '辉夜',
            'password' => '123',
            'gender' => '女',
            'email' => 'huiye@163.com',
            'price' => 90, 'details' => '123',
            'create_time' => date('Y-m-d H:i:s')
        ];

        $insert = Db::name('user')->field('username,password,email,details')->insert($data);
        return $insert;
```

### 3、alias

使用alias()方法，给数据库起一个别名

```php
$result = Db::name('user')->alias('a')->select();
```

### 4、limit

1.使用limit()方法，限制获取输出数据的个数

```php
$result = Db::name('user')->limit(5)->select();
```

2.分页模式，即传递两个参数，比如第3条开始显示5条limt(2,5)

```php
$result = Db::name('user')->limit(2,5)->select();
```

3.实现分页，需要严格计算每页显示的条数，然后从第几条开始

```php
        // 实现分页，需要严格计算每页显示的条数，然后从第几条开始
        // 第一页
        $result = Db::name('user')->limit(0,5)->select();
        // 第二页 
        $result = Db::name('user')->limit(5,5)->select();
```

### 5、page

1.page()分页方法，优化了limit()方法，无需计算分页条数

```php
        // page()分页方法，优化了limit()方法，无需计算分页条数
        // 第一页
        $result = Db::name('user')->page(1,5)->select();
        // 第二页
        $result = Db::name('user')->page(2,5)->select();
```

### 6、order

1.使用order()方法，可以指定排序方式，没有指定第二参数，默认asc

```php
$result = Db::name('user')->order('id','desc')->select();
```

2.支持数组方式，对多个字段进行排序

```php
$result = Db::name('user')->order(['id'=>'desc','price'=>'asc'])->select();
```

### 7、group

1.使用group()方法，给性别不同的人进行price字段的总和统计

```php
$result = Db::name('user')->field('gender,SUM(price)')->group('gender')->select();
```

2.多字段分组统计

```php
$result = Db::name('user')->field('gender,SUM(price)')->group('gender,password')->select();
```

### 8、having

使用gruop()分组后，再使用having()进行筛选

```php
        $result = Db::name('user')
                ->field('gender,SUM(price)')
                ->group('gender')
                ->having('SUM(price)>600')
                ->select();
```

## 模型定义

### 1、定义模型

1.定义一个和数据库表名相匹配的模型

```php
<?php
namespace app\index\model;
use think\Model;

class User extends Model
{
    
}
```

2.模型会自动对应数据表，并且有一套自己的命名规则

3.模型类需要去除表前缀(tp_)，采用驼峰式命名，并且首字母大写

```
tp_user(表名)				=>		User
tp_user_type(表名)		=>		UserType
```

4.如果担心设置的模型类名和PHP关键字冲突，可以开启应用类后缀

在app.php配置文件中开启

```
    // 应用类库后缀
    'class_suffix'           => true,
```

设置完毕后，所有的了类名和模型类名需要加上Controller和Model

```
class UserController
class UserModel
```

### 2、设置模型

1.默认主键为id，你可以设置其他主键,比如uid;

```php
<?php
namespace app\index\model;
use think\Model;

class User extends Model
{
    // 设置uid为主键
    protected $pk = 'uid';
}
```

```php
<?php
namespace app\index\controller;
use \app\index\model\User as UserModel;

class User
{
    public function index()
    {
        // 删除以uid为主键的数据
        UserModel::destroy('2');
    }
}
```

2.从控制器端调用模型操作，如果和控制器类名重复，可以设置别名

```php
use \app\index\model\User as UserModel;
```

3.在模型定义中，可以设置其他的数据表

```php
protected $table = 'tp_one';
```

4.模型和控制器一样，也有初始化，必须设置static静态方法

```php
    // 模型初始化，必须设置static静态方法
    protected static function init()
    {
        // 第一次实例化的时候执行init
        echo '初始化User模型';
    }
```

### 3、模型操作

1.模型操作数据和数据库一样，只不过不需要指定表

```php
UserModel::select();
```

2.数据库操作返回的列表是一个二维数组，而模型操作返回的是一个结果集

[[]]	和	[{}]

## 模型添加与删除

### 1、数据添加

1.使用实例化的方式添加一条数据，首先实例化方式如下，两种均可

```php
        // 实例化模型对象
        $user = new UserModel();
        $user = new \app\index\model\User();
```

2.设置要新增的数据，然后用save()方法写入到数据库中，save()返回布尔值

```php
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
```

3.也可以通过save()传递数据数组的方式，来新增数据

```php
        // 实例化模型对象
        $user = new UserModel();
        // $user = new \app\index\model\User();

        // 通过save()传递数据数组的方式，来新增数据
        $user ->save([
            'username'     => '李白',
            'password'     => '123',
            'gender'       => '男',
            'email'        => 'libai@163.com',
            'price'        => 100,
            'details'      => '123',
            'uid'          => 1011,
            'create_time'  => date('Y-m-d H:i:s')
        ]);
```

4.模型新增也提供了replace()方法来实现REPLACE into新增

```php
$user->replace()->save();
```

5.当新增成功后，使用$user->id,可以获得自增ID(主键需要是id)

```php
echo $user->id;
```

6.使用save()方法，可以批量新增数据，返回批量新增的数组

```php
        $dataAll = [
            [
                'username'     => '李白',
                'password'     => '123',
                'gender'       => '男',
                'email'        => 'libai@163.com',
                'price'        => 100,
                'details'      => '123',
                'uid'          => 1011,
                'create_time'  => date('Y-m-d H:i:s')
            ],
            [
                'username'     => '李白',
                'password'     => '123',
                'gender'       => '男',
                'email'        => 'libai@163.com',
                'price'        => 100,
                'details'      => '123',
                'uid'          => 1011,
                'create_time'  => date('Y-m-d H:i:s')
            ]
        ];
        $user = new UserModel();
        print_r($user->saveAll($dataAll));
```

### 2、数据删除

1.使用get()方法，通过主键(id)查询到想要删除的数据

```php
$user = UserModel::get(247);
```

2.然后再通过delete()方法，将数据删除，返回布尔值

```php
$user->delete();
```

3,也可以使用静态方法调用destroy()方法，通过主键(id)删除数据

```php
UserModel::destroy(253);
```

4.静态方法destroy()方法，也可以批量删除数据

```php
        UserModel::destroy('250,251,252');
        UserModel::destroy([250,251,252]);
```

5.通过数据库类的查询条件删除

```php
UserModel::where('id','>',248)->delete();
```

6.使用闭包的方式进行删除

```php
        UserModel::destroy(function($query){
           $query->where('id','=',248);
        });
```

## 模型修改和查询

### 1、数据修改

1.使用get()方法通过主键获取数据，再通过save()方法保存修改，返回布尔值

```php
    public function update()
    {
        $user = UserModel::get(76);
        $user -> username  = '李黑';
        $user -> email     = 'lihe@163.com';
        $user -> save();
    }
```

2.通过where()方法结合find()方法的查询条件获取数据，进行修改

```php
        $user = UserModel::where('username','李黑')->find();
        $user -> username  = '李白';
        $user -> email     = 'libai@163.com';
        $user -> save();
```

3.save()方法只会更新变化的数据，如果提交的数据没有变化，则不更新；

但如果你想强制更新数据，可以使用force()方法

```php
$user -> force()->save();
```

4.DB::raw()执行SQL函数的方式，更新数据

```php
$user -> price  = Db::raw('price+1');
```

5.如果只是单纯的增减数据，可以使用Inc/dec

```php
$user -> pirce  = ['inc',1];
```

6.直接通过save([],[])两个数组参数方式更新数据

```php
        $user->save([
            'username'  => '李黑',
            'email'     =>  'lihe@163.com'
        ], ['id' => '76']);
```

7.通过savaAll()方法,可以批量修改数据，返回被修改的数据集合

```php
        $list = [
            ['id' => 76, 'username' => '李白', 'email' => 'libai@163.com'],
            ['id' => 77, 'username' => '李白', 'email' => 'libai@163.com'],
            ['id' => 78, 'username' => '李白', 'email' => 'libai@163.com']
        ];
        $user->saveAll($list);
```

批量更新savaAll()方法只能通过主键id进行更新

8.使用静态方法结合update()方法更新数据，返回的是影响行数

```php
        UserModel::where('id', 77)->update([
            'username'  => '李黑',
            'email'     => 'lihei@163.com'
        ]);
```

另外一种静态方法update()，返回的是对象实例

```php
        UserModel::update([
            'id'        => '78',
            'username'  => '李黑',
            'email'     => 'lihei@163.com'
        ]);
```

模型的新增和修改都是save()进行执行的，它采用了自动识别体系来完成

实例化模型后调用save()方法表示新增，查询数据后调用save()表示修改

如果在save()传入更新数据条件后也表示修改

如果编写的代码比价复杂的化，可以使用isUpate()方法显示操作;

```php
// 显示更新
$user->isUpdate(true)->save();
// 显示新增
$user->isUpdate(false)->save();
```

### 2、数据查询

1.使用get()方法，通过主键(id)查询到想要的数据

```php
        $user = UserModel::get(76);
        return json($user);
```

2.也可以通过where()方法进行条件筛选查询数据

```php
        $user = UserModel::where('username', '李白')->find();
        return json($user);
```

不管是get()方法还是find()方法，如果数据不存在则返回null

和数据库查询一样，模型也有getOrFaill()方法，数据不存在抛出异常

还有findOrEmpty()方法，数据不存在返回空模型

通过模型->符号，可以得到单独的字段数据

```
return $user->username;
```

3.如果在模型内部获取数据，请不要用$this->username,而用如下方法:

```php
    // 如果在模型内部获取数据，请不要用$this->username
    public function getUserName()
    {
        return self::where('username', '李白')->find()->getAttr('username');
    }
```

```php
        $user = new UserModel;
        return $user->getUserName();
```

4.通过all()方法，实现IN模式的多数据获取

```php
        $user = UserModel::all('76,77,78');
        $user = UserModel::all([76, 77, 128]);
```

5.使用链式查询得到数据

```php
$user = UserModel::where('gender', '男')->order('id', 'asc')->limit(2)->select();
```

6.获取某个字段或者某个列的值

```php
        $user = UserModel::where('id', 77)->value('username');
        $user = UserModel::whereIn('id', [77, 78, 79])->column('username', 'id');
```

7.模型支持动态查询：getBy*, *带代表字段名

```php
        $user = UserModel::getByUsername('李白');
        $user = UserModel::getByEmail('lihei@163.com');
```

8.模型支持聚合查询

```php
$user = UserModel::max('price');
```

## 模型获取器和修改器

### 1、模型获取器

1.获取器的作用是对模型实例的数据做出自动处理

一个获取器对应模型的一个特殊方法，该方法为public，方法的命名规范为：getFieldAttr()

举个例子，数据库表示状态status字段采用的是数值，而在页面上，需要输出status字段希望是中文，就可以使用获取器

2.在User模型端，创建一个对外的方法

```php
    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }
```

然后在控制器端，直接输出数据库字段的值，即可得到获取器转换的对应值

```php
        $user = UserModel::get(21);
        return $user->status;
```

3.除了getFieldAttr中Field可以是字段值，也可以是自定义的虚拟字段

```php
    public function getNothingAttr($value, $data)
    {
        $getStatus = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $getStatus[$data['status']];
    }
```

然后在控制器端，直接输出数据库字段的值，即可得到获取器转换的对应值

```php
        $user = UserModel::get(21);
        return $user->nothing;
```

Nothing这个字段不存在，而此时参数$value只是为了占位，并未使用，第二个参数$data得到的是筛选到的数据，然后得到最终值

4.如果定义了获取器，并且想获得原始值，可以使用getData()方法

```php
return $user->getData('status');
```

直接输出无参数的getData()，得到原始值，而$user输出的是改变后的值

```php
        dump($user->getData());
        dump($user);
```

5.使用WithAttr在控制器端实现动态获取器

```php
        $result = UserModel::WithAttr('email', function ($value) {
            return strtoupper($value);
        })->select();
        return json($result);
```

```php
        $result = UserModel::WithAttr('status', function ($value) {
            $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
            return $status[$value];
        })->select();
        return json($result);
```

同时定义了模型获取器和动态获取器，那么模型修改器优先级更高

### 2、模型修改器

1.模型修改器的作用就是对模型设置对象的值进行处理

比如，我们要新增数据的时候，对数据进行格式化、过滤、转换等处理

模型修改器的命名规则为：setFieldAttr

2.设置一个新增，规定邮箱的英文都必须大写

```php
    public function setEmailAttr($value)
    {
        return strtoupper($value);
    }
```

除了新增会调用修改器，修改更新也会触发修改器

模型修改器只对模型方法有效，调用数据库的方法是无效的，比如->insert()

## 模型搜索器个数据集

### 1、模型搜索器

1.搜索器是用于封装字段(或搜素标识)的查询表达式

一个搜素器对应模型的一个特殊方法，该方法为public，方法名命名规范为searchFieldNameAttr()

例如封装一个邮箱字段查询，然后封装一个时间限定查询

在User模型端，创建两个对外的方法

```php
    public function searchEmailAttr($query, $value)
    {
        $query->where('email', 'like', $value . '%');
    }
    public function searchCreateTimeAttr($query, $value)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }
```

然后在控制器端 通过withSearch()方法静态方法实现模型搜索器的调用

```php
        $result = UserModel::withSearch(['email', 'create_time'], [
            'email' => 'xiao',
            'create_time' => ['2014-1-1', '2017-1-1']
        ])->select();
```

withSearch()中第一个数组参数，限定搜索器的字段，第二个则是表达式值

2.如果想在搜索器查询的基础上在增加查询条件，直接使用链式查询即可

```php
        $result = UserModel::withSearch(['email', 'create_time'], [
            'email' => 'xiao',
            'create_time' => ['2014-1-1', '2017-1-1']
        ])->where('gender', '女')->select();
```

3.如果想在搜索器添加一个可以排序的功能，具体如下

```php
    public function searchEmailAttr($query, $value, $data)
    {
        $query->where('email', 'like', $value . '%');
        if (isset($data['sort'])) {
            $query->order($data['sort']);
        }
    }
```

```php
        $result = UserModel::withSearch(['email', 'create_time'], [
            'email' => 'xiao',
            'create_time' => ['2014-1-1', '2017-1-1'],
            'sort' => ['price' => 'desc']
        ])->select();
```

搜索器的第三个参数$data,可以得到withSearch()方法第二参数的值

字段也可以设置别名：'create_time'=>'ctime'

### 2、模型数据集

1.数据集由all()和select()方法返回数据集对象

数据集对象和数组操作方法一样，循环遍历、删除元素等

2.判断数据集是否为空，我们需要采用isEmpty()方法

```php
        $result = UserModel::where('id', 111)->select();
        if ($result->isEmpty()) {
            return '没有数据';
        }
```

3.使用模型方法hidden()可以隐藏某个字段，使用visible()只显示某个字段

使用append()可以添加某个获取器的字段，使用withAttr()对字段进行函数处理

```php
        $result = UserModel::select();
        $result->hidden(['password'])->append(['nothing'])->withAttr('email', function ($value) {
            return strtoupper($value);
        });
        return json($result);
```

4.使用模型方法filter()对筛选的数据进行过滤

```php
        $result = UserModel::select()->filter(function ($data) {
            return $data['price'] > 100;
        });
```

5.也可以使用数据集之后链接where()方法来代替filter()方法

```php
        $result = UserModel::select()->where('price', '>', '100');
```

6.数据集甚至还可以使用oder()方法进行排序

```php
        $result = UserModel::select()->order('price', 'desc');
```

7.使用diff()和intersect()方法可以计算两个数据集的差集和交集

```php
        $result1 = UserModel::where('price', '>', '80')->select();
        $result2 = UserModel::where('price', '<', '100')->select();
        return json($result1->diff($result2));
        return json($result1->intersect($result2));
```

## 模型自动时间戳和只读字段

### 1、模型自动时间戳

1.系统自动创建和更新时间戳功能默认为关闭状态

如果想全局开启，在database.php中，设置为true

```php
    // 自动写入时间戳字段
    'auto_timestamp'  => 'datetime',
```

2.如果只想设置某一个模型开启，需要设置特有字段

```php
    // 模型自动时间戳 只想设置某一个模块开启，需要设置特有字段
    protected $autoWriteTimestamp = true;
```

还有一种方法，就是全局开启，单独关闭某个或某几个模型为false

自动时间戳开启后，会自动写入create_time和update_time两个字段

此时，它们默认的类型为int，如果是时间类型，可以更改如下

```php
 'auto_timestamp'  => 'datetime',	//或
 protected $autoWriteTimestamp = 'datetime';
```

自动时间戳只能在模型下有效，数据库方法不可以使用

3.如果创建和修改时间戳不是默认定义的，也可以自定义

```php
protected $createTime = 'create_at';
protected $updateTime = 'update_at';
```

如果业务中只需要create_time而不需要update_time，可以关闭它

```php
protected $updateTime = false;
```

也可以设置动态实现不修改update_time，具体如下

```php
$user->isAutoWriteTimestamp(false)->save();
```

### 2、模型只读字段

1.模型中可以设置只读字段，就是无法被修改的字段设置

要设置username和email不允许被修改

```php
protected $readonly = ['username','email'];
```

除了在模型端设置，也可以动态设置只读字段

```php
$user->readonly(['username','email'])->save();
```

只读字段只支持模型方法不支持数据库方式

## 模型类型转换和数据完成

### 1、模型类型转换

1.系统可以通过模型端设置写入或读取时对字段类型进行转换，通过读取的方式来演示部分效果

在模型端设置你想要类型转换的字段属性，属性值为数值

```php
    protected $type = [
        'price'         =>  'integer',
        'status'        =>  'boolean',
        'create_time'   =>  'datetime:Y-m-d'
    ];
```

数据库查询读取的字段很多都是字符串类型，可以转换成如下类型：

integer(整形)、float(浮点型)、boolean(布尔型)、array(数组)、object(对象)、serialize(序列化)、json(json)、timestamp(时间戳)、datetime(日期)

由于数据库没有那么多类型演示，常用度不显著

```php
    public function typeConversion()
    {
        $user = UserModel::get(21);
        var_dump($user->price);
        var_dump($user->status);
        var_dump($user->create_time);
    }
```

类型转换还是会调用属性里的获取器等操作，编码时要注意这方面的问题

### 2、模型数据完成

1.模型中数据完成通过auto、insert、和update三种形式完成

auto表示新增和修改操作，insert只表示新增，update只表示修改

```php
    protected $atuo   = ['email'];
    protected $insert = ['uid' => 1];
    protected $update = [];
```

当insert时，新增一条数据时会触发新增数据完成，此时，并不需要自己去新增uid，它会自动给uid赋值为1

```php
        // 实例化模型对象
        $user = new UserModel();

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
```

auto表示新增和修改均要自动完成，而不给默认值的字段需要修改器提供

```php
    public function setEmailAttr($value)
    {
        return strtoupper($value);
    }
```

新增时，邮箱字符串会给修改器自动完成大写，那数据完成的意义何在？

修改时，如果你不去修改邮箱，在数据自动完成强制完成，会自动完成大写，也就是说，邮箱的大写，设置update更加合适，因为新增必然触发修改器，对于update自动完成，和auto、insert一样。

## 模型查询范围和输出

### 1、模型查询范围

1.在模型端创建一个封装的查询方法或写入方法，方便控制器调用

比如：封装一个筛选所有性别为男的查询，并且只显示部分字段5条

方法名规范：前缀scope，后缀随意，调用时直接把后缀作为参数使用

```php
    public function scopeGenderMale($query)
    {
        $query->where('gender', '男')->field('id, username, gender, email')->limit(5);
    }
```

在控制器端，直接调用并输出结果

```php
    public function queryScope()
    {
        $result = UserModel::scope('gendermale')->select();
        return json($result);
    }
```

也可以实现多个查询封装方法连缀调用，比如找出邮箱xia并大于80分的

```php
    public function scopeEmailLike($query, $value)
    {
        $query->where('email', 'like', '%' . $value . '%');
    }
    public function scopePriceGreater($query, $value)
    {
        $query->where('price', '>', 80);
    }
```

```php
        $result = UserModel::emailLike('xiao')->priceGreater(80)->select();
```

查询范围只能使用find()和select()两种方法

2.全局范围查询，就是在此模型下不管怎么查询都会加上全局条件

```php
    protected function base($query)
    {
        $query->where('status', 1);
    }
```

在定义了全局查询后，如果某些不需要全局查询可以使用useGlobalScope取消

```php
UserModel::useGlobalScope(false)
```

当然，设置为true，则开启全局范围查询，注意：这个方法需要跟在::后面

```php
userModel::useGlobalScope(true)
```

### 2、模型输出方式

1.通过模板进行数据输出

```php
    public function view()
    {
        $user = UserModel::get(21);
        $this->assign('user', $user);
        return $this->fetch();
    }
```

根据错误提示，可以创建相对应的模板，然后进行数据显示

```php
{$user.username}.{$user.gender}.{$user.email}
```

2.使用toArray()方法，将对象按照数组的方式输出

```php
print_r($user->toArray());
```

和之前的数据集一样，它也支持hidden、append、visible等方法

```php
print_r($user->hidden(['password,update_time'])->toArray());
```

toArray()方法也支持all()和select()等列表数据

```php
print_r(UserModel::select()->toArray());
```

使用toJson()方法将数据对象进行序列化操作，也支持hidden等方法

```php
print_r($user->toJson());
```

## JSON字段

### 1、数据库JSON

1.数据库写入JSON字段，直接通过数组的方式即可完成

```php
    public function json()
    {
        $data = [
            'username'  => '辉夜',
            'password'  => '123',
            'gender'    => '女',
            'email'     => 'huiye@163.com',
            'price'     => 90, 'details' => '123',
            'uid'       => 1011,
            'status'    => 1,
            'list'      => ['username' => '辉夜', 'gender' => '女', 'email' => 'huiye@163.com'],
        ];
        Db::name('user')->insert($data);
```

从上面写入可以看出，list字段设置的是json格式，通过数组写入的就是json

如果写入details字段是text文本格式，通过数组会报错，这个时候，采用->json(['details'])方法来进行转换，也可以写入json数据

```php
'details'   => ['content' => 123],
```

```php
Db::name('user')->json(['details'])->insert($data);
```

在查询上，也可以使用->json(['list,details'])方法来获取数据

```php
        $user = Db::name('user')->json(['list', 'details'])->where('id', 280)->find();
        return json($user);
```

如果将json字段里的数据作为查询条件，可以通过如下方式实现

```php
        $user = Db::name('user')->json(['list', 'details'])->where('list->username', '辉夜')->find();
        return json($user);
```

如果完全修改json数据，可以使用如下的方式实现

```php
        $data['list'] = ['username' => '李白', 'gender' => '男'];
        Db::name('user')->json(['list'])->where('id', 279)->update($data);
```

如果只想修改json数据里的某一个项目，可以使用如下的方式实现

```php
        $data['list->username'] = '李黑';
        Db::name('user')->json(['list'])->where('id', 279)->update($data);
```

### 2、模型JSON

1.使用模型方式去对新增包含json数据的字段

```php
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
```

2.对于本身不是json字段，想要写入json字段的字符字段，需要设置

```php
protected $json = ['details', 'list'];
```

3.也可以通过对象的方式，进行对json字段的写入操作

```php
        $list = new \StdClass();
        $list->username = '辉夜';
        $list->gender = '女';
        $list->email = 'huiye@163.com';
        $list->uid = 1011;
        $user->list = $list;
```

通过对象调用方式，直接获取json里面的数据

```php
        $user = UserModel::get(279);
        return $user->list->username;
```

通过json的数据查询，获取一条数据

```php
        $user = UserModel::where('list->username', '辉夜')->find();
        return $user->list->email;
```

更新修改json数据，直接通过对象方式即可

```php
        $user = UserModel::get(279);
        $user->list->username = '李白';
```

##   软删除

### 1、数据库软删除

1.所谓的软删除，并不是真正的删除数据，而是给数据设置一个标记

首先，需要在数据表创建一个delete_time，默认为Null

其次，使用软删除功能，软删除其实就是update操作，创建一个时间标记

```php
        Db::name('user')->where('id', 78)
            ->useSoftDelete('delete_time', date('Y-m-d H:i:s'))
            ->delete();
        return Db::getLastSql();
```

### 2、模型软删除

1.定义好模型后，我们就可以使用

```php
        User::destroy(1);
        // 真实删除
        User::destroy(1, true);

        $user = User::get(1);
        // 软删除
        $user->delete();
        // 真实删除
        $user->delete(true);
```

2.首先，需要在模型端设置软删除的功能，引入softDelete,它是trait；

```php
    use SoftDelete;
    protected $deleteTime = 'delete_time';
```

delete_time默认设置是Null，如果想更改这个默认值，可以设置

```php
// protected $defaultSoftDelete = 0;
```

默认情况下，开启了软删除功能的查询，模型会自动屏蔽被软删除的数据

```php
        $user = UserModel::select();
        return json($user);
```

在开启软删除功能的前提下，使用withTrashed()方法取消屏蔽软删除的数据

```php
        $user = UserModel::WithTrashed()->select();
        return json($user);
```

如果只想查询软删除的数据，使用onlyTrashed()方法即可

```php
        $user = UserModel::onlyTrashed()->select();
        return json($user);
```

如果想让某一条软删除的数据恢复到正常数据，可以使用restore()方法

```php
        $user = UserModel::onlyTrashed()->find();
        $user->restore();
```

如果想让一条软删除的数据真正删除，在恢复正常后，使用 delete(true);

```php
        $user = UserModel::onlyTrashed()->get(78);
        $user->restore();
        $user->delete(true);
```

## 模板引擎和视图渲染

### 1、模板引擎

1.MVC中，M(模型)和C(控制器)，而V(视图)，也就是模板页面，是MVC中第三个核心内容

2.模板引擎分为两种，一种内置的，一种外置作为插件引入的，用内置的即可，内置的模板引擎的配置文件是confing/template.php，默认情况下不需要修改任何参数，view_path默认是view目录

### 2、视图引擎

1.在控制器端，首先继承一下控制器基类(不是必须，助手函数也行)

2.先采用第一种不带任何参数的最典型的做法(自动定位)，看它报错信息

```php
<?php

namespace app\index\controller;

use think\Controller;

class See extends Controller
{
    public function index()
    {
        // 自动定位
        return $this->fetch();
    }
}
```

3.模板路径为：当前模块/view/当前控制器名(小写)/当前操作(小写).html

4.如果想制定一个输出的模板，可以在fetch()方法传递相应的参数

```php
        return $this->fetch('edit');                //指定模板
        return $this->fetch('public/edit');         //目录下的模板
        return $this->fetch('admin@public/edit');   //指定模块下的模板
        return $this->fetch('/edit');               //view_path下的模板
```

5.如果没有继承Controller控制器的话，可以使用助手函数view()方法

```php
return view('edit');
```

## 视图赋值和过滤

### 1、视图赋值

1.在继承控制器基类的情况下，可以使用assign()方法进行赋值

```php
        $this->assign('name', 'ThinkPHP');
        return $this->fetch('index');
```

2.也可以通过数组的方式，进行多个变量的赋值

```php
        $this->assign([
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
```

3.assign()方法和fetch()方法也可以合二为一进行操作

```php
        return $this->fetch('index', [
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
```

4.使用display()方法，可以不通过模板直接解析变量

```php
        $content = '{$username}.{$email}';
        return $this->display($content, [
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
```

5.使用view()助手函数实现渲染并赋值操作

```php
        // 使用view()助手函数实现渲染并赋值操作
        return view('index', [
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);

        return view('index')->assign([
            'username'      =>      '辉夜',
            'email'         =>      'huiye@163.com'
        ]);
```

6.使用view::share()静态方法，可以在系统任意位置做全局变量赋值

```php
\think\facade\View::share('key', 'value');  // 也支持数组
```

### 2、视图过滤

1.如果需要对模板页面输出的变量进行过滤，可以使用filter()方法

```php
        $this->filter(function ($content) {
            return str_replace('1', '<br/>', $content);
        })->fetch();

        return view('index')->assign([
            'username'      =>      '辉1夜',
            'email'         =>      'huiye@163.com'
        ]);
```

这里的$content表示所有的模板变量，找到1之后，实现换行操作

2.如果控制器有N个方法，都需要过滤，可以直接初始化中全局过滤

```php
    public function initialize()
    {
        return $this->filter(function ($content) {
            return str_replace('1', '<br/>', $content);
        });
    }
```

也可以使用函数实现模板变量的过滤功能

```php
		return view()->filter(function ($content) {
            return str_replace('1', '<br/>', $content);
        });
```

## 模板变量输出

### 1、变量输出

1.模板变量的输出方式，控制器实现赋值

```php
$this->assing('name','ThinkPHP');
```

当模板位置创建好后，输出控制器的赋值变量时，用花括号和$符号

```php
{$name}
```

当程序运行的时候，会在runtime/temp目录下生成一个编译文件

```php
<?php echo htmlentities($name); ?>
```

2.如果传递的值是数组，那么编译文件也会自动相应的对应输出方式

```php
    public function varOutput()
    {
        $data['username']       =      '辉夜';
        $data['email']          =      'huiye@163.com';
        $this->assign('user', $data);
        return $this->fetch('var');
    }
```

模板调用：

```php
{$user.username}.{$user.email} //或{$user['email']} 
```

编译文件：

```php
<?php echo htmlentities($user['username']); ?>.<?php echo htmlentities($user['email']); ?>
```

3.如果传递的值是对象，那么编译文件也会自动相应的对应输出方式

```php
        $obj = new \stdClass();
        $obj->username = '辉夜';
        $obj->email    = 'huiye@163.com';
        $this->assign('obj', $obj);
        return $this->fetch('var');
```

模板调用：

```php
{$obj->username}.{$obj->email}
```

编译文件：

```php
<?php echo htmlentities($obj->username); ?>.<?php echo htmlentities($obj->email); ?>
```

如果对模型对象的数据列表，数组和对象方式均可

### 2、其他输出

1.如果输出的变量没有值，可以直接设置默认值代替

```php
{$user.name|default='没有用户名'}
```

2.使用$Think.xxx.yyy方式，可以输出系统的变量

系统变量有：$_SERVER、$_ENV、$_GET、$_POST、$_REQUEST、$_SESSION 和$_COOKIE；

```php
{$Think.get.name}
```

3.除了变量，常量也可以在模板直接输出

```php
{$Think.const.PHP_VERSION} {$Think.PHP_VERSION}
```

4.系统配置也可以直接在模板输出，配置参数可以在config文件下

```php
{$Think.config.default_return_type}
```

## 模板中函数和运算符

### 1、使用函数

1.控制器端先赋值一个密码的变量，模板区设置md5加密操作

```php
$this->assign('password', '123456');
```

```php
{$password|md5}
```

系统默认在编译时会采用htmlentities过滤函数防止XSS跨站脚步攻击

如果想更换一个过滤函数，比如htmlspecialchars，可以在配置文件设置

具体在config下的template.php中，增加一条如下配置即可

```php
'default_filter' => 'htmlspecialchars'
```

2.如果在某个字符，不需要进行HTML实体转义的话，可以单独使用raw处理

```php
<?php echo $user['email']; ?>
```

3.系统还提供了一些固定的过滤方法，如下

| 函数    | 说明                               |
| ------- | ---------------------------------- |
| date    | 格式化时间{$time\|date='Y-m-d'}    |
| format  | 格式化字符串{$number\|format='%x'} |
| upper   | 转换为大写                         |
| lower   | 转换为小写                         |
| first   | 输出数组的第一个元素               |
| last    | 输出数组的最后一个元素             |
| default | 默认值                             |
| raw     | 不使用转义                         |

```php
$this->assign('time', time());
{$time|date='Y-m-d'}
```

```php
$this->assign('number', '14');
{$number|format='%x'}
```

如果函数中，需要多个参数调用，直接用逗号隔开即可

```php
{$password|substr=0,3}
```

在模板中也支持多个函数进行操作，用|号隔开即可，函数从左到右依次执行

```php
{$$password|md5|upper|substr=0,3}
```

也可以在模板中直接使用PHP的语法模式，该方法不会使用过滤转义

```php
{:substr(strtoupper(md5($$password)),0,3)}
```

### 2、运算符

1.在模板中运算符有+、-、*、/、%、++、--等

```php
{$number+$number}
```

2.如果在模板中运算符，则函数方法则不再支持

```php
{$number+$number|default='没有值'}
```

3.模板也可以实现三元运算，包括其它写法

```php
{$name ? '正确' : '错误'} //$name 为 true 返回正确，否则返回错误 
{$name ?= '真'} //$name 为 true 返回真 
{$Think.get.name ?? '不存在'} //??用于系统变量，没有值时输出 
{$name ?: '不存在'} //?:用于普通变量，没有值时输出
```

4.三元运算符也支持运算返回布尔值判断

```php
{$a == $b ? '真':'假'}
```

# 模板的循坏标签

### 1、foreach循坏

1.控制器端先通过模型把相应的数据列表给筛选出来

```php
    public function loop()
    {
        $list = UserModel::all();
        $this->assign('list', $list);
        return $this->fetch('user');
    }
```

2.在模板端使用对称的标签{foreach}...{/foreach}实现循坏

```php
    {foreach $list as $key=>$obj}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/foreach}
```

其中$list是控制器端传递的数据集，$key是Index索引，$obj是数据对象

也可以在模板中直接执行模型数据调用，而不在控制器设置

```php
    {foreach :model('user')->all() as $key=>$obj}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/foreach}
```

### 2、volist循坏

1.volist也是将查询得到的数据集通过循坏的方式进行输出

```php
    {volist name='list' id='obj'}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/volist}
```

volist中的name属性表示数据总集，id属性表示当前循坏的数据单条集

volist也可以直接使用模型对象获取数据集的方式进行循坏输出

```php
    {volist name='list' id='obj'}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/volist}
```

2.使用offset属性和length属性从第4条开始显示5条，这里的下标从0开始

```php
    {volist name='list' id='obj' offset='3' length='5'}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/volist}
```

3.可以使用eq标签来实现奇数或偶数来筛选数据

```php
    {volist name='list' id='obj' mod='2'}
    {eq name='mod' value='0'}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/eq}
    {/volist}
```

通过编译文件可以理解，mod=2表示索引除以2得到的余数是否等于0或1

如果余数设置为0，那么输出的即偶数，如果设置为1，则输出的是奇数

4.使用empty属性，可以当没有任何数据的时候，实现输出指定的提示

```php
    {volist name=':model("user")->where("id",1000)->all()' id='obj' empty='没有任何数据'}
    {$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/volist}
```

empty属性，可以是控制器端传递过来的变量，比如:empty='$empty';

5.使用key='k'，让索引从1开始计算，不指定就用{$i}，指定后失效

```php
    {volist name='list' id='obj' key='k'}
    {$k}.{$key}.{$obj.id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
    {/volist}
```

### 3、for循坏

1.for循坏，通过起始和终止值，结合步长实现循环

```php
{for start='1' end='100' comparison='<' step='2' name='i' } {$i} {/for} <br>
```

## 模板的比较和定义标签

### 1、比较标签

1.{eq}..{/eq}标签，比较两个值是否相同，相同输出包含内容

```php
    public function compare(){
        $this->assign('username','Mr.lee');
        return $this->fetch('compare');
    }
```

```php
    {eq name='username' value='Mr.lee'}
    李先生
    {/eq}
```

属性name里是一个变量，$符号可加可不加；而value里的是一个字符串

如果value也需要一个变量的话，那么value需要加上$后的变量

```php
        $username = 'Mr.lee';
        $this->assign('username',$username);
```

```php
    {eq name='username' value='$username'}
    李小姐
    {/eq}
```



### 2、定义标签