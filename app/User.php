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
use Response;
use Cookie;
use Validator;
use Toplan\Sms\Facades\SmsManager;

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

        $this->username = $userInfo['username'];
        $this->password = $hash_password;
        $this->phone = $userInfo['phone'];
        $this->email = $userInfo['email'];
        $this->auth = $userInfo['auth'];
        $this->activeByEmail = 0;
        $this->activeByPhone = 0;
        return $this->getEmailVerf();
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
        return Response::make($token)
            ->withCookie(Cookie::make('token', $token));
        
        /*将用户信息写入session*/
        /*session()->put('username',$user->username);
        session()->put('user_id',$user->user_id);

        return response()->json(['status'=>1, 'user_id'=>$user->user_id]);*/
        //return session()->all();
    }
    
    public function logout()
    {
    	if(!JWTAuth::invalidate(Request::input('token')))
    	    return response()->json(['status'=>0, 'msg'=>'logout error']);
        else
            return response()->json(['status'=>1, 'msg'=>'logout success']);
    }

    /*检测用户是否登录*/
    public function is_logged_in()
    {
    	return $this->getAuthenticatedUser();
        /*如果session中存在user_id就返回user_id,否则返回false*/
        //return session('user_id')?true: false;
        //return session()->all();
    }

    public function getEmailVerification()
    {
        $userInfo = getInfo();
        $now = time();
        $email_address = $userInfo['email'];
        if(!$email_address)
            return response()->json(['status'=>'0','msg'=>'email required']);
        $token = Hash::make($userInfo['username'].$userInfo['email'].$now);
        $this->tokenByEmail = $token;
        $this->tokenByEmail = "";
        /*$db_email = $this->where('email',$email_address)->first();
        if(!$db_email)
        {
            $this->email = $email_address;
            $this->emailVerf = $token;
            if(!$this->save())
                return response()->json(['status'=>'0','msg'=>'db insert failed']);
        }
        else
        {
            $db_email->email = $email_address;
            $db_email->emailVerf = $token;
            if(!$db_email->save())
                return response()->json(['status'=>'0','msg'=>'db insert failed']);
        }*/
        /*Mail::send(['text'=>'view'],$code,function($message){
            $message->from('yangbingyan159@163.com','meetingTest');
            $message->to($this->getInfo()['email']);
        });*/
        $data = ['code'=>$token];
        Mail::send(['text'=>'emailVerf'],$data,function($message)use($email_address)
        {
            $message->from('yangbingyan159@163.com','meetingTest');
            $message->to($email_address)->subject("欢迎注册会议室管理系统");
        });
        return $this->save()?
            response()->json(['status'=>1,'user_id'=>$this->id]):
            response()->json(['status'=>0,'msg'=>'db insert failed']);
    }

    public function checkEmailVerification()
    {
        $token = Request::input('token');
        $email = Request::input('email');
        $user = $this->where('email',$email)->first();
        if(!$user)
            response()->json(['status'=>0, 'msg'=>'email not exists']);
        $hashed_token = $user->tokenByEmail;
        if(!Hash::check($token,$hashed_token))
        {
            return response()->json(['status'=>0, 'msg'=>'wrong token']);
        }
        else
            $user->activeByEmail = 1;

        return $user->save()?
            response()->json(['status'=>1,'user_id'=>$user->id]):
            response()->json(['status'=>0,'msg'=>'db insert failed']);

    }

    public function checkPhoneVerification()
    {
        $validator = Validator::make(Request::all(), [
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            //验证失败后清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return redirect()->back()->withErrors($validator);
        }
    }
}
