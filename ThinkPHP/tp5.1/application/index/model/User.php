<?php

namespace app\index\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    public function profile()
    {
        // hasOne表示一对一关联，参数一表示附表，参数二附表外键，默认user_id，参数三主表的主键id
        // return $this->hasOne('Profile','user_id','id');

        // 一对多查询
        // return $this->hasMany('Profile', 'user_id', 'id');
    }

    public function book()
    {
        // hasOne表示一对一关联，参数一表示附表，参数二附表外键，默认user_id，参数三主表的主键id
        // return $this->hasOne('Book','user_id','id');

        // 一对多查询
        // return $this->hasMany('Profile', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('Role','Access','role_id','user_id');
    }



















    // 设置uid为主键
    // protected $pk = 'uid';

    // 设置其他的数据表
    // protected $table = 'tp_one';

    // 模型自动时间戳 只想设置某一个模型开启，需要设置特有字段
    // protected $autoWriteTimestamp = true;
    // protected $autoWriteTimestamp = 'datetime';

    // 模型中可以设置只读字段
    // protected $readonly = ['username', 'email'];

    // 模型类型转换 设置类型转换的字段属性，属性值为数值
    // protected $type = [
    //     'price'         =>  'integer',
    //     'status'        =>  'boolean',
    //     'create_time'   =>  'datetime:Y-m-d'
    // ];

    // 模型数据完成 auto表示新增和修改操作，insert只表示新增，update只表示修改
    // protected $atuo   = ['email'];
    // protected $insert = ['uid' => 1];
    // protected $update = [];

    // 模型json 对于本身不是json字段，想要写入json字段的字符字段，需要设置
    // protected $json = ['details', 'list'];

    // 模型端设置软删除的功能，引入softDelete,它是trait
    // use SoftDelete;
    // protected $deleteTime = 'delete_time';

    // delete_time默认设置是Null，如果想更改这个默认值，可以设置
    // protected $defaultSoftDelete = 0;

    // 全局范围查询
    // protected function base($query)
    // {
    //     $query->where('status', 1);
    // }

    // 模型初始化，必须设置static静态方法
    protected static function init()
    {
        // 第一次实例化的时候执行init
        // echo '初始化User模型';
        // self::event('before_update',function($query){
        //     echo '准备开始更新数据';
        // });
        // self::event('after_update',function($query){
        //     echo '数据更新完毕';
        // });
    }

    // 如果在模型内部获取数据，请不要用$this->username
    public function getUserName()
    {
        // return self::where('username', '李白')->find()->getAttr('username');
    }

    // 模型获取器
    public function getStatusAttr($value)
    {
        // $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        // return $status[$value];
    }

    // 除了getFieldAttr中Field可以是字段值，也可以是自定义的虚拟字段
    public function getNothingAttr($value, $data)
    {
        // $getStatus = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        // return $getStatus[$data['status']];
    }

    // 模型修改器 设置一个新增，规定邮箱的英文都必须大写
    public function setEmailAttr($value)
    {
        // return strtoupper($value);
    }

    // 模型搜索器 封装一个邮箱字段查询，然后封装一个时间限定查询
    // public function searchEmailAttr($query, $value)
    // {
    //     $query->where('email', 'like', $value . '%');
    // }
    public function searchCreateTimeAttr($query, $value)
    {
        // $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }

    // 在搜索器添加一个可以排序的功能
    public function searchEmailAttr($query, $value, $data)
    {
        // $query->where('email', 'like', $value . '%');
        // if (isset($data['sort'])) {
        //     $query->order($data['sort']);
        // }
    }
    // 模型查询范围 封装一个筛选所有性别为男的查询，并且只显示部分字段5条 前缀scope，后缀随意，调用时直接把后缀作为参数使用
    public function scopeGenderMale($query)
    {
        // $query->where('gender', '男')->field('id, username, gender, email')->limit(5);
    }

    // 模型查询范围 实现多个查询封装方法连缀调用，比如找出邮箱xia并大于80分的
    public function scopeEmailLike($query, $value)
    {
        // $query->where('email', 'like', '%' . $value . '%');
    }
    public function scopePriceGreater($query, $value)
    {
        // $query->where('price', '>', 80);
    }
}
