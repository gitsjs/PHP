<?php


namespace app\index\controller;


class HelloWorld
{
    public function index()
    {
        return 'Hello world!';
    }
    public function det($id)
    {
        return 'det的id是'.$id;
    }
}