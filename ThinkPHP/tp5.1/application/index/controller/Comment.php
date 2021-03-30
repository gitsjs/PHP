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