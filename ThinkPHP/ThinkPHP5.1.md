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

打开index.php文件，追加一个方法：

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

2.{eq}标签有一个别名标签：{equal}，效果是一样的

相对应的{neq}或{noteqal}，实现相反的效果

```php
    {neq name='username' value='Mr.wang'}
    两个值不相等
    {/neq}
```

这一组标签也支持else操作，标签为：{else/}；

```php
    {eq name='username' value='Mr.lee'}
    两个值相等
    {else/}
    两个值不相等
    {/eq}
```

{gt}(>)、{egt}(>=)、{lt}(<)、{elt}(<=)、{heq}(===)和{nheq}(!==)； 

除了相等和不等，还有上面六种比较形式

```php
$this->assign('number', 10);
```

```php
    {egt name='number' value='10'}
    大于等于10
    {else/}
    小于10
    {/egt}
```

3.所有的标签都可以统一为{compare}标签使用，增加一个type方法指向即可

```php
    {compare name='username' value='Mr.lee' type='eq'}
    两个值相等
    {/compare}
```

### 2、定义标签

1.如果你想在模板文件中定义一个变量，可以使用{assign}标签

```php
    {assign name='var' value='123'}
    {$var}
```

2.有变量的定义就会有常量的定义，可以使用{define}标签

```php
    {define name='PI' value='3.1415'}
    {$Think.const.PI}
```

3.不知道在模板中怎么进行编码时，可以采用{php}标签进行原生编码

```php
    {php}
    echo '原生编码';
    {/php}
```

要注意的是原生编码就是PHP编码，不能使用模板引擎的特殊编码方式，比如{eq}，{$user.name}这些标签语法

4.标签之间是支持嵌套功能的，比如从列表中找到"樱桃小丸子"

```php
    {foreach $list as $key=>$obj}
        {eq name='obj.username' value='樱桃小丸子'}
            {$key}.{$obj->id}.{$obj.username}({$obj.gender}).{$obj.email}<br>
        {/eq}
    {/foreach}
```

## 模板的条件判断标签

### 1、switch标签

1.使用{switch}...{/switch}可以实现多个条件判断

```php
    public function condition()
    {
        $this->assign('number', 10);
        return $this->fetch('condition');
    }
```

```php
    {switch number}
        {case 1}1{/case}
        {case 5}5{/case}
        {case 10}10{/case}
        {default/}不存在
    {/switch}
```

{case}也支持多个条件判断，使用|线隔开即可

```php
    {switch number}
    {case 10|20|30}10,20,30均可{/case}
    {/switch}
```

{case}后面也可以是变量，设置变量后不可以使用|线

{case $id}

### 2、if标签

1.使用简单条件判断的{if}标签

```php
    {if $number>10}
        大于10
    {/if}
```

2.{if}标签的条件判断可以使用AND、OR等语法

```php
    {if $number>10 OR $number>5}
        大于10
    {/if}
```

3.{if}标签支持{else/}语法

```php
    {if $number >10}
        大于10
    {else/}
        小于10
    {/if}
```

4.{if}标签也支持{elseif}多重条件判断

```php
    {if $number>100}
        大于100
    {elseif $number>50}
        大于50
    {else/}
        小于50
    {/if}
```

5.{if}标签中的条件判断支持PHP写法，比如函数和对象调用

```php
    {if strtoupper($user->username) == 'MR.LEE'}
        是李先生
    {/if}
```

### 3、范围标签

1.范围标签：{in}和{notin}，判断值是否攒在或不存在指定的数据列表中

```php
    {in name='number' value='10,20,30,40,50'}存在{/in}
    <br>
    {in name='number' value='10,20,30,40,50'}
        存在数据列表中
    {else/}
        不存在数据列表中
    {/in}
```

2.name值可以是系统变量，比如$Think.xxx.yyy，value可以是变量

3.范围标签：{between}和{notbetween}，判断值是否存在或不存在在数据区间中

```php
    {between name='number' value='10,50'}存在{/between}
    <br>
    {between name='number' value='10,50'}
    存在数据列表中
    {else/}
    不存在数据列表中
    {/between}
```

between中的value只能是两个值，表示一个区间，第三个值会无效

区间不但可以表达数字，也可以是字母，比如a-z，A-Z

### 4、是否存在标签

1.是否存在：{present}和{notpresent}判断变量是否已经定义赋值(是否存在)

```php
    {present name='user'}存在{/present}
    <br>
    {present name='user'}
        user已存在
    {else/}
        user不存在
    {/present}
```

2.是否为空：{empty}和{notempty}判断变量是否为空值

```php
{empty name='username'}有值{/empty}
<br>
{empty name='username'}
    username有值
{else/}
    username没有值
{/empty}
```

3.常量是否定义：{defined}判断常量是否定义

```php
    {defined name='PI'}
        PI存在
    {else/}
        PI不存在
    {/defined}
```

## 模板的加载包含输出

### 1、包含文件

1.使用{include}标签来加载公用重复的文件，比如头部、尾部和导航部分

2.在模板view目录创建一个public公共目录，分别创建header、footer和nav

然后创建Block控制器，引入控制器模板index，这个模板包含三个公用文件

```php
{include file='public/header,public/nav'}
主体
{include file='public/footer'}
```

也可以包含一个文件的完整路径，包含后缀

```php
{include file='../application/index/view/public/nav.html'/}
```

3.模板的标题和关键字，可以通过固定的语法进行传

对于标题，在控制器线设置一下标题变量，然后设置{include}设置属性

```php
$this->assign('title','模板');
```

```php
{include file='public/header,public/nav' title='$title' keywords='这是一个模板'}
```

```php
    <meta charset="UTF-8" name="keywords" content="[keywords]">
    <title>[title]</title>
```

4.切换到public/header.html模板页面，使用[xxx]方式调用数据

```php
    <meta charset="UTF-8" name="keywords" content="[keywords]">
    <title>[title]</title>
```

### 2、输出替换

1.当需要调用一些静态文件，比如css/js等，一般会将这些静态文件存放在根目录public/static/css(或js)，那么，直接写完整路径，比较烦长，可以把这些路径整理打包

在config目录下，template.php中，配置新增一个参数

```php
    'tpl_replace_string' => [
        '__JS__' => '../../static/js',
        '__CSS__' => '../../static/css',
        ]
```

如果在顶级域名下，直接改成/static/css即可，加一个反斜杠

html文件调用端，直接通过`__CSS__(__JS__)`配置的魔术方法调用即可

```php
    <link rel="stylesheet" type="text/css" href="__CSS__/basic.css">
    <script type="text/javascript" src="__JS__/basic.js"></script>
```

在测试的时候，由于更改的配置文件刷新，每次都要删除编译文件才能生效

### 3、文件加载

1.传统方式调用CSS或JS文件时，采用link和script标签实现

系统提供了更加智能的加载方式，方便加载CSS和JS等文件

使用{load}标签和herf属性来链接，不需要设置任何其他参数

```php
{load href='__CSS__/basic.css'}
{load href='__JS__/basic.js'}
```

也支持href多属性值的写法

```php
{load href='__CSS__/basic.css,__JS__/basic.js'}
```

2.{load}还提供了两个别名{js}、{css}来更好的实现可读性

```php
{js href='__JS__/basic.css'}
{css href='__CSS__/basic.css,__JS__/basic.js''}
```

{js}和{css}只是别名而已，识别.js还.css是根据后缀的

## 模板布的布局和继承

### 1、模板布局

1.默认情况下，不支持模板布局功能，需要在配置文件中开启

在配置文件template.php中，配置开始模板布局功能

