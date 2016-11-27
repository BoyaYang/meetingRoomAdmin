<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
	
	protected $table = 'areas';
	
	protected $primaryKey = 'id';
	
	public function newArea()
	{
		/*验证用户是否登录*/
		if(!user_ins()->is_logged_in())
		{
			return ['status'=>0,'msg'=>'login required'];
		}

		$admin_id = rq('admin_id');
		$area_name = rq('area_name');
		
		if(!$admin_id)
			return ['status'=>0,'msg'=>'admin_id required'];
		if(!$area_name)
			return ['status'=>0,'msg'=>'area_name required'];
		
		$area_exists = $this
		->where('area_name',$area_name)
		->exists();
		
		if($area_exists)
			return ['status'=>0,'msg'=>'area_name has existed'];
		
		$area = $this;
		$area->admin_id = $admin_id;
		$area->area_name = $area_name;
		
		return $area->save()?
		['status'=>1,'area_id'=>$user->area_id]:
		['status'=>0,'msg'=>'db insert failed'];
	}
	
	public function deleteArea()
	{
		if(!user_ins()->is_logged_in())
		{
			return ['status'=>0,'msg'=>'login required'];
		}
		
		$area_id = rq('area_id');
		if(!$area_id)
			return ['status'=>0,'msg'=>'area_id is required'];
		 
		$area = $this->find($area_id);
		if(!$area)
			return ['status'=>0,'msg'=>'area not exists'];
		
		return $area->delete()?
		['status'=>1]:
		['status'=>0,'msg'=>'db delete failed'];
	}
}