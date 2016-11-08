<!DOCTYPE html>
<html>
<head>
    <title>会议室预订系统——注册新用户</title>
    <meta charset="utf-8">
    <style type="text/css">
        *{
            margin:0 auto;
            padding:0;
        }
        body{
            background-color: #2ca02c
        }
        #body{
            width:500px;
            height:500px;
            background-color: red;
            text-align: center;
            position: relative;
        }
        #title{
            width:500px;
            height:50px;
            position:absolute;
            margin-top:20px;
            font-size: 30px;
            color:#737373;
        }
        #form{
            width:500px;
            height:430px;
            position:absolute;
            margin-top: 70px;
        }
        ul{
            text-align: left;
            list-style: none;
        }
        ul li{
            margin-left:30px;
            margin-bottom: 70px;
        }
        li hr{
            position: absolute;

            width:440px;
        }
        .text{
            margin-bottom: 5px;
            margin-left:8px;
            height:20px;
            width:380px;
            border:0;
            outline:none;
            background-color: red;
            color:white;
            font-size: 18px;
        }

        #button{
            text-align: right;
        }

    </style>
</head>
<body>
    <div id="body">
        <div id="title">注册新用户</div>
        <div id="form">
            <form>
                <ul>
                    <li>用户名<input type="text" id="name" name="name" class="text" /><br /><hr /></li>
                    <li>手机号<input type="text" id="phone" name="phone" class="text" /><br /><hr /></li>
                    <li>密码<input type="text" id="password" name="password" class="text" /><br /><hr /></li>
                    <li>确认密码<input type="text" id="passwordAgain" name="passwordAgain" class="text" /><br /><hr /></li>
                    <li id="button"><input type="button" value="立即注册" /></li>
                </ul>
            </form>
        </div>
    </div>
</body>
</html>