```php
'layout_on' => true,
```

此时，执行上次的模板控制器，会发现提示缺少模板layout.html

这个默认的布局文件，是可以更改的，位置和名字都可配置

```php
'layout_name' => 'public/layout',
```

2.使用`{__CONTENT__}`魔术方法的标签来引入index.html的"主体"内容

```php
{__CONTENT__}
```

可以更改`{__CONTENT__}`，只要在配置文件中配置

```php
'layout_item' => '{__REPLACE__}'
```

在测试的时候，如果更改了配置文件，务必删除temp下编译文件再刷新

这是第一种布局方式，通过配置文件开启布局

2.第二种布局方式则不需要开启直接使用

首先，必须关闭第一种配置，然后使用{layout}标签

只要在index.html的最上面加上如下代码，即可实现模板布局

```php
{layout name='public/layout' repalce='[__CONTENT__'}
```

3.第三种，直接在控制器端执行layout(true)方法即可，false表示临时关闭

```php
        $this->view->engine->layout(true);
```

这种方法虽然不需要开启配置文件，但如果不用默认路径，还是要配置路径等

### 2、模板继承

1.模板继承是另一种布局方式，这种布局方式的思路更加灵活

首先，要创建一个public/base.html的基模板文件，文件名随意

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
</head>
<body>
</body>
</html>
```

2.创建一个新的方法extend载入新的模板extend.html，然后加载基模板

```php
{extend name='public/base'}
{extend name='../application/view/public/base.html'}
```

对于模板基类里的变量{$title}，直接在控制器设置传值即可

```php
        $this->assign('title', '模板');
```

3.在基模板base.html中，设置几个可替换的区块部分，{block}标签实现

```php
{block name='nav'}nav{/block}
{block name='include'}{include file='public:nav'}{/block}
{block name='footer'}@ThinkPHP 版权所有{/block}
```

在extend.html模板中，改变nav，变成所需要的部分

```php
{block name='nav'}
<ol>
    <li>首页</li>
    <li>分类</li>
    <li>关于</li>
</ol>
{/block}
```

在base.html中，{include}可以加载内容，而子啊extend.html可以改变加载

```php
{block name='include'}{include file='public:header'}{/block}
```

在base.html中已设置的内容，可以通过`{__block__}`加载到extend.html中

```php
{block name='footer'}
    本站来自：{__block__}|翻版必究
{/block}
```

## 模板的一些杂项

### 1、原样输出

1.有时，需要输出类似模板标签或语法的数据，这时会被模板解析

此时，就使用模板的原样输出标签{literal}

```php
    {literal}
    变量标签形式：{$name}
    {/literal}
```

### 2、模板注释

1.对于在HTML页面中的标签，用HTML注释是无效的，需要模板定义的注释

```php
    {//$name}
    {/*$name*/}
    {/*
        多行注释
    */}
```

注释和{符号之间不能有空格，否则无法实现注释隐藏

生成编译文件后，注释的内容会自动删除，不会显示

### 3、标签扩展

1.标签库分为内置和扩展标签，内置标签库是Cx标签库，就是默认使用的

标签库源文件在：根目录下thinkphp/library/think/template/tagLib

其中TagLib.php是标签解析基类，Cx.php是标签库解析类，继承自TagLib

```php
{eq name='xxx'}yyy{/eq}
```

因为Cx是内置标签，使用的时候是非常简洁的形式，如果扩展标签则如下格式

```php
{cx:eq name='xxx'}yyy{/cx:eq}
```

2.如果自定义一个扩展的标签库，可以按照Cx.php，在同目录下创建Html.php

```php
<?php
namespace think\template\taglib;
use think\template\TagLib;
class Html extends  TagLib
{
    // 定义标签列表
    protected $tags=[
        // 标签定义：attr属性列表 close是否闭合(0或者1，默认1)
        'font'  =>  ['attr'=>'close,size','close'=>1]
    ];
    // 闭合标签
    public function tagFont($tag,$content)
    {
        $parseStr = '<span style="color:'.$tag['color'].';font-size:'.($tag['size']*10).'px">'.$content.'</span>';
            return $parseStr;
    }
}
```

对于扩展标签，需要在模板中引入这个标签，并使用扩展标签

```php
    {taglib name='html'}
    {html:font color='red' size='10'}
    我是ThinkPHP
    {/html:font}
```

3.如果想把这个扩展标签库移动到应用目录区，比如：application\taglib

需要在temlate.php配置一下预加载标签

```php
    // 预先加载的标签库
    'taglib_pre_load' => 'app\taglib\Html'
```

更改一下命名空间

```php
namespace app\taglib;
```

在模板中引入这个标签，并使用扩展标签

```php
	{html:font color='red' size='10'}
    我是ThinkPHP
    {/html:font}
```

## 路由介绍和定义

### 1、路由介绍

1.路由的作用就是让URL地址更加的规范和优雅，或者说更加简洁

2.设置路由对URL的检测、验证等一系列操作提供了极大的便利性

3.在ThinkPHP5.1中，路由是默认开启的，没有配置开关，不需要手动配置

4.创建一个Adderss控制器类，创建两个方法，具体如下

```php
class Address
{
    public function index()
    {
        return 'index';
    }

    public function details($id)
    {
        return 'detalis目前调用的id:'.$id;
    }
    
}
```

3.通过命令行模式进入到当前项目的目录后，输入命令：php think run 启动

此时，public目录会自动被绑定到顶级域名127.0.0.0:8000上

### 2、路由定义

1.在没有定义路由规则的情况下，访问address/deteils包含id的URL为：

```php
http://127.0.0.1:8000/index/address/details/id/5	//或者../id/5.html
```

2.将这个URL定义路由规则，在根目录route下的Route.php里配置

```php
Route::get('details/:id', 'index/Address/details');
```

3.当配置好路由规则后，会出现非法请求的错误，需要用路由规则的URL访问

```php
http://127.0.0.1:8000/details/5
```

4.一般来说GET方法是用的最多的，所有使用Route::get()最多，其他如下

```php
Route::rule('details/:id', 'index/Address/details','GET');
Route::rule('details/:id', 'index/Address/details','POST');
Route::rule('details/:id', 'index/Address/details','GET|POST');
```

所有的请求方式(快捷方式):GET(get)、POST(post)、DELETE(delete)、PUT(put)、PATCH(patch)、*(any，任意请求方式)

快捷方式就是直接用Route::get、Route::post等方式即可，不需要第三个参数

5.当我们这种了强制路由的时候，访问首页就会报错，必须强制设置首页路由

开启强制路由，需要在app.php里进行设置，然后配置首页路由

```php
    // 是否强制使用路由
    'url_route_must'         => true,
```

```php
Route::get('/', 'index');	//当写一个index，表明控制器是Index
```

6.在路由的规则表达中，由多种地址的配置规则，具体如下

```php
//静态路由
Route::get('ad', 'address/index');
//静态动态结合的地址
Route::get('details/:id','address/details');
//多参数静态动态结合的地址
Route::get('search/:id/:uid', 'address/search');
//全动态地址，不限制是否search固定
Route::get(':search/:id/:uid', 'address/search');
//包含可选参数的地址
Route::get('find/:id/[:content]', 'address/find');
//规则完全匹配 的地址
Route::get('search/:id/:uid$', 'address/search');
```

```php
    // 路由是否完全匹配
    'route_complete_match'   => true,
```

7.路由定义好之后，在控制器要创建这个路由地址，可以通过url()方法实现

```php
Route::get('url','address/url');
```

```php
    public function url()
    {
        //不做标识的做法
        return url('address/details',['id'=>10]);
    }
```

```php
Route::get('url','address/url')->name('det');
```

```php
    public function url()
    {
        //定义标识的做法
        return url('det', ['id'=>10]);
   }
```

## 路由的变量规则和闭包

### 1、变量规则

1.系统默认的路由变量规则为\w+，即字母、数字和下划线

如果需要对具体的变量进行单独的规则设置，则需要通过pattern()方法

2.将details方法里的id传值，严格限制必须只能是数字\d+

```php
Route::get('details/:id', 'address/details')->name('det')->pattern('id', '\d+');
```

也可以设置search方法中两个值的规则，通过数组的方式传递参数

```php
Route::get('search/:id/:uid','address/search')->pattern([
    'id'=>'\d+',
    'uid'=>'\d+'
]);
```

以上两种都为局部变量规则，也可以设置Route.php设置全局变量规则

```php
Route::pattern([
    'id'=>'\d+',
    'uid'=>'\d+'
]);
```

也支持使用组合的规则方式，实现路由规则

```php
Route::get('details-</id>', 'address/details')->pattern('id', '\d+');
```

3.动态组合的拼装，地址和参数如果都是模糊动态的，可以使用如下方法

```php
Route::get('details-:name-:id', 'Hello_:name/det')->pattren('id', '\d+');
```

4.在不设定任何规则的情况下，系统默认为\w+，在配置文件中可以更改默认规则

```php
'default_route_pattern' => '[\w\-]+',
```

### 2、闭包支持

1.闭包支持通过URL直接执行，而不需要通过控制器和方法

```php
Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
```

2.闭包也支持传递参数和动态规则

```php
Route::get('hello/:name',function($name){
    return 'Hello,'.$name;
});
```

## 路由地址和缓存

### 1、路由地址

1.路由的地址一般为：控制器/方法，如果是多模块：模块/控制器/方法

```php
//默认Index控制器
Route::get('/','index');
//控制器/方法
Route::get('details/:id','Address/details');
//模块/控制器/方法
Route::get('details/:id','index/Address/details');
```

2.支持多级控制器，并且支持路由到相应的地址

```php
//目录
namespace app\index\controller\group;
```

```php
//地址
http://127.0.0.1:8000/index/group.address/details/id/5
```

```php
//支持多级路由
Route::get('details/:id', 'index/group.Address/details');
```

3.支持动态路由地址以及额外参数地址

```php
Route::get('deteils-:name-:id', 'Hello_:name/details');
```

```php
//获取隐式GET值 
echo $this->request->param('flag');
```

```php
Route::get('details/:id', 'index/Address/details?flag=1&status=1');
```

4.支持直接去执行方法，不单单是普通方法，还有静态方法

```php
//普通方法调用
Route::get('details/:id', 'app\index\controller\Address@details');
```

```php
//静态方法调用
Route::get('static/:id', 'app\index\controller\Address@static');
```

5.路由也支持重定向功能，实现一个外部跳转

```php
Route::get('details/:id', 'http://www.baidu.com/details/:id')->status(302);
Route::redirect('details/:id', 'http://www.baidu.com/details/:id')->status(302);
```

6.路由也可以对模板直接进行传值

```php
Route::view('see/:name', 'See/other'); 
Route::view('see/:name', 'See/other', ['email'=>'baidu@163.com']);
```

### 2、路由缓存

1.路由缓存可以极大提高性能，需要在部署环境下才有效，在app.php开启

```php
    // 应用调试模式
    'app_debug'              => false,
```

```php
'route_check_cache' => true,
```

2.可以通过一条命令行命令来清理缓存测试

```php
>php think clear --route
```

## 路由的参数和快捷路由

### 1、路由参数

1.设置路由的时候，可以设置第三个数组参数，主要实施匹配检测和行为执行

2.ext参数作用是检测URL后缀，比如强制所有URL后缀为.html

```php
Route::get('details/:id', 'address/details', ['ext' => 'html']);
```

```php
...['ext'=>'html|shtml']	//支持多个
```

3.第三数组参数也可以作为对象的方法存在，如下方式

```php
Route::get('details/:id', 'address/details')->ext('html');
```

4.https参数作用是检测是否为https请求，结合ext强制html如下

```php
Route::get('details/:id', 'address/details', ['ext' => 'html','https'=>true]);
```

```php
Route::get('details/:id', 'address/details')->ext('html')->https();
```

5.如果想让全局统一配置URL后缀的话，可以在app.php配置

```php
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
```

6.denyExt参数作用是进制某些后缀

```php
Route::get('details/:id','address/details')->denyExt('gif|jpg|png');
```

7.filter参数作用是对额外参数进行检测

```php
Route::get('details/:id','address/details')->filter('id',5);
```

```php
http://127.0.0.1:8000/details/10?id=5
```

8.model参数作用是绑定定模型，第三个参数设置false避免异常，也可以多参数

```php
Route::get('user/:id', 'address/getUser')->model('id', 'app\index\model\User');
Route::get('user/:id', 'address/getUser')->model('id', 'app\index\model\User',false);
```

```php
Route::get('user/:id', 'address/getUser')->model('id&name', 'app\index\model\User');
```

9.option参数作用是全局的路由进行配置，且可以多次调用

```php
Route::option('ext','html')->option('https',true);
```

### 2、快捷路由

1.快捷路由可以快速给控制器注册路由，还可以给不同的请求类型设置前缀

```php
Route::get('short', 'Short/getInfo');
```

2.快捷路由控制器和方法的编写原则，给方法前面加上get或post等请求类型

```php
<?php
namespace app\index\controller;
use think\Controller;

class Short extends Controller
{
    public function index()
    {
        return 'index';
    }
    public function getInfo()
    {
        return 'getInfo';
    }
    public function getList()
    {
        return 'getList';
    }
    public function postInfo()
    {
        return 'postInfo';
    }
}
```

## 路由的分组和注解

### 1、路由分组

1.路由分组，即将相同前缀的路由合并分组，这样可以简化路由定义，提高匹配效率

在定义路由前，专门做一个类，演示这个效果：

```php
<?php
namespace app\index\controller;

use think\Controller;

class Collect extends Controller
{
    public function index()
    {
        return 'index';
    }
    public function red($id)
    {
        return 'red id'.$id;
    }
    public function who($name)
    {
        return 'your name:'.$name;
    }
}
```

2.使用group()方法来进行分组路由的注册

```php
Route::group('col',[
    ':id'    =>  'Collect/read',
    ':name'  =>  'Collect/who'
])->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);
```

3.使用group()方法，并采用闭包的形式进行注册

```php
Route::group('col',function(){
    Route::get(':id', 'Collect/read');
    Route::get(':name', 'Collect/who');
})->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);
```

4.使用prefix()方法，简化路径的地址

```php
Route::group('col',function(){
    Route::get(':id', 'read');
    Route::get(':name', 'who');
})->prefix('Collect/')->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);
```

5.使用append()方法，可以额外传入参数，用request获取

```php
Route::group('col',function(){
    Route::get(':id', 'Collect/read');
    Route::get(':name', 'Collect/who');
})->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$'])->append(['flag'=>1]);
```

```php
public function read($id)
{
    echo $this->request->param('flag');
    return 'read id:'.$id;
}
```

7.路由规则(主要是分组或域名路由)定义的文件，加载时会解析消耗较多的资源，尤其是规则特别庞大的时候，延迟解析开启让你只有在匹配的时候才会注册解析

在app.php中开启延迟解析，多复制机组规则，然后通过trace来查看内存

```php
'url_lazy_route' => true,
```

### 2、注解路由

1.路由系统还提供了一个可以在注解(注释)中直接创建路由的方式，但默认关闭，在app.php中，开启路由注释功能

```php
'route_annotation' => true,
```

2.然后在控制器设置注解代码即可，可以使用PHPDOC生成一段，然后添加路由规则

```php
    /**
     * @param $id
     * @return string
     * @route('col/:id');
     */
