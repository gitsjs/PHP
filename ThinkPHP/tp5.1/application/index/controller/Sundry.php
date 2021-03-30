<?php
namespace app\index\controller;

use think\facade\Cookie;
use think\facade\Session;

class Sundry{
    public function index()
    {

    }
    public function sess()
    {
        Session::init([
            'prefix' => 'tp',
            'auto_start' => true
        ]);

        // Session::prefix('tp');
        // Session::set('user','Mr.lee');

        // echo Session::pull('user');

        // Session::clear();
        // Session::clear('tp');

        // Session::delete('user');
        // Session::delete('user','tp');

        // echo Session::get('user');
        // echo $_SESSION['think']['user'];
        // dump(Session::has('user'));
        // dump(Session::get());

        Session::flash('user','Mr.lee');
        // Session::flush();
        Session::clear();
        dump(Session::get());
        echo(Session::get('user'));

        // dump($_SESSION);
    }
    public function cookie()
    {
        // Cookie::prefix('tp_');
        // Cookie::set('name','Mr.lee');
        // Cookie::set('user',[1,2,3]);
        // Cookie::set('user','Mr.lee',3600);
        // Cookie::set('user2','Mr.wang',[
        //     'expire' => 3600,
        //     'prefix' => 'think_'
        // ]);
        // Cookie::forever('user','Mr.zhang');
        // echo Cookie::has('user','think_');
        // echo Cookie::get('user');
        // echo Cookie::get('user2','think_');

        // Cookie::delete('user');
        // Cookie::delete('user2','think_');
        // Cookie::clear('tp_');
    }
}