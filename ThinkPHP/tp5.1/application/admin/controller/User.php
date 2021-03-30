<?php


namespace app\admin\controller;


class User
{
    public function index()
    {
        return 'admin index';
    }
    public function read($id)
    {
        return 'admin id:'.$id;
    }
}