```

3.第二参数，可以设置请求类型，而需要设置更多的规则，可以换行设置

```php
/**
 * @param $id
 * @return string
 * @route('col/:id','get')
 * ->ext('html')
 * ->pattern(['id'=>'\d+'])
 *
 */
```

有几个注意点：语句结尾不需要分号，路由规则结束后，需要有一个空行

4.支持资源路由

```php
/**
 * Class Collect
 * @package app\index\controller
 * @route('col')
 */
class Collect extends Controller
```

## 路由的MISS和跨域请求

### 1、MISS路由

1.全局MISS，类似开启强制路由功能，匹配不到相应规则时自动跳转到MISS

```php
Route::miss('public/miss');
```

2.分组MISS，可以在分组中使用miss方法，当不满足匹配规则时跳转到这里

```php
Route::miss('miss');
```

```php
public function miss()
{
    return 'col 不存在404';
}
```

### 2、跨域请求

1.当不同域名进行跨域请求的时候，由于浏览器的安全限制，会被拦截

所以，为了接触这个限制，通过路由allowCrossDomain()来实现

```php
Route::get('col/:id', 'Collect/read') ->ext('html')->allowCrossDomain();
```

实现跨域比如没有实现的header头文件多了几条开头为Access的信息

此时，这个页面，就可以支持跨域请求的操作了

2.如果你想限制跨域请求的域名，则可以增加一条参数

```php
Route::get('col/:id', 'Collect/read') ->ext('html') ->header('Access-Control-Allow-Origin','http://localhost') ->allowCrossDomain();
```

## 路由的绑定和别名

### 1、路由的绑定

1.路由绑定可以简化URL和路由规则的定义，可以绑定到模块/控制器/操作

由于本身不是规则，需要关闭强制路由来测试，本身绑定不是定义路由

admin模块/User控制器/read：http://.../index/user/read/id/5

```php
//绑定路由到index模块
Route::bind('admin');
//绑定路由到User控制器
Route::bind('admin/User');
//绑定路由到read操作
Route::bind('admin/User/read');
```

在创建一个index模块，只要绑定到index模块，开启路由就切换了

```php
Route::bind('index');
Route::bind('user/:id','/user/read');
```

### 2、路由的别名

1.给一个控制器起一个别名，可以通过别名自动生成一系列规则

比如：给admin模块下的User控制器创建别名：user，省去模块index

```php
//给admin模块下的User控制器创建别名：user
Route::alias('user', 'admin/User');
```

```php
http://127.0.0.1:8000/user/index
```

也可以直接绑定到类，来实现相同的效果

```php
Route::alias('user', '\app\admin\controller\User');
```

也支持别名设置限定条件，比如ext等

```php
Route::alias('user', 'admin/User',['ext'=>'html']);
Route::alias('user', 'admin/User')->ext('html');
```

PS：这两个知识点，部分功能有些问题，而别名路由和前面的快捷路由在PHP6已经废弃。

## 资源路由

### 1、资源路由

1.资源路由，采用固定的常用方法来实现简化URL的功能

系统提供了一个命令，方便开发者快速生成一个资源控制器

```php
php think make:controller index/Blog
```

2.模块/控制器，默认在controller目录下

```php
php think make:controller Blog //单应用 
php think make:controller ../index/controller/Blog //多应用
```

从生成的多个方法，包含了显示、增删改查等多个操作方法

3.在路由route.php文件下创建一个资源路由，资源名称可自定义

```php
Route::resource('blog','index/blog');	
```

这里的blog表示资源规则名，Blog表示路由的访问路径

4.资源路由注册成功后，会自动提供以下方法，无须手动注册

GET访问模式下：index(blog)，create(blog/create)，read(blog/:id)，edit(blog/:id/edit)

POST访问模式下：save(blog)

PUT方式下：update(blog/:id)

DELETE方式模式下：delete(blog/:id)

```php
http://127.0.0.1:8000/blog			(index)
http://127.0.0.1:8000/blog/5		(read)
http://127.0.0.1:8000/blog/5/edit	(edit)
```

5.对于POST是新增，一般是表单的POST提交，而PUT和DELETE用AJAX访问

6.将跨域提交的例子修改成.ajax，其中type设置为DELETE即可访问到

```php
$("#button").click(function(){
    $.ajax({
    	type : "DELETE",
		url : "http://localhost:8000/blog/10",
		success : function (res) {
			console.log(res);
		}
    });
});
```

7.默认的参数采用id名称，想用别的名称，比如：blog_id，则：

```php
Route::resource('blog','index/blog')->vars(['blog'=>'blog_id']);	//相应的read($blog_id)
```

8.也可以通过olny()方法限定系统提供的资源方法，比如：

```php
Route::resource('blog','index/blog')->only(['index','save','create']);
```

9.还可以通过except()方法排除系统提供的资源方法，比如：

```php
Route::resource('blog','index/blog')->excpt(['read','delete','update']);
```

10.使用rest()方法，更改系统给予的默认方法，1.请求方式；2.地址；3.操作

```php
Route::rest('create', ['GET', '/:id/add', 'add']);
```

```php
//批量 Route::rest([
	'save' => ['POST', '', 'store'],
	'update' => ['PUT', '/:id', 'save'],
	'delete' => ['DELETE', '/:id', 'destory'],
	]);
```

11.使用嵌套资源路由，可以让上级资源对下级资源进行操作，创建Comment资源

```php
<?php
namespace app\index\controller;

