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

```
Container::get('app')->bind('index')->run()->send(); 
```

此时，URL调用就变成了：public/index/index，访问的是index模块

> http://serverName/index.php/控制器/操作/[参数名/参数值...]

7.如果你的应用特别简单，只有一个模块，一个控制器，那改写追加的方法：

```
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

```
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

```
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

        $data = array('a'=>1,'b'=>2,'c'=>3);
        return json($data);
可以更改配置文件config/app.php默认输出类型为：json

        // 默认输出类型
        'default_return_type'    => 'json',
一般情况下，正常页面都是html输出。

3.使用view()函数输出模板，开启错误提示，可知道创建模板的默认路径

```
return view();
```

4，控制器基类Controller中的initialize()方法会在调用控制器方法之前执行；

```
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

```
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

```
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

```
    // 访问的方法不存在时,可以使用_empty()拦截
    public function _empty($name)
    {
        return '不存在该方法'.$name;
    }
```

2.当访问一个不存在控制器时，系统也会报错，可以使用Error来拦截；

```
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

```
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

```
<?php
namespace app\index\model;
use think\Model;

class User extends Model
{

}
```

3.当创建了User模型，控制端可以直接用User模型对象调用表名；

```
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

```
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

### 2、更多方式查询

```
        // TinkPHP提供助手函数db查询数据
        $data = \db('user')->select();

        // 通过valuse()方法可以查询指定字段的值（单个），没有数据返回null
        $data = Db::name('user')->where('id',27)->value('username');

        // 通过column()方法可以查询指定字段的值（多个），没有数据返回null
        $data = Db::name('user')->column('username');

        // 指定id作为列值的索引
        $data = Db::name('user')->column('username','id');
```

