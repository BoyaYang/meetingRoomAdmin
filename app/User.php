<?php

namespace App;

use Mail;
use Hash;
use Illuminate\Database\Eloquent\Model;
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
        $username = request_input('username');
        $password = request_input('password');
        $phone = request_input('phone');
        $email = request_input('email');
    	
        if(!$username)
            return response()->json(['status'=>0,'msg'=>'username required']);
        if(!$password)
            return response()->json(['status'=>0,'msg'=>'password required']);
        if(!$phone&&!$email)
            return response()->json(['status'=>0,'msg'=>'phone or email required']);
        $user_exists = $this
            ->where('username',$username)
            ->exists();

        if($user_exists)
            return response()->json(['status'=>0,'msg'=>'username has existed']);

        $hash_password = Hash::make($password);

        $this->username = $username;
        $this->password = $hash_password;
        $this->auth = 'user';
        $this->activeByEmail = 0;
        $this->activeByPhone = 0;

        if(!$email)
        {
            $this->phone = $phone;
            $this->email = "";
            $phone_verification = request_input('phone_verification');
            if(!$phone_verification)
                return response()->json(['status'=>0,'msg'=>'phone verification required']);
            return $this->checkPhoneVerification();
        }

       else
       {
           $this->phone = "";
           $this->email = $email;
           return $this->getEmailVerification();
       }
    }

    public function login()
    {
        $username = request_input('username');
        $password = request_input('password');
    	
        /*检查用户名和密码是否为空*/

        if(!$username)
        {
            return response()->json(['status'=>0, 'msg'=>'username required']);
        }

        if(!$password)
        {
            return response()->json(['status'=>0, 'msg'=>'password required']);
        }

        /*检查用户是否存在*/
        $user = $this->where('username',$username)->first();//返回数据库的第一条

        if(!$user) 
        {
            return response()->json(['status'=>0, 'msg'=>'user not exists']);
        }

        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password))
        {
            return response()->json(['status'=>0, 'msg'=>'account inactive']);
        }

        if(!$user->activeByEmail||!$user->activeByPhone)
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
    }

    public function getEmailVerification()
    {
        $email_address = request_input('email');
        $username = request_input('username');
        $now = time();
        if(!$email_address)
            return response()->json(['status'=>'0','msg'=>'email required']);
        $token = Hash::make($username.$email_address.$now);
        $this->tokenByEmail = $token;
        Mail::send('emailVerf',['token'=>$token,'email'=>$email_address],function($message)use($email_address)
        {
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
            return response()->json(['status'=>0, 'msg'=>'email not exists']);
        $hashed_token = $user->tokenByEmail;
        if($token!=$hashed_token)
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
        else{
            $this->activeByPhone = 1;
            return $this->save()?
                response()->json(['status'=>1,'user_id'=>$this->id]):
                response()->json(['status'=>0,'msg'=>'db insert failed']);
        }
    }
}