class Comment
{
    public function read($id,$blog_id)
    {
        return 'read Comment id:'.$id.',Blog id:'.$blog_id;
    }
    public function edit($id,$blog_id)
    {
        return 'edit Comment id:'.$id.',Blog id:'.$blog_id;
    }
}
```

```php
Route::resource('blog.comment', 'index/Comment');
```

资源嵌套生成路由规则如下：

```php
http://localhost:8000/blog/:blog_id/comment/:id
http://localhost:8000/blog/:blog_id/comment/:id/edit
```

嵌套资源生成的上级资源默认 id 为：blog_id，可以通过 vars 更改

```php
Route::resource('blog.comment', 'Comment') ->vars(['blog'=>'blogid']);
```

## 域名路由

### 1、域名路由

1.要使用域名路由，首先在本地需要通过hosts文件来了映射

打开 C:\Windows\System32\drivers\etc 找到 hosts 文件

在末尾条件一句：127.0.0.1 news.abc.com映射二级域名

再在末尾添加语句：127.0.0.1 a.new.abc.com用于三级域名泛指

此时，访问news.abc.com就直接映射localhost里了

如果想访问thinkphp独立的服务器，开启后，直接:8080即可

```php
http://news.abc.com:8080
```

2.拿Colltect控制器举例

```php
Route::get('edit/:id','Collect/edit');
```

3.如果想限定在news.abc.com这个域名下才有效，通过域名路由闭包的形式

```php
Route::domain('news',function(){
	Route::get('edit/:id','Collect/edit');
});
```

这里的domain()即路由域名，第一参数，表示二级(子)域名的名称

4.除了闭包方式，也可以通过数组的方式来设置域名路由

```php
Route::domain('news',[
	'edit/:id'=>['Collect/edit']
]);
```

5.除了二级(子)域名设置外，也可以设置完整域名

```php
Route::domain('news.abc.com',[
	'edit/:id'=>['Collect/edit']
]);
```

6.支持多个二级(子)域名，使用相同的路由规则

```php
Route::domain(['news','blog'.'live'],function()[
	Route::get('edit:id','Collect/edit')
]);
```

7.可以作为方法，进行二级(子)域名的检测，或完整域名的检测

```php
Route::get('edit/:id','Collect/edit')->domain('news');
```

```php
Route::get('edit/:id','Collect/edit')->domain('news.abc.com');
```

### 2、域名绑定

1.在app.php中可以设置根域名，如果不设置，会默认自动获取

```php
'url_domain_root' => 'abc.com',
```

当设置了根域名后，如果实际域名不符，将解析失败

2.域名设置还支持绑定指定的模块，比如多应用的admin模块

```php
Route::domain('news','admin');
Route::domain('news.abc.com','admin');
Route::domain('127.0.0.1','admin');
```

3.如果遇到三级域名，并且需要通过泛指，可以使用*通配符

```php
Route::domain('*.news',[
	'edit/:id'=>['Collect/edit']
]);
```

而直接使用通配符*，则指定所有的二级域名

```php
Route::domain('*',{
	'edit/:id'=>['Collect/edit']
});
```

## 路由的URL生成

### 1、URL生成

1.之前的所有URL都是手动输入的，而路由也提供了一套生成方法

```php
url::build('地址表达式',['参数'],['URL后缀'],['域名'])
url('地址表达式',['参数'],['URL后缀'],['域名'])
```

2.在Collect演示生成，拿blog来实现URL地址

使用build()方法，只传一个控制器时，会被误认为Collect下blog方法

```php
use think\facade\Url;
```

```php
return Url::build('Blog');	// /index/collect/blog.html
```

3.在没有设置路由的情况下，传递 一个控制器以及操作方法

```php
return Url::build('Blog/create');	// http://127.0.0.1:8000/index/collect/
```

如果设置了对应路由，第4条生成的URL会相应的改变

```php
Route::get('bc','Blog/create');		// /bc.html
```

```php
Route::get('bl/bc','Blog/create');	// /bl/bc.html
```

4.下面是没有设置路由和设置路由带参数的URL生成

```php
return Url::build('Blog/read', 'id=5');		// /index/blog/read/id/5.html
```

```php
Route::get('read/:id','Blog/read');		// /read/5.html
```

参数部分，也可以用数组的方式，当然，多参数也支持

```php
        return Url::build('Blog/read',['id'=>5]);
        return Url::build('Blog/read','id=5&uid=0');
        return Url::build('Blog/read',['id'=>5,'uid'=>10]);
```

也可以使用助手函数url直接来设置

```php
url('Blog/read',['id'=>5]);
```

也可以使用普通的地址来设置url

```php
Url::build('Blog/read?id=5');
```

也可以使用和路由规则配对的方式设置url

```php
Url::build('/read/5');
```

5.在app.php可以默认html后缀，也可以 在方法第三个参数设置

```php
url('Blog/edit',['id'=>5],'shtml')
```

使用#name，可以生成一个带锚点的url

```php
url('Blog/edit#name',['id'=>5])
```

6.使用Url::root('/index.php')在URL前面加上一个index.php

```php
Url::root('/index.php');
```

但这个添加需要整体考虑路径是否支持或正确，否则无法访问

在本身有index.php的时候，使用Url::root('/')隐藏

## 请求对象和信息

### 1、请求对象

1.当控制器继承了控制器基类，自动被注入Request请求对象的功能

```php
namespace app\index\controller;

use think\Controller;

class Rely extends Controller
{
    public function index()
    {
        return $this->request->param('name');
    }
}
```

Request请求对象拥有一个param方法，传入参数name，可以得到相应的值

2.如果不继承控制器基类，可以自行注入Request对象，依赖注入

```php
use think\Request;

class Rely
{
    public function index(Request $request)
    {
        return $request->param('name');
    }
}
```

3.还可以通过构造方法进行注入，通过构造注入，就不需要每个方法都注入一遍

```php
use think\Request;

class Rely
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        return $this->request->param('name');
    }
}
```

4.使用Facade方式应用于没有进行依赖注入时使用Request对象的场合

```php
<?php
namespace app\index\controller;

use think\facade\Request;

class Rely 
{
    public function index()
    {
        return Request::param('name');
    }
}
```

5.使用助手函数request()方法也可以应用在没有依赖注入的场合

```php
public function index()
{
    return request()->param('name');
}
```

### 2、请求信息

1.Request对象除了param方法外，还有一些请求的固定信息，如表：

| 方法          | 含义                                   |
| :------------ | :------------------------------------- |
| `host`        | 当前访问域名或者IP                     |
| `scheme`      | 当前访问协议                           |
| `port`        | 当前访问的端口                         |
| `remotePort`  | 当前请求的REMOTE_PORT                  |
| `protocol`    | 当前请求的SERVER_PROTOCOL              |
| `contentType` | 当前请求的CONTENT_TYPE                 |
| `domain`      | 当前包含协议的域名                     |
| `subDomain`   | 当前访问的子域名                       |
| `panDomain`   | 当前访问的泛域名                       |
| `rootDomain`  | 当前访问的根域名（`V5.1.6+`）          |
| `url`         | 当前完整URL                            |
| `baseUrl`     | 当前URL（不含QUERY_STRING）            |
| `query`       | 当前请求的QUERY_STRING参数             |
| `baseFile`    | 当前执行的文件                         |
| `root`        | URL访问根地址                          |
| `rootUrl`     | URL访问根目录                          |
| `pathinfo`    | 当前请求URL的pathinfo信息（含URL后缀） |
| `path`        | 请求URL的pathinfo信息(不含URL后缀)     |
| `ext`         | 当前URL的访问后缀                      |
| `time`        | 获取当前请求的时间                     |
| `type`        | 当前请求的资源类型                     |
| `method`      | 当前请求类型                           |

2.上表的调用方法，直接调用即可，无须传入值，只有极个别如果传入true获取完整URL的功能

```php
use think\facade\Request;
// 获取完整URL地址 不带域名
Request::url();
// 获取完整URL地址 包含域名
Request::url(true);
// 获取当前URL（不含QUERY_STRING） 不带域名
Request::baseFile();
// 获取当前URL（不含QUERY_STRING） 包含域名
Request::baseFile(true);
// 获取URL访问根地址 不带域名
Request::root();
// 获取URL访问根地址 包含域名
Request::root(true);
```

注意`domain`方法的值本身就包含协议和域名

## 请求变量

### 1、请求变量

1.Request对象支持全局的检测、获取和安全过滤看，支持`$_GET`、`$_POST`...等

为了方便演示，都使用Facade的静态调用模式

```php
<?php
namespace app\index\controller;

use think\facade\Request;

