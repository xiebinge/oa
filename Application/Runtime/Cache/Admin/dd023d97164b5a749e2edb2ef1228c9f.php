<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Admin/css/base.css" />
	<link rel="stylesheet" href="/Public/Admin/css/login.css" />
	<title>移动办公自动化系统</title>
    <style>
        img{
            width: 80px;
            margin-right: -12px;
            height: 40px;
        }
    </style>
</head>
<body>
	<div id="container">
		<div id="bd">
			<div class="login1">
            	<div class="login-top"><h1 class="logo"></h1></div>
                <div class="login-input">
                	<p class="user ue-clear">
                    	<label>用户名</label>
                        <input type="text" id="user_name" />
                    </p>
                    <p class="password ue-clear">
                    	<label>密&nbsp;&nbsp;&nbsp;码</label>
                        <input type="text" id="user_pwword" name="pwword" />
                    </p>
                    <p class="yzm ue-clear">
                    	<label>验证码</label>
                        <input name="code" id="code" type="text" />
                        <cite><img  class="verify_code" src="<?php echo U('Admin/user/verify');?>"></cite>
                    </p>
                </div>
                <div class="login-btn ue-clear">
                	<a href="javascript:void(0);" class="btn">登录</a>
                    <div class="remember ue-clear">
                        <input type="checkbox" name="remember"  id="remember" />
                        <em></em>
                        <label for="remember">记住密码</label>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <div id="ft">CopyRight&nbsp;2014&nbsp;&nbsp;版权所有&nbsp;&nbsp;uimaker.com专注于ui设计&nbsp;&nbsp;苏ICP备09003079号</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript">
//点击刷新验证码
$('.verify_code').click(function(){
    $(this).attr('src',"/index.php/Admin/User/verify?v="+new Date().getTime());
});

//登录
$('a[class="btn"]').bind('click',function(){
    var me = this;
    var username = $('#user_name').val()||'';
    var password = $('#user_pwword').val()||'';
    var code = $('#code').val()||'';
    var remember = $('#remember').val()||'';
    //验证数据的合法性
    if(username.length ==0 || password.length ==0 || code.length !=3 ){
        alert('数据输入有误！');
        return false;
    }
    $.ajax({
        url:'/index.php/Admin/User/login',
        type:'POST',
        data:{username:username,password:password,code:code,remember:remember},
        success:function(data){
            if(data.code == 1){
                alert(data.msg);
                window.location.href = "<?php echo U('Admin/Index/index');?>"
            }else{
                alert(data.msg);
            }
        },
        error:function(data){
            alert('失败');
        }
    });
});

//单击键盘登录
$(document).bind('keyup',function(event){
    if(event.keyCode == '13' ){
        $('a[class="btn"]').click();
    }
});


var height = $(window).height();
$("#container").height(height);
$("#bd").css("padding-top",height/2 - $("#bd").height()/2);

$(window).resize(function(){
	var height = $(window).height();
	$("#bd").css("padding-top",$(window).height()/2 - $("#bd").height()/2);
	$("#container").height(height);
	
});

$('#remember').focus(function(){
    $(this).blur();
});

$('#remember').click(function(e) {
    checkRemember($(this));
});

function checkRemember($this){
    if(!-[1,]){
        if($this.prop("checked")){
            $this.parent().addClass('checked');
        }else{
            $this.parent().removeClass('checked');
        }
    }
}

</script>
</html>