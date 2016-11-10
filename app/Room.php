<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function newRoom()
    {
    	if(!user_ins()->is_logged_in())
    	{
    		return ['status'=>0,'msg'=>'login required'];
    	}
    	
    	$admin_id = rq('admin_id');
    	$area_id = rq('area_id');
    	$room_name = rq('room_name');
    	$status = rq('status');
    	$type = rq('type');
    	$allow_book = rq('allow_book');
    	$office_time = rq('office_time');
    	$closing_time = rq('closing_time');
    	$time_length = rq('time_length');
    	$meeting_time = rq('meeting_time');
    	$need_permission = rq('need_permission');
    	$allow_remind = rq('allow_remind');
    	$allow_private_book = rq('allow_private_book');
    	$html = rq('html');
    	$description = rq('description');
    	$galleryful = rq('galleryful');
    	$goods = rq('goods');
    	
    	if(!$admin_id)
    		return ['status'=>0,'msg'=>'admin_id required'];
    	if(!$area_id)
    		return ['status'=>0,'msg'=>'area_id required'];
    	if(!$room_name)
    		return ['status'=>0,'msg'=>'room_name required'];
    	if(!$status)
    		return ['status'=>0,'msg'=>'status required'];
    	if(!$type)
    		return ['status'=>0,'msg'=>'type required'];
    	if(!$allow_book)
    		return ['status'=>0,'msg'=>'allow_book required'];
    	if(!$office_time)
    		return ['status'=>0,'msg'=>'office_time required'];
    	if(!$closing_time)
    		return ['status'=>0,'msg'=>'closing_time required'];
    	if(!$time_length)
    		return ['status'=>0,'msg'=>'time_length required'];
    	if(!$meeting_time)
    		return ['status'=>0,'msg'=>'meeting_time required'];
    	if(!$need_permission)
    		return ['status'=>0,'msg'=>'need_permission required'];
    	if(!$allow_remind)
    		return ['status'=>0,'msg'=>'allow_remind required'];
    	if(!$allow_private_book)
    		return ['status'=>0,'msg'=>'allow_private_book required'];
    	if(!$html)
    		return ['status'=>0,'msg'=>'html required'];
    	if(!$description)
    		return ['status'=>0,'msg'=>'description required'];
    	if(!$galleryful)
    		return ['status'=>0,'msg'=>'galleryful required'];
    	if(!$goods)
    		return ['status'=>0,'msg'=>'goods required'];
    	
    	$this->admin_id = $admin_id;
    	$this->area_id = $area_id;
    	$this->room_name = $room_name;
    	$this->status = $status;
    	$this->type = $type;
    	$this->allow_book = $allow_book;
    	$this->office_time = $office_time;
    	$this->closing_time = $closing_time;
    	$this->time_length = $time_length;
    	$this->meeting_time = $meeting_time;
    	$this->need_permission = $need_permission;
    	$this->allow_remind = $allow_remind;
    	$this->allow_private_book = $allow_private_book;
    	$this->html = $html;
    	$this->description = $description;
    	$this->galleryful = $galleryful;
    	$this->goods = $goods;
    	
    	return $this->save()?
    	['status'=>1,'room_id'=>$this->room_id]:
    	['status'=>0,'msg'=>'db insert failed'];
    	
    }
    
    public function checkRoom()
    {
    	
    }
    
    public function updateRoom()
    {
    	
    }
    
    public function deleteRoom()
    {
    	
    }
    
    
}
