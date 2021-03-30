<?php

namespace app\index\controller;

use think\facade\Cache;

class Redis
{
    public function index()
    {
        // Cache::init([]);
        // Cache::set('user', 'Mr.lee',10);
        // Cache::set('age', '150',10);
        // echo Cache::get('age');
        // echo Cache::has('user');
        // Cache::inc('num');
        // echo Cache::get('user');
        // Cache::rm('num');
        // echo Cache::pull('user');
        // Cache::clear();
        // Cache::tag('tag',['user', 'age']);
        // Cache::clear('tag');

        cache('user','Mr.lee');
        echo cache('user');
        cache('user',null);
    }
}
