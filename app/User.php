<?php

namespace App;

use Hash;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function register(){
        $username = rq('username');
        $password = rq('password');
        $phone = rq('phone');
        $email = rq('email');
        if(!$username)
            return ['status'=>0,'msg'=>'username required'];
        if(!$password)
            return ['status'=>0,'msg'=>'password required'];
        if(!$phone)
            return ['status'=>0,'msg'=>'phone_number required'];
        if(!$email)
            return ['status'=>0,'msg'=>'email required'];

        $user_exists = $this
            ->where('username',$username)
            ->exists();

        if($user_exists)
            return ['status'=>0,'msg'=>'username has existed'];

        $hash_password = Hash::make($password);

        $user = $this;
        $user->password = $hash_password;
        $user->username = $username;
        $user->phone = $phone;
        $user->email = $email;

        return $user->save()?
            ['status'=>1,'user_id'=>$user->user_id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function login(){

        $username = rq('username');
        $password = rq('password');
        /*检查用户名和密码是否为空*/

        if(!$username){
            return ['status'=>0, 'msg'=>'username required'];
        }

        if(!$password){
            return ['status'=>0, 'msg'=>'password required'];
        }

        /*检查用户是否存在*/
        $user = $this->where('username',$username)->first();//返回数据库的第一条

        if(!$user) {
            return ['status'=>0, 'msg'=>'user not exists'];
        }

        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return ['status'=>0, 'msg'=>'wrong password'];
        }

        /*将用户信息写入session*/
        session()->put('username',$user->username);
        session()->put('user_id',$user->user_id);

        return ['status'=>1, 'user_id'=>$user->user_id];
        //return session()->all();
    }

    /*检测用户是否登录*/
    public function is_logged_in(){
        /*如果session中存在user_id就返回user_id,否则返回false*/
        return session('user_id')?true: false;
        //return session()->all();
    }
}
