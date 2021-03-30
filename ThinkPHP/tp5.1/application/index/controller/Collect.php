<?php

namespace app\index\controller;

use think\Controller;
use think\facade\Url;

/**
 * Class Collect
 * @package app\index\controller
 * @route('col')
 */
class Collect extends Controller
{
    public function index()
    {
//        return 'index';
//        return Url::build('Blog');
//        return Url::build('Blog/create');
//        return Url::build('Blog/read', 'id=5');
//        return Url::build('Blog/read',['id'=>5]);
//        return Url::build('Blog/read','id=5&uid=0');
//        return Url::build('Blog/read',['id'=>5,'uid'=>10]);

    }

    /**
     * @param $id
     * @return string
     * @route('col/:id','get')
     * ->ext('html')
     * ->pattern(['id'=>'\d+'])
     *
     */
    public function read($id)
    {
        echo $this->request->param('flag');
        return 'read id:'.$id;
    }
    public function who($name)
    {
        return 'your name:'.$name;
    }
    public function miss()
    {
        return 'col 不存在404';
    }
}