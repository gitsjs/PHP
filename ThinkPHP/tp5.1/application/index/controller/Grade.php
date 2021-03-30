<?php
namespace app\index\controller;
use app\index\Model\User as UserModel;
use app\index\Model\Profile as ProfileModel;

class Grade
{
    public function index()
    {
        // $user = UserModel::get(19);
        // return json($user->profile);
        // return $user->profile->hobby;
        // echo $user->profile->hobby;

        // 关联修改
        // $user = UserModel::get(19);
        // $user->profile->save(['hobby'=>'喜欢大姐姐']);

        // 关联新增
        // $user = UserModel::get(19);
        // $user->profile()->save(['hobby'=>'迷恋小姐姐']);

        // $profile = ProfileModel::get(1);
        // return $profile->user->email;

        // $user = UserModel::hasWhere('Profile',['id'=>1])->find();
        // return $user->email;

        // $user=UserModel::haswhere('Profile',function($query){
        //     $query->where('profile.id',1);
        // })->find();
        // return $user->email;

        // $user = UserModel::get(19);
        // return json($user->profile);
        // return  json($user->profile()->where('id','>',10)->select());

        // $user = UserModel::has('profile','>=',2)->select();
        // return json($user);

        // $user = UserModel::hasWhere('Profile',['status'=>1])->select();
        // return  json($user);

        // $user = UserModel::get(19);
        // $user->profile()->save(['hobby'=>'测试新增']);
        // $user->profile()->saveAll([
        //     ['hobby'=>'测试新增'],
        //     ['hobby'=>'测试新增']
        // ]);

        // $user = UserModel::get(227,'prifile');
        // $user->together('prifile')->delete();

    }
    public function before()
    {
        // $list = UserModel::all([19,20,21]);
        // foreach($list as $user){
        //     dump($user->profile);
        // }
        // 关联预载入
        // $list = UserModel::with('profile')->all([19,20,21]);
        // foreach($list as $user){
        //     dump($user->profile);
        // }
        $list = UserModel::with('profile,book')->all([19,20,21]);
        foreach($list as $user){
            dump($user->profile.$user->book);
        }
    }
    public function count()
    {
        $list = UserModel::withCount('profile')->all([19,20,21]);
        foreach($list as $user){
            echo $user->profile_count.'<br>';
        };

        $list = UserModel::withSum(['profile'=>'ps'],'status')->all([19,20,21]);
        foreach($list as $user){
            echo $user->ps.'<br>';
        }
    }
    public function view()
    {
        $list = UserModel::with('profile')->select();
        return $list->hidden(['username','password','profile.status']);
        return $list->visible(['profile.hobby']);

        return json($list->append(['book.title']));
    }
    public function many()
    {
        // $user = UserModel::get(19);
        // return $user;
        // return json($user->roles);
        $user = UserModel::get(27);
        // $user->roles()->save(['type' => '测试工程师']);

        // $user->roles()->save(1);
        // $user->roles()->attach(2,['details' => '测试']);
        $user->roles()->detach(2);
    }
}