<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function order(){
        /*妫�煡鐢ㄦ埛鏄惁鐧诲綍*/
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login required'];
        }

        $user_id = rq('user_id');
        $room_id = rq('room_id');
        $admin_id = rq('admin_id');
        $brief_desc = rq('brief_desc');
        $inte_desc = rq('inte_desc');
        $start_time = rq('start_time');
        $end_time = rq('end_time');
        $type = rq('type');
        $status = rq('status');
        $repeat_type = rq('repeat_type');
        $stop_repeat_time = rq('stop_repeat_time');
        $skip_same = rq('skip_same');

        if(!$admin_id)
            return ['status'=>0,'msg'=>'admin_id required'];
        if(!$room_id)
            return ['status'=>0,'msg'=>'room_id required'];
        if(!$brief_desc)
            return ['status'=>0,'msg'=>'brief_desc required'];
        if(!$inte_desc)
            return ['status'=>0,'msg'=>'inte_desc required'];
        if(!$start_time)
            return ['status'=>0,'msg'=>'start_time required'];
        if(!$end_time)
            return ['status'=>0,'msg'=>'end_time required'];
        if(!$type)
            return ['status'=>0,'msg'=>'type required'];
        if(!$status)
            return ['status'=>0,'msg'=>'status required'];
        if(!$repeat_type)
            return ['status'=>0,'msg'=>'repeat_type required'];
        if(!$stop_repeat_time)
            return ['status'=>0,'msg'=>'stop_repeat_time required'];
        if(!$skip_same)
            return ['status'=>0,'msg'=>'skip_same required'];

        $this->user_id = $user_id;
        $this->admin_id = $admin_id;
        $this->room_id = $room_id;
        $this->brief_desc = $brief_desc;
        $this->inte_desc = $inte_desc;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->type = $type;
        $this->status = $status;
        $this->repeat_type = $repeat_type;
        $this->stop_repeat_time = $stop_repeat_time;
        $this->skip_same = $skip_same;

        return $this->save()?
            ['status'=>1,'order_id'=>$this->order_id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

}
