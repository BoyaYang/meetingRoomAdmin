<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Mail;

class Verification extends Model
{
    protected $table = 'verifications';
    protected $primaryKey = 'id';

    public function getInfo()
    {
        return Request::all();
    }
    public function getEmailVerf()
    {
        $email_address = $this->getInfo()['email'];
        if(!$email_address)
            return response()->json(['status'=>'0','msg'=>'email required']);
        $code = rand(100000,999999);
        $db_email = $this->where('email',$email_address)->first();
        if(!$db_email)
        {
            $this->email = $email_address;
            $this->emailVerf = $code;
            if(!$this->save())
                return response()->json(['status'=>'0','msg'=>'db insert failed']);
        }
        else
        {
            $db_email->email = $email_address;
            $db_email->emailVerf = $code;
            if(!$db_email->save())
                return response()->json(['status'=>'0','msg'=>'db insert failed']);
        }
        /*Mail::send(['text'=>'view'],$code,function($message){
            $message->from('yangbingyan159@163.com','meetingTest');
            $message->to($this->getInfo()['email']);
        });*/
        $data = ['code'=>$code];
        Mail::send(['text'=>'view'],$data,function($message)use($db_email)
        {
            $message->from('yangbingyan159@163.com','meetingTest');
            $message->to($db_email->email)->subject("欢迎注册会议室管理系统");
        });
        return response()->json(['status'=>'1','Verification'=>$code]);
    }
}
