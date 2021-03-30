<?php


namespace app\index\controller\group;
use think\Controller;

class Address extends Controller
{
    public function index()
    {
        return 'index';
    }

    public function details($id)
    {
        return 'group.detalis目前调用的id:'.$id;
    }

    public function search($id,$uid)
    {
        return 'seach目前调用的id'.$id.','.'uid'.$uid;
    }

    public function find($id,$content='')
    {
        return 'find目前调用的id'.$id.','.'content:'.$content;
    }

    public function url()
    {
        //不做标识的做法
        //return url('address/details',['id'=>10]);
        //定义标识的做法
        return url('det', ['id'=>10]);
    }
}