class Rely 
{
    public function index()
    {
        dump(Request::has('id', 'get'));
        dump(Request::has('username', 'post'));

    }
```

2.Request支持的所有变量类型方法，如下表：

| 方法    | 描述                           |
| :------ | :----------------------------- |
| param   | 获取当前请求的变量             |
| get     | 获取 $_GET 变量                |
| post    | 获取 $_POST 变量               |
| put     | 获取 PUT 变量                  |
| delete  | 获取 DELETE 变量               |
| session | 获取 $_SESSION 变量            |
| cookie  | 获取 $_COOKIE 变量             |
| request | 获取 $_REQUEST 变量            |
| server  | 获取 $_SERVER 变量             |
| env     | 获取 $_ENV 变量                |
| route   | 获取 路由（包括PATHINFO） 变量 |
| file    | 获取 $_FILES 变量              |

3.param()变量方法是自动识别GET、POST等的当前请求，推荐使用

```php
//获取请求为name的值，过滤
dump(Request::param('name'));
//获取所有的请求变量，以数组形式，过滤
dump(Request::param());
//获取所有请求的变量(原始变量)，不包含上传变量，不过滤
dump(Request::param(false));
//获取所有请求的变量，包含上传变量，过滤
dump(Request::param(true));
```

4.如果使用依赖注入的方式，可以将变量作为对象的属性进行调用

```php
public function read(\think\Request $request)
{
    return $request->name;
}
```

5.如果采用的是路由URL，也可以获取到变量，但param::get()不支持路由变量

```php
public function edit($id)
{
    dump(Request::param());
    dump(Request::route());	// 路由请求不支持 get 变量
    dump(Request::get());	// get 变量不支持路由请求
}
```

```php
Route::get('edit/:id', 'Rely/edit');
```

6.注意：除了::server()和::env()方法外，其它方法传递的变量名区分大小写

因为::server()和::env()属于系统变量，会强制转换为大写后获取值

7.如果获取不到值，支持请求的变量设置一个默认值

```php
dump(Request::param('name', 'nodata'));
```

8.d对于变量的过滤，在全局设置一个过滤函数，也可以打死你都对某个变量过滤

```php
// 默认全局过滤方法 用逗号分隔多个
'default_filter'         => 'htmlspecialchars',
```

```php
Request::param('name','','htmlspecialchars');
Request::param('name','','strtoupper);
```

9.使用only()方法，可以获取指定的变量，也可以设置默认值

```php
dump(Request::only('id,name'));
dump(Request::only(['id','name']));
dump(Request::only(['id'=>1,'name'=>'nodeta']));
```

使用only()方法，默认param变量，可以在第二参数设置GET、POST等

```php
dump(Request::only(['id','name'], 'post'));
```

10.相反的except()方法，就是排除指定的变量

```php
dump(Request::except('id,name'));
dump(Request::except(['id','name'])); 
dump(Request::except(['id'=>1,'name'=>'nodata'])); 
dump(Request::except(['id','name'], 'post'));
```

11.使用变量修饰符，可以将参数强制转换成指定的类型

/s(字符串)、/d(整型)、/b(布尔)、/a(数组)、/f(浮点)

```php
Request::param('id/d');
```

### 2、助手函数

1.为了简化操作，Request对象提供了助手函数

```php
        //判断get下的id是否存在
        dump(input('?get.id'));
        //判断post下的name是否存在
        dump(input('?post.name'));
        //获取param下的name值
        dump(input('param.name'));
        //默认值
        dump(input('param.name', 'nodate'));
        //过滤值
        dump(input('param.name','','htmlspecialchars'));
        //设置强制转化
        dump(input('param.id/d'));
```

```php
http://127.0.0.1:8000/index/rely?id=1&name=1
```

## 请求类型和HTTP头信息

### 1、请求类型

1.有时需要判断Request的请求类型，比如GET、POST等

可以使用method()方法判断当前请求类型

| 用途                | 方法                 |
| :------------------ | :------------------- |
| 获取当前请求类型    | method               |
| 判断是否GET请求     | isGet                |
| 判断是否POST请求    | isPost               |
| 判断是否PUT请求     | isPut                |
| 判断是否DELETE请求  | isDelete             |
| 判断是否AJAX请求    | isAjax               |
| 判断是否PJAX请求    | isPjax               |
| 判断是否为JSON请求  | isJson（`V5.1.38+`） |
| 判断是否手机访问    | isMobile             |
| 判断是否HEAD请求    | isHead               |
| 判断是否PATCH请求   | isPatch              |
| 判断是否OPTIONS请求 | isOptions            |
| 判断是否为CLI执行   | isCli                |
| 判断是否为CGI模式   | isCgi                |

3.使用普通表单提交，通过method()方法获取类型

```php
<form action="http://localhost/tp5.1/public/index/rely" method="post">
   <input type="text" name="name" value="Lee">
   <input type="submit" value="提交">
</form>
```

```php
return Request::method();
```

4.在表单提交时，也可以设置请求类型伪装，设置隐藏字段__method

而在判断请求，使用method(true)可以获取原始请求，否则获取伪装请求

```php
<input type="hidden" name="_method" value="PUT">
```

```php
return Request::method(true);
```

5.如果想更改请求伪装变量类型的名称，可以在app.php中更改

```php
// 表单请求类型伪装变量
'var_method'             => '_method',
```

6.AJAX/PJAX伪装，使用`?_ajax=1`和`?_pjax=1`，并使用isAjax()和isPjax()

http://127.0.0.1:8000/index/rely?_ajax=1

```php
dump(Request::isAjax());
```

这里需要用isAjax()和isPjax()来判断，用method无法判断是否为a(p)jax;

在app.php也可以更改ajax和pjax的名称

```php
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
```

### 2、HTTP头信息

1.使用header()方法可以输出HTTP头信息，返回的数组类型，也可以单信息获取

```php
dump(Request::header());
dump(Request::header('host'));
```

## 伪静态.参数绑定.请求缓存

### 1、伪静态

1.先使用Url::build()方法获取当前的url路径，得到默认的后缀为.html

```php
use think\facade\Url;
```

```php
public function url()
{
    return Url::build();
}
```

2.可以通过app.php修改伪静态的后缀，比如修改成shtml、xml等

```php
// URL伪静态后缀
'url_html_suffix'        => 'xml',
```

如果地址栏用后缀访问成功后，可以使用Request::ext()方法得到当前伪静态

```php
        return Request::ext();
```

3.配置文件伪静态后缀，可以支持多个，用竖线隔开，访问时不在区间内则报错

```php
// URL伪静态后缀
'url_html_suffix'        => 'shtml|xml|pdf',
```

4.直接将伪静态配置文件设置为false，则关闭伪静态功能

```php
// URL伪静态后缀
'url_html_suffix'        => 'false',
```

### 2、参数绑定

1.参数绑定功能：即URL地址栏的数据传参

```php
public function get($id)
{
    return 'get:'.$id;
}
```

操作方法URL：/get，而带上id参数后，则为：/get/id/5

如果缺少/5或者缺少了/id/5，则会报错方法参数错误：id

那么解决方案，就是给$id = 0一个默认值，防止URL参数错误

```php
public function get($id = 0)
{
    return 'get:'.$id;
}
```

2.如果设置了两个参数，那么参数传递的执行顺序可以设置，比如

```php
public function get($id,$name)
{
    return 'get:'.$id.','.$name;
}
```

不管是：/id/5/name/lee，还是：/name/lee/id/5，都不会产生错误

但如果你在app.php中设置了，必须按照顺序去传递参数，则需要严格

```php
// URL参数方式 0 按名称成对解析 1 按顺序解析
'url_param_type' => 1,
```

/get/5/lee		//不需要再传递id和name，直接按顺序传值即可

### 3、请求缓存

1.请求缓存仅对GET请求有效，并设置有效期

可以设置全局请求缓存，在app.php中设置

```php
'request_cache' => true,
'request_cache_expire' => 3600,
```

当第二访问时，会自动获取请求缓存的数据响应输出，并发送304状态码

2.如果要对路由设置一条缓存，直接cache(3600)方法

```php
Route::get('edit/:id', 'Rely/edit')->cache(3600);
```

## 响应重定向和文件下载

### 1、响应操作

1.响应输出，包括return、json()和view()

2.return默认会输出html格式，配置文件默认设定的default_return_true

而背后是response对象，可以用response()输出达到相同的效果

```php
        $data = 'hello world';
        return response($data);
```

3.使用response()方法可以设置第而参数，状态码，或调用code()方法

```php
            return response($data,201);
            return response($data)->code(202);
```

4.使用json()、view()方法和response()返回的数据类型不同，效果一样

```php
			return json($data,201);
			return josn($data)->code(202);
```

5.不但可以设置状态码，还可以设置header()头文件信息

```php
            return json($data)->code(202)->header(['Cache-control' => 'no-cache,must-revalidate']);
```

### 2、重定向

1.使用redirect()方法可以实现页面重定向，需要return执行

```php
        return redirect('http://www.baidu.com');
```

2.站内重定向，直接输入路由地址或相对地址即可，需要用顶级域名，二级会错误

```php
        return redirect('edit/5');
```

```php
Route::get('edit/:id', 'index/Rely/edit');
```

```php
        return redirect('/index/address/details/id/5');
```

```php
http://127.0.0.1:8000/index/rely/rdc
```

3.也可以通过params()方法传递数组键值对的方式，进行跳转

```php
        return redirect('/index/address/details')->params(['id'=>5]);
        return redirect('/index/address/details',['id'=>5]);
```

### 3、文件下载

1.文件下载和图片下载都使用download()方法即可，路径为实际路径

```php
return \download('image.jpg','my');

$data = '这是一个测试文件';
return \download($data,'text.txt',true);
```

## 容器和依赖注入

### 1、依赖注入

1.依赖注入其实本质是指读对类的依赖通过构造器完成自动注入，例如在控制器架构方法和操作方法中一旦对参数进行对象类型约束则会自动触发依赖注入，由于访问控制器的参数都来自于URL请求，普通变量就是通过参数绑定自动获取，对象变量则通过依赖注入生成。

2.了解依赖注入的写法，创建一个模型

```php
<?php
namespace app\index\model;
use think\Model;

class One extends Model
{
    public $name = 'Mr lee';
}
```

3.创建一个控制器Inject，通过依赖注入将模型One对象引入其内

```php
<?php
namespace app\index\controller;
use app\index\model\One;

class Inject
{
    protected $one;
    public function __construct(One $one)
    {
        $this->one = $one;
    }
    public function index()
    {
        return $this->one->name;
    }
}
```

4.依赖注入：即允许通过类的方法传递对象的能力，并且限制了对象的类型(约束)，而传递的对象背后那个类被自动绑定并且实例化了，这就是依赖注入

### 2、容器

1.依赖注入的类统一由容器管理的，大多数情况下是自动绑定和自动实例化的

如果想手动完成绑定和实例化，可以使用bind()和app()助手函数来实现

```php
public function index()
{
    bind('one', 'app\index\model\One');
    return app('one')->name;
}
```

bind('one','...)绑定类库标识，这个标识具有唯一性，以便快捷调用

app('one')快速调用，并自动实例化对象，标识严格保持一致包含大小写

2.自动实例化对象的方式，是采用单例模式实现，如果想重新实例化一个对象，则

```php
$one = app('one', true);
return $one->name;
```

3当然，也可以直接通过app()绑定一个类到容器中并自动实例化

```php
return app('app\index\model\One')->name;
```

使用bind([])可以实现批量绑定，只不过系统有专门提供批量绑定的文件

```php
bind([
    'one'   =>  'app\index\model\One',
    'user'   =>  'app\index\model\User',
]);
return app('one')->name;

bind([
    'one'   =>  \app\index\model\One::class,
    'user'   =>  \app\index\model\User::class,
]);
return app('one')->name;
```

::class模式，不需要单引号，而需要在最前面加上\，之前的加不加都行

4.系统提供了provider.php文件，用于批量绑定类到容器中，这里不加不报错

```php
return [
    'one'   =>  \app\index\model\One::class,
    'user'   =>  \app\index\model\User::class,
];
```

5.

```php
return app('request')->param('name');
```

会发现和Request::param()兄啊过一样，也就是说，实现同一个效果可以由容器的 bind()和 app()实现，也可以使用依赖 注入实现，还有 Facade(下节课重点探讨)实现，以及助手函数实现

6.系统内置绑定到容器中的类库包括

| 系统类库       | 容器绑定标识 |
| :------------- | :----------- |
| think\Build    | build        |
| think\Cache    | cache        |
| think\Config   | config       |
| think\Cookie   | cookie       |
| think\Debug    | debug        |
| think\Env      | env          |
| think\Hook     | hook         |
| think\Lang     | lang         |
| think\Log      | log          |
| think\Request  | request      |
| think\Response | response     |
| think\Route    | route        |
| think\Session  | session      |
| think\Url      | url          |
| think\Validate | validate     |
| think\View     | view         |

## Facade

### 1、创建静态调用

1.Facade，即门面设计模式，为容器的类提供了一种静态的调用方式

2.引入静Facade类库，并且通过静态调用，比如请求Request::?，路由Route::?，数据库Db::?等，都来自Facade

3.手动创建一个静态调用类库，来了解流程

首先，在应用目录下创建common公共类库文件，并创建Test.php

```php
<?php
namespace app\common;

class Test
{
    public function hello($name)
    {
        return 'Hello,'.$name;
    }
}
```

在同一目录下创建facade文件夹，并创建Test.php，用于生成静态调用

```php
use app\facade\Test;
```

```php
return Test::hello('Mr.lee!');
```

4.除了在getFacadeClass()方法显示绑定，也可以在应用公共函数文件`application/common.php`进行绑定

绑定后，就不需要getFacadeClass()方法了，还可以进行批量统一绑定

```php
// 应用公共文件
use think\Facade;
Facade::bind('app\facade\Test', 'app\common\Test');
```

```php
//批量绑定
Facade::bind([
    'app\facade\Test', 'app\common\Test',
]);
```

### 2、核心类库

系统给内置的常用类库定义了`Facade`类库，包括：

| （动态）类库     | Facade类                |
| :--------------- | :---------------------- |
| think\App        | think\facade\App        |
| think\Build      | think\facade\Build      |
| think\Cache      | think\facade\Cache      |
| think\Config     | think\facade\Config     |
| think\Cookie     | think\facade\Cookie     |
| think\Debug      | think\facade\Debug      |
| think\Env        | think\facade\Env        |
| think\Hook       | think\facade\Hook       |
| think\Lang       | think\facade\Lang       |
| think\Log        | think\facade\Log        |
| think\Middleware | think\facade\Middleware |
| think\Request    | think\facade\Request    |
| think\Response   | think\facade\Response   |
| think\Route      | think\facade\Route      |
| think\Session    | think\facade\Session    |
| think\Url        | think\facade\Url        |
| think\Validate   | think\facade\Validate   |
| think\View       | think\facade\View       |

为了更加方便的使用系统类库，系统还给这些常用的核心类库的`Facade`类注册了类库别名，当进行静态调用的时候可以直接使用简化的别名进行调用。

| 别名类     | 对应Facade类            |
| :--------- | :---------------------- |
| App        | think\facade\App        |
| Build      | think\facade\Build      |
| Cache      | think\facade\Cache      |
| Config     | think\facade\Config     |
| Cookie     | think\facade\Cookie     |
| Db         | think\Db                |
| Debug      | think\facade\Debug      |
| Env        | think\facade\Env        |
| Hook       | think\facade\Hook       |
| Lang       | think\facade\Lang       |
| Log        | think\facade\Log        |
| Middleware | think\facade\Middleware |
| Request    | think\facade\Request    |
| Response   | think\facade\Response   |
| Route      | think\facade\Route      |
| Session    | think\facade\Session    |
| Url        | think\facade\Url        |
| Validate   | think\facade\Validate   |
| View       | think\facade\View       |

## 钩子和行为

### 1、概念理解

1.钩子和行为在6.0的版本被废弃，用事件来取代

虽说用事件来取代，不过意思是一样的

2.什么是行为，就是系统执行的流程中执行的一个动作

比如，当执行到路由时，对路由的设置进行一系列的检测，这种就叫行为

而钩子又是什么？可以理解为行为执行的那个位置点，触发点

系统架构里用了很多这种方式实现框架程序

### 2、小实例

1.在应用目录下创建一个behavior文件夹，用于存放行为类，比如Test.php

```php
<?php
namespace app\behavior;

class Test
{
    public function run($params)
    {
        echo $params . '，只要触发，我就执行';
    }
}
```

行为类创建好之后，设置一个入口方法run()，run()方法只要钩子被触发就执行

比如，将行为注册到tags.php里应用初始化的数组(app_init);

```php
// 应用初始化
'app_init'     => [
    'app\behavior\Test'
],
```

也可以自定一个钩子，然后注册到tags.php中，执行后触发

```php
use think\facade\Hook;
```

```php
public function bhv()
{
    //钩子
    Hook::listen('eat', '吃饭');
}
```

```php
//自定义
'eat'          => [
    'app\behavior\Test',
],
```

2.让初始化对应的是初始化行为，自定义对应自定义的行为

app_init对应的方法是appInit(有下划线的大写)，而自定义eat就是eat

```php
<?php
namespace app\behavior;

class Test
{
    public function appInit()
    {
        echo '初始化的行为被触发！';
    }
    public function eat($params)
    {
        echo $params.'的行为被触发！';
    }
}
```

3.系统核心设计提供了一些可能会需要的钩子（位置），尽可能的方便应用的扩展而不必改动框架核心，按照执行顺序依次如下：

| 钩子            | 描述                | 参数                                       |
| :-------------- | :------------------ | :----------------------------------------- |
| `app_init`      | 应用初始化标签位    | 无                                         |
| `app_dispatch`  | 应用调度标签位      | 无                                         |
| `app_begin`     | 应用开始标签位      | 无                                         |
| `module_init`   | 模块初始化标签位    | 无                                         |
| `action_begin`  | 控制器开始标签位    | 当前的callback参数                         |
| `view_filter`   | 视图输出过滤标签位  | 当前模板渲染输出内容                       |
| `app_end`       | 应用结束标签位      | 当前响应对象实例                           |
| `log_write`     | 日志write方法标签位 | 当前写入的日志信息                         |
| `log_level`     | 日志写入标签位      | 包含日志类型和日志信息的数组（`V5.1.25+`） |
| `response_send` | 响应发送标签位      | 当前响应对象                               |
| `response_end`  | 输出结束标签位      | 当前响应对象实例                           |

## 中间件

### 1、定义中间件

1.中间件和钩子有点类型，它主要用于拦截和过滤HTTP请求，并进行相应处理

这些请求的功能可以是URL重定向、权限验证等

2.定义一个基础的中间件，可以通过命令行模式，在应用目录下生成一个中间件文件和文件夹

```
php think make:middleware Check
```

具体路径为：application/http/middleware/Check.php

```php
<?php
namespace app\http\middleware;

use think\Request;

class Check
{
    public function handle(Request $request, \Closure $next)
    {
        if($request->param('name')=='index'){
            return redirect('/');
        }
        return $next($request);
    }
}
```

然后将这个中间件进行注册，在应用目录下创建middleware.php中间件配置

```php
<?php
return [
    app\http\middleware\Check::class
];
```

中间件的入口执行方法必须是：handle()，第一参数请求，第二参数是闭包

业务代码判断请求的name如果等于index，就拦截住，不能执行，跳转到首页

但如果请求的name是lee，那需要继续往下执行才行，不会被拦截，那么就需要$next($request)把这个请求去调用回调函数

中间件handle()方法规定需要返回response对象，才能正常使用。而$next($requeset)，研读源码追踪发现，它就是返回的response对象

为了测试拦截后，无法继续执行，可以return response()助手函数测试

### 2、前/后置中间件

1.一个简单的中间件，它拦截HTTP验证请求匹配后跳转，这种将$next($request)放在方法底部的方式，属于前置中间件

2.前置中间件就是请求阶段来进行拦截验证，不如登陆判断、跳转、权限等

3.而后置中间件就是请求完毕之后再进行验证，比如写入日志等

```php
public function handle(Request $request, \Closure $next)
{
	//中间件代码，前置
    return $next($request);
}
```

```php
public function handle(Request $request, \Closure $next)
{
	$response = $next($request);
	//中间件代码，后置
    return $response;
}
```

### 3、路由中间件

1.创建一个给路由使用的中间件，判断路由的ID值实现相应的验证

```php
<?php
namespace app\http\middleware;

use think\Request;

class Auth
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->param('id') == 10)
        {
            echo '是管理员，提供后台权限并跳转操作';
        }
        return $next($request);
    }
}
```

2.如果将Auth中间件注册到middleware.php中，就变成公有中间件了

```php
    app\http\middleware\Auth::class
```

3.路由方法提供了一个middleware()方法，让指定的路由采用指定的中间件

```php
Route::rule('read/:id', 'Inject/read')->middleware('Auth');
```

4.middleware()方法，除了传类名，还可以是命名空间的两种形式，都支持

```php
Route::rule('read/:id', 'Inject/read')->middleware('app\http\middleware\Auth');
Route::rule('read/:id', 'Inject/read')->middleware(app\http\middleware\Auth::class)
```

5.一个路由规则，如果要注册多个中间件，可以用数组绑定

```php
Route::rule('read/:id', 'Inject/read')->middleware(['Auth', 'Check']);
```

也支持分组路由，闭包里路由等

```php
Route::group('read',function(){
    Route::rule(':id', 'Inject/read');
})->middleware('Auth');

Route::rule('read/:id','Inject/read')->middleware(function(Request $request, \Closure $next){
    if ($request->param('id') == 10)
    {
        echo '是管理员，提供后台权限并跳转操作';
    }
    return $next($request);
});
```

6.中间件handler()方法的第三个参数，可以路由进行设置

```php
Route::rule('read/:id', 'Inject/read')->middleware('Auth:abc');
```

```php
<?php
namespace app\http\middleware;

use think\Request;

class Auth
{
    public function handle(Request $request, \Closure $next,$name)
    {
        echo $name;
        if ($request->param('id') == 10)
        {
            echo '是管理员，提供后台权限并跳转操作!';
        }
        return $next($request);
    }
}
```

7.再定义全局中间件绑定的时候，如果想传入参数，可以设置为数组模式

```php
[app\http\middleware\Auth::class,'hello']
'Auth',
'Auth:hello'
```

### 4、控制器中间件

1.可以让中间件再控制器里注册，控制器必须继承Controller基类

```php
class Inject extends Controller
{
    protected $middleware = ['Auth'];
```

2.默认情况下，控制器中间件对所有操做方法有效，支持做限制

```php
protected $middleware = [
    'Auth'  =>  ['only'   =>  ['index','test']],
    'Check' =>  ['except' =>  ['bhv','read']]
];
```

3.中间件给控制器传递参数，通过Request对象实现

```php
$request->name = 'Mr.lee';
```

```php
    public function index(Request $request)
    {
        return $request->name;
        return \think\facade\Request::param('name');
    }
```