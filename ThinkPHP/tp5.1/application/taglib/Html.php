<?php


namespace app\taglib;

use think\template\TagLib;

class Html extends TagLib
{
    // 定义标签列表
    protected $tags=[
        // 标签定义：attr属性列表 close是否闭合(0或者1，默认1)
        'font'  =>  ['attr'=>'close,size','close'=>1]
    ];
    // 闭合标签
    public function tagFont($tag,$content)
    {
        $parseStr = '<span style="color:'.$tag['color'].';font-size:'.($tag['size']*10).'px">'.$content.'</span>';
            return $parseStr;
    }
}
