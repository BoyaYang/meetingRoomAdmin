# 会议室预订系统API  
## Register: http://www.boardroom.com/api/post/users

***
- **投递方式**：POST  
- **投递内容**：{
    "username": "yang", 
    "password": "1234568", 
    "phone": "123456787945", 
}
- **适用范围**：网站和手机
- **类型**：生产环境API
- **返回结果**：
    - 用户已存在时的返回结果: {
    status: 0, 
    msg: "User has exists!"
}
    - 用户创建成功返回结果 {
    status: 1, 
    user_id: (用户信息位于数据库中的id)
}

***

## Login: http://www.boardroom.com/api/post/sessions
***
- **投递方式**：POST  
-  **投递内容**：{
    "username": "yang", 
    "password": "zhao1118"
}
- **适用范围**：网站和手机
- **类型**：生产环境API
- **返回结果**：
    - 用户不存在时的返回结果: {
    status: 0, 
    msg: "user not exists!"
}
    - 密码不正确时的返回结果: {
    status: 0, 
    msg: "wrong password"
}
    - 登陆成功时的返回结果: {
    status: 1, 
    user_id: (用户信息位于数据库中的id)
}
***  


## newOrder:http://www.boardroom.com/api/post/orders
- **投递方式**：POST  

- **投递内容**：{
    "user_id":"yang",
    "room_id":"201",
    "admin_id":"123456",
    "brief_desc": "交流会议", 
    "inte_desc: "10月01日在会议室1开展交流会议，参与会议人数有100人。", 
    "start_time": "2016-10-1 9;00", 
    "stop_time": "2016-10-1 11:00", 
    "type": "1", 
    "status": "1", 
    "repeat_type": "0", 
    "stop_repeat_time": "2016-12-1 6;00", 
    "skip_same": "1"
}
- **适用范围**：网站和手机  
- **类型**：生产环境API  
- **返回结果**：    
    - 预订成功时的返回结果: {
    status: 1, 
    order_id: (预订信息位于数据库中的id)
}
    - 缺少管理员id时的返回结果: {
    status: 0, 
    msg："admin_id required"
}
    - 缺少用户id时的返回结果: {
    status: 0, 
    msg："user_id required"
}
    - 缺少简要说明时的返回结果: {
    status: 0, 
    msg:"brief_desc required"
}
    - 缺少详细说明时的返回结果: {
    status: 0, 
    msg:"inte_desc required"
}
    - 缺少起始时间时的返回结果: {
    status: 0, 
    msg:"start_time required"
}
    - 缺少结束时间时的返回结果: {
    status: 0, 
    msg:"end_time required"
}
    - 缺少类型时的返回结果: {
    status: 0, 
    msg:"type required"
}
    - 缺少确定状态时的返回结果: {
    status: 0, 
    msg:"status required"
}
    - 缺少重复类型时的返回结果: {
    status: 0, 
    msg:"repeat_type required"
}
    - 缺少结束重复日期时的返回结果: {
    status: 0, 
    msg:"stop_repeat_type required"
}

    - 缺少跳过冲突判断时的返回结果: {
    status: 0, 
    msg:"skip_same required"
}


***
