# 会议室预订系统API  
## 新建用户
***
- **投递方式**：POST  
- **路径**：/users
- **参数**：{
    "username": "value1", 
    "password": "value2", 
    "phone": "value3",
    "email":"value4",
    "auth":"0"
}

- **回复**：
    - 用户已存在: {
    "status": 0, 
    "msg": "User has exists!"
}
    - 参数缺失:{
    "status":0,
    "msg":"* required"
}
    - 数据库操作失败:{
    "status":0,
    "msg":"db insert fail"
}
    - 用户创建成功: {
    "status": 1, 
    "user_id": (用户信息位于数据库中的id)
}

## 用户登录
***
- **投递方式**：POST  
- **路径**：/users/token
- **参数**：{
    "username": "value1", 
    "password": "value2", 
}

- **回复**：
    - 用户不存在: {
    "status": 0, 
    "msg": "User not exists!"
}
    - 参数缺失:{
    "status":0,
    "msg":"* required"
}
    - 密码错误:{
    "status":0,
    "msg":"password error"
}
    - 用户登陆成功: {
    "status": 1, 
    "user_id": (用户信息位于数据库中的id)
}

## 用户注销
***
- **投递方式**：DELETE  
- **路径**：/users/token
- **参数**：NULL

- **回复**：
    - 注销成功: {
    "status": 1, 
    "msg": "logout success"
}

## 新建区域
***
- **投递方式**：POST  
- **路径**：/areas
- **参数**：{
    "admin_id":"value1",
    "area_name":"value2"
}

- **回复**：
    - 区域已存在: {
    "status": 0, 
    "msg": "area_name has exists!"
}
    - 数据库操作失败:{
    "status":0,
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":0,
    "msg":"* required"
}
    - 区域创建成功: {
    "status": 1, 
    "area_id": (区域信息位于数据库中的id)
}

## 删除区域
***
- **投递方式**：DELETE  
- **路径**：/areas
- **参数**：{
    "id":"value1"
}

- **回复**：
    - 区域不存在: {
    "status":"0", 
    "msg": "area_name not exists!"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 区域删除成功: {
    "status":"1" 
}

## 新增房间
***
- **投递方式**：POST 
- **路径**：/rooms
- **参数**：{
    "admin_id":"value1",
    "area_id":"value2",
    "room_name":"value3",
    "status":"value4",
    "allow_book":"value5",
    "office_time":"value6",
    "closing_time":"value7",
    "time_length":"value8",
    "need_permission":"value9",
    "allow_remind":"value10",
    "allow_private_book":"value11",
    "description":"value12",
    "galleryful":"value13",
    "goods":"value14"
}

- **回复**：
    - 房间已存在: {
    "status":"0", 
    "msg": "room_name has exists!"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 房间创建成功: {
    "status":"1" ,
    "room_id": (房间信息位于数据库中的id)
}

## 获取所有房间信息
***
- **投递方式**：GET
- **路径**：/rooms
- **参数**：{
    "room_id":"value1"
}

- **回复**：
    - 房间不存在: {
    "status":"0", 
    "msg": "room_name not exists!"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 房间信息获取成功: {
    "status":"1" ,
    "data":(房间信息数组)
}

## 删除房间
***
- **投递方式**：DELETE  
- **路径**：/rooms
- **参数**：{
    "id":"value1"
}

- **回复**：
    - 房间不存在: {
    "status":"0", 
    "msg": "room_id not exists!"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 房间删除成功: {
    "status":"1" 
}

## 更新房间
***
- **投递方式**：POST 
- **路径**：/rooms
- **参数**：{
    "admin_id":"value1",
    "area_id":"value2",
    "room_name":"value3",
    "status":"value4",
    "allow_book":"value5",
    "office_time":"value6",
    "closing_time":"value7",
    "time_length":"value8",
    "need_permission":"value9",
    "allow_remind":"value10",
    "allow_private_book":"value11",
    "description":"value12",
    "galleryful":"value13",
    "goods":"value14"
}

- **回复**：
    - 房间不存在: {
    "status":"0", 
    "msg": "room has exists!"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 房间更新成功: {
    "status":"1" ,
    "room_id": (房间信息位于数据库中的id)
}

## 新增预订
***
- **投递方式**：POST 
- **路径**：/orders
- **参数**：{
    "user_id":"value1",
    "room_id":"value2",
    "admin_id":"value3",
    "brief_desc":"value4",
    "inte_desc":"value5",
    "start_time":"value6",
    "end_time":"value7",
    "type":"value8",
    "status":"value9",
    "repeat_type":"value10",
    "stop_repeat_time":"value11",
    "skip_same":"value12"
}

- **回复**：
    - 时间冲突在: {
    "status":"0", 
    "msg": "time conflict"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 预订创建成功: {
    "status":"1"
}

## 删除预订
***
- **投递方式**：DELETE  
- **路径**：/orders
- **参数**：{
    "id":"value1"
}

- **回复**：
    - 房间不存在: {
    "status":"0", 
    "msg": "order_id not exists!"
}
    - 数据库操作失败:{
    "status":"0", 
    "msg":"db insert fail"
}
    - 参数缺失:{
    "status":"0", 
    "msg":"* required"
}
    - 房间删除成功: {
    "status":"1" 
}