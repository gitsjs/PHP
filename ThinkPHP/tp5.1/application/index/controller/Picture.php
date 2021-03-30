<?php
namespace app\index\controller;
use think\Image;

class Picture
{
    public function index()
    {
        $image = Image::open('test.png');
        echo $image->width();
        echo $image->height();
        echo $image->type();
        echo $image->mime();
        dump($image->size()) ;
        $image->crop(500,350)->save('crop1.png');
        $image->thumb(500,500)->save('thumb.png');
        $image->rotate(180)->save('rotate.png');
    }
}