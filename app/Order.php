<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Request;

class Order extends Model
{
	
	protected $table = 'orders';
	
	protected $primaryKey = 'id';
	
	private $user_id;
    private $room_id;
    private $admin_id;
    private $brief_desc;
    private $inte_desc;
    private $start_time;
    private $end_time;
    private $type;
    private $status;
    private $repeat_type;
    private $stop_repeat_time;
    private $skip_same;

    private function getInfo()
    {
        return Request::all();
    }
	
	private function judgeTime()
	{
		$exists = $this
            ->where('start_time','>=',$this->start_time)
            ->where('end_time','<=',$this->end_time);
        if($exists)
            return true;
        else
            return false;
	}
	
	private function saveOrder()
	{
		switch ($this->repeat_type)
		{
			//no reputation
			case 0:{
                if($this->judgeTime())
                {
                    return $this->save()?
                        ['status'=>1,'order_id'=>$this->order_id]:
                        ['status'=>0,'msg'=>'db insert failed'];
                }
                else
                    return ['status'=>0,'msg'=>'time conflict'];
				break;
			}
			//each day
			case 1:{
				$endTime = Carbon::parse($this->stop_repeat_time);
				do
				{
                    if($this->judgeTime())
                    {
                        $beginTime = Carbon::parse($this->start_time);
                        $temTime = Carbon::parse($this->end_time);
                        if(!$this->save()) return ['status'=>0,'msg'=>'db insert failed'];

                        $beginTime->addDays(1);
                        $temTime->addDays(1);
                        $this->start_time = $beginTime->toDateTimeString();
                        $this->end_time = $temTime->toDateTimeString();
                    }
                    else
                        return ['status'=>0,'msg'=>'time conflict'];
				}while($beginTime->lt($endTime));
				
				return ['status'=>1];
			}
			//each week
			case 2:{
				$endTime = Carbon::parse($this->stop_repeat_time);
				do
				{
				    if($this->judgeTime())
                    {
                        $beginTime = Carbon::parse($this->start_time);
                        $temTime = Carbon::parse($this->end_time);
                        if(!$this->save()) return ['status'=>0,'msg'=>'db insert failed'];

                        $beginTime->addWeeks(1);
                        $temTime->addWeeks(1);
                        $this->start_time = $beginTime->toDateTimeString();
                        $this->end_time = $temTime->toDateTimeString();
                    }
					else
					    return ['status'=>0,'msg'=>'time conflict'];
				}while($beginTime->lt($endTime));
				
				return ['status'=>1];
				break;
			}
			//each month
			case 3:{
				$endTime = Carbon::parse($this->stop_repeat_time);
				do
				{
                    if($this->judgeTime())
                    {
                        $beginTime = Carbon::parse($this->start_time);
                        $temTime = Carbon::parse($this->end_time);
                        if(!$this->save()) return ['status'=>0,'msg'=>'db insert failed'];

                        $beginTime->addMonths(1);
                        $temTime->addMonths(1);
                        $this->start_time = $beginTime->toDateTimeString();
                        $this->end_time = $temTime->toDateTimeString();
                    }
					else
                        return ['status'=>0,'msg'=>'time conflict'];
				}while($beginTime->lt($endTime));
			
				return ['status'=>1];
				break;
			}
			//each year
			case 4:{
				$endTime = Carbon::parse($this->stop_repeat_time);
				do
				{
                    if($this->judgeTime())
                    {
                        $beginTime = Carbon::parse($this->start_time);
                        $temTime = Carbon::parse($this->end_time);
                        if(!$this->save()) return ['status'=>0,'msg'=>'db insert failed'];

                        $beginTime->addYears(1);
                        $temTime->addYears(1);
                        $this->start_time = $beginTime->toDateTimeString();
                        $this->end_time = $temTime->toDateTimeString();
                    }
					else
                        return ['status'=>0,'msg'=>'time conflict'];
				}while($beginTime->lt($endTime));
					
				return ['status'=>1];
				break;
			}
		}
        return ['status'=>0,'msg'=>'repeat_type required'];
	}
	
    public function newOrder()
    {
        /*验证用户是否登录*/
        if(!user_insert()->is_logged_in())
        {
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

        $this->user_id = $user_id;
        $this->admin_id = $admin_id;
        $this->room_id = $room_id;
        $this->brief_desc = $brief_desc;
        $this->inte_desc = $inte_desc;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->type = $type;
        $this->status = $status;
        $this->stop_repeat_time = $stop_repeat_time;
        $this->repeat_type = $repeat_type;
        
        return $this->saveOrder();
    }
    
    public function updateOrder()
    {
    	/*验证用户是否登录*/
    	if(!user_insert()->is_logged_in())
    	{
    		return ['status'=>0,'msg'=>'login required'];
    	}
    	
    	$user_id = rq('user_id');
    	if(!$user_id)
    		return ['status'=>0,'msg'=>'user_id is required'];
    	 
    	$user = $this->find($user_id);
    	if(!$user)
    		return ['status'=>0,'msg'=>'user not exists'];
    	
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
    	
    	if($user_id)
    		$user->user_id = $user_id;
    	if($admin_id)
    		$user->admin_id = $admin_id;
    	if($room_id)
    		$user->room_id = $room_id;
    	if($brief_desc)
    		$user->brief_desc = $brief_desc;
    	if($inte_desc)
    		$user->inte_desc = $inte_desc;
    	if($start_time)
    		$user->start_time = $start_time;
    	if($end_time)
    		$user->end_time = $end_time;
    	if($type)
    		$user->type = $type;
    	if($status)
    		$user->status = $status;
    	if($repeat_type)
    		$user->repeat_type = $repeat_type;
    	if($stop_repeat_time)
    		$user->stop_repeat_time = $stop_repeat_time;
    	if($skip_same)
    		$user->skip_same = $skip_same;
    	
    	return $user->save()?
    	['status'=>1,'order_id'=>$user->order_id]:
    	['status'=>0,'msg'=>'db insert failed'];
    }
    
    public function deleteOrder()
    {
    	if(!user_insert()->is_logged_in())
    	{
    		return ['status'=>0,'msg'=>'login required'];
    	}
    	 
    	$id = rq('id');
    	if(!$id)
    		return ['status'=>0,'msg'=>'order_id is required'];
    	
    	$order = $this->find($id);
    	if(!$order)
    		return ['status'=>0,'msg'=>'order not exists'];
    	 
    	return $order->delete()?
    	['status'=>1]:
    	['status'=>0,'msg'=>'db delete failed'];
    }

}
