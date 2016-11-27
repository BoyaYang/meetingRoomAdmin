<?php

namespace App;

use Hash;
use Illuminate\Database\Eloquent\Model;
//use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
//use App\Http\Requests\Request;
use Request;

class User extends Model
{

	protected $table = 'users';
	
	protected $primaryKey = 'id';
	
	//protected Request $request;
	
	public function getInfo()
	{
		return Request::all();//only('username','password','phone','email','auth');
	}
	
	public function getAuthenticatedUser()
	{
		
		try {
			$user = JWTAuth::parseToken()->authenticate();
			if (!$user) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}
	
		// the token is valid and we have found the user via the sub claim
		return true;//response()->json($user);
	}
	
    public function register()
    {
        /*$username = rq('username');
        $password = rq('password');
        $phone = rq('phone');
        $email = rq('email');
        $auth = rq('auth');*/
    	
    	$userInfo = $this->getInfo();
    	
        if(!$userInfo['username'])
            return response()->json(['status'=>0,'msg'=>'username required']);
        if(!$userInfo['password'])
            return response()->json(['status'=>0,'msg'=>'password required']);
        if(!$userInfo['phone'])
            return response()->json(['status'=>0,'msg'=>'phone_number required']);
        if(!$userInfo['email'])
            return response()->json(['status'=>0,'msg'=>'email required']);
        if(!$userInfo['auth'])
        	return response()->json(['status'=>0,'msg'=>'auth required']);
        $user_exists = $this
            ->where('username',$userInfo['username'])
            ->exists();

        if($user_exists)
            return response()->json(['status'=>0,'msg'=>'username has existed']);

        $hash_password = Hash::make($userInfo['password']);

        $user = $this;
        $user->username = $userInfo['username'];
        $user->password = $hash_password;
        $user->phone = $userInfo['phone'];
        $user->email = $userInfo['email'];
		$user->auth = $userInfo['auth'];
        return $user->save()?
            response()->json(['status'=>1,'user_id'=>$user->id]):
            response()->json(['status'=>0,'msg'=>'db insert failed']);
    }

    public function login()
    {
    	$userInfo = $this->getInfo();
        /*$username = rq('username');
        $password = rq('password');*/
    	
        /*检查用户名和密码是否为空*/

        if(!$userInfo['username'])
        {
            return response()->json(['status'=>0, 'msg'=>'username required']);
        }

        if(!$userInfo['password'])
        {
            return response()->json(['status'=>0, 'msg'=>'password required']);
        }

        /*检查用户是否存在*/
        $user = $this->where('username',$userInfo['username'])->first();//返回数据库的第一条

        if(!$user) 
        {
            return response()->json(['status'=>0, 'msg'=>'user not exists']);
        }

        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if(!Hash::check($userInfo['password'],$hashed_password))
        {
            return response()->json(['status'=>0, 'msg'=>'wrong password']);
        }

        //$credentials = array("username"=>$userInfo['username'],"password"=>$userInfo['password']); 
        //$payload = JWTFactory::make($credentials);
        //$token = JWTAuth::encode($payload);
        $credentials = Request::only('username', 'password');
        $token = JWTAuth::attempt($credentials);
        //try {
        	// attempt to verify the credentials and create a token for the user
        	//if (!$token) {
        	//	return response()->json(['error' => 'invalid_credentials'], 401);
        	//}
        //} catch (JWTException $e) {
        	// something went wrong whilst attempting to encode the token
        	//return response()->json(['error' => 'could_not_create_token'], 500);
        //}
        
        // all good so return the token
        return response()->json($token);
        
        
        /*将用户信息写入session*/
        /*session()->put('username',$user->username);
        session()->put('user_id',$user->user_id);

        return response()->json(['status'=>1, 'user_id'=>$user->user_id]);*/
        //return session()->all();
    }
    
    public function logout()
    {
    	JWTAuth::invalidate(Request::input('token'));
    }

    /*检测用户是否登录*/
    public function is_logged_in()
    {
    	return $this->getAuthenticatedUser();
        /*如果session中存在user_id就返回user_id,否则返回false*/
        //return session('user_id')?true: false;
        //return session()->all();
    }
}
