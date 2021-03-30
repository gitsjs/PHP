<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use app\common\validate\User;
use think\Request;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

//Route::get('details/:id', 'index/Address/details');
//Route::rule('details/:id', 'index/Address/details','GET');
//Route::rule('details/:id', 'index/Address/details','POST');
//Route::rule('details/:id', 'index/Address/details','GET|POST');
//Route::get('/', 'index');

//静态路由
//Route::get('ad', 'address/index');
//静态动态结合的地址
//Route::get('detailsss/:id','address/details');
//多参数静态动态结合的地址
//Route::get('search/:id/:uid', 'address/search');
//全动态地址，不限制是否search固定
//Route::get(':search/:id/:uid', 'address/search');
//包含可选参数的地址
//Route::get('find/:id/[:content]', 'address/find');
//规则完全匹配 的地址
//Route::get('search/:id/:uid$', 'address/search');

//Route::get('url','address/url')->name('det');

//将details方法里的id传值，严格限制必须只能是数字\d+
//Route::get('details/:id', 'address/details')->name('det')->pattern('id', '\d+');
//也可以设置search方法中两个值的规则，通过数组的方式传递参数
//Route::get('search/:id/:uid','address/search')->pattern([
//    'id'=>'\d+',
//    'uid'=>'\d+'
//]);

//全局变量规则
//Route::pattern([
//    'id'=>'\d+',
//    'uid'=>'\d+'
//]);
//也支持使用组合的规则方式，实现路由规则
//Route::get('details-</id>', 'address/details')->pattern('id', '\d+');
//动态组合的拼装，地址和参数如果都是模糊动态的，可以使用如下方法
//Route::get('details-:name-:id', 'Hello_:name/det')->pattren('id', '\d+');

//闭包也支持传递参数和动态规则
//Route::get('hello/:name',function($name){
//    return 'Hello,'.$name;
//});

//支持多级路由
//Route::get('details/:id', 'index/group.Address/details');

//支持动态路由地址以及额外参数地址
//Route::get('details/:id', 'index/Address/details?flag=1&status=1');

//普通方法调用
//Route::get('details/:id', 'app\index\controller\Address@details');
//静态方法调用
//Route::get('static/:id', 'app\index\controller\Address@static');

//Route::get('details/:id', 'http://www.baidu.com/details/:id')->status(302);
//Route::redirect('details/:id', 'http://www.baidu.com/details/:id')->status(302);

//检测URL后缀
//Route::get('details/:id', 'address/details', ['ext' => 'html']);
//第三数组参数也可以作为对象的方法存在
//Route::get('details/:id', 'address/details')->ext('html');

//denyExt参数作用是进制某些后缀
//Route::get('details/:id','address/details')->denyExt('gif|jpg|png');

//filter参数作用是对额外参数进行检测
//Route::get('details/:id','address/details')->filter('id',5);

//model参数作用是绑定定模型，第三个参数设置false避免异常，也可以多参数
//Route::get('user/:id', 'address/getUser')->model('id', 'app\index\model\User');
//Route::get('user/:id', 'address/getUser')->model('id', 'app\index\model\User',false);
//Route::get('user/:id', 'address/getUser')->model('id&name', 'app\index\model\User');

//option参数作用是全局的路由进行配置，且可以多次调用
//Route::option('ext','html')->option('https',true);

//快捷路由可以快速给控制器注册路由，还可以给不同的请求类型设置前缀
//Route::get('short', 'Short/getInfo');

//使用group()方法来进行分组路由的注册
//Route::group('col',[
//    ':id'    =>  'Collect/read',
//    ':name'  =>  'Collect/who'
//])->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);

//使用group()方法，并采用闭包的形式进行注册
//Route::group('col',function(){
//    Route::get(':id', 'Collect/read');
//    Route::get(':name', 'Collect/who');
//})->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);

//使用prefix()方法，简化路径的地址
//Route::group('col',function(){
//    Route::get(':id', 'read');
////    Route::get(':name', 'who');
//    Route::miss('miss');
//})->prefix('Collect/')->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$']);

//使用append()方法，可以额外传入参数，用request获取
//Route::group('col',function(){
//    Route::get(':id', 'Collect/read');
//    Route::get(':name', 'Collect/who');
//})->ext('html')->pattern(['id'=>'\d+$','name'=>'\w+$'])->append(['flag'=>1]);

//全局MISS，类似开启强制路由功能
//Route::miss('public/miss');

//绑定路由到index模块
//Route::bind('admin');
//绑定路由到User控制器
//Route::bind('admin/User');
//绑定路由到read操作
//Route::bind('admin/User/read');

//给admin模块下的User控制器创建别名：user
//Route::alias('user', 'admin/User');
//直接绑定到类，来实现相同的效果
//Route::alias('user', '\app\admin\controller\User');
//支持别名设置限定条件，比如ext等
//Route::alias('user', 'admin/User',['ext'=>'html']);
//Route::alias('user', 'admin/User')->ext('html');

//资源路由
//Route::resource('blog','index/blog');
//默认的参数采用id名称，想用别的名称，比如：blog_id
//Route::resource('blog','index/blog')->vars(['blog'=>'blog_id']);
//也可以通过olny()方法限定系统提供的资源方法
//Route::resource('blog','index/blog')->only(['index','save','create']);
//还可以通过except()方法排除系统提供的资源方法
//Route::resource('blog','index/blog')->excpt(['read','delete','update']);
//使用嵌套资源路由，可以让上级资源对下级资源进行操作
//Route::resource('blog.comment', 'index/Comment');

//Route::get('bc','Blog/create');
//Route::get('bl/bc','Blog/create');
//Route::get('read/:id','Blog/read');

//Route::get('edit/:id', 'Rely/edit');

//对路由设置一条缓存，直接cache(3600)方法
//Route::get('edit/:id', 'Rely/edit')->cache(3600);
// Route::get('edit/:id', 'index/Rely/edit');

//middleware()方法，让指定的路由采用指定的中间件
//Route::rule('read/:id', 'Inject/read')->middleware('Auth');
//Route::rule('read/:id', 'Inject/read')->middleware('app\http\middleware\Auth');
//Route::rule('read/:id', 'Inject/read')->middleware(app\http\middleware\Auth::class);

//如果要注册多个中间件，可以用数组绑定
//Route::rule('read/:id', 'Inject/read')->middleware(['Auth', 'Check']);
//也支持分组路由，闭包路由
//Route::group('read',function(){
//    Route::rule(':id', 'Inject/read');
//})->middleware('Auth');
//
//Route::rule('read/:id','Inject/read')->middleware(function(Request $request, \Closure $next){
//    if ($request->param('id') == 10)
//    {
//        echo '是管理员，提供后台权限并跳转操作';
//    }
//    return $next($request);
//});

//Route::rule('read/:id', 'Inject/read')->middleware('Auth:abc');

// Route::get('read/:id','Verify/read')->validate(\app\common\validate\User::class,'edit');
// Route::get('read/:id','Verify/read')->validate([
//     'id' => 'number|between:1,10',
//     'email' => \think\validate\ValidateRule::isEmail()
//     ],'edit',[
//         'id.between' => 'id限定在1-10之间',
//         'email'      => '邮箱格式错误'
//     ],true);

return [

];
