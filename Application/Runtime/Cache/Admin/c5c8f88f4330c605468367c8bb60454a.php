<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) url("../images/inputbg.png") repeat-x scroll 0 0;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}

    label.error {
        color: #ff0000;
    }
	
</style>
</head>

<body>
<div class="title"><h2>编辑职员</h2></div>
<form action="/index.php/Admin/User/edit" method="post" id="myForm">
<div class="main">
    <p class="short-input ue-clear">
    	<label>用户名：</label>
        <input name="name" value="<?php echo ($users['username']); ?>" type="text" placeholder="用户名" />
    </p>
    <input type="hidden" name="uid" value="<?php echo ($users['id']); ?>" >
    <p class="short-input ue-clear">
        <label>真名：</label>
        <input name="nickname" value="<?php echo ($users['truename']); ?>" type="text" placeholder="真名" />
    </p>
    <p class="short-input ue-clear">
        <label>新密码：</label>
        <input name="userpassword" type="text" placeholder="密码（可以为空）" />
    </p>
    <p class="short-input ue-clear">
        <label>确认密码：</label>
        <input name="repassword" type="text" placeholder="确认密码（可以为空）" />
    </p>
    <div class="short-input select ue-clear">
    	<label>上级部门：</label>
        <select name="sjid">
        	<option value="-1">请选择</option>
			    <?php if(is_array($dept)): $i = 0; $__LIST__ = $dept;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($users['dept_id'] == $vo['id']): ?><option value="<?php echo ($vo['id']); ?>" selected="selected"><?php echo ($vo['name']); ?></option>
                    <?php else: ?>
                        <option value="<?php echo ($vo['id']); ?>"><?php echo (str_repeat("--",$vo["level"])); echo ($vo['name']); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
	<p class="short-input ue-clear">
    	<label>性别：</label>
    	<input name="usersex" type="radio" style="float:none;" value="0" <?php if($users['sex'] == 0){echo checked ;}?> />男
		<input name="usersex" type="radio" style="float:none;" value="1"  <?php if($users['sex'] == 1){echo checked ;}?> />女
    </p>
	<p class="short-input ue-clear">
    	<label>生日：</label>
        <input name="userbirthday" value="<?php echo (date('Y-m-d',$users['birthday'])); ?>" type="text" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" />
    </p>
	<p class="short-input ue-clear">
    	<label>联系电话：</label>
        <input type="text" value="<?php echo ($users['tel']); ?>" name="usertel" placeholder="联系电话" />
    </p>
	<p class="short-input ue-clear">
    	<label>邮箱：</label>
        <input type="text" value="<?php echo ($users['email']); ?>" name="useremail" placeholder="电子邮箱" />
    </p>
    
</div>
<div class="btn ue-clear">
    <input type="submit" class="confirm" value="确定"/>
    <input type="reset" class="clear" value="清空内容"/>
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/Public/Admin/laydate/laydate.js"></script>
<script type="text/javascript">
    $('#myForm').validate({
        rules:
        {
            name        :{required:true,maxlength:10},
            nickname    :{required:true},
            userbirthday:{required:true},
            usertel     :{required:true,digits:true},
            useremail   :{required:true,email:true}
        },
        messages:
        {
            name        : {required: "必填项！", maxlength: "用户名不能大于10个字符！"},
            nickname    : {required: "必填项！"},
            userbirthday: {required: "必填项！"},
            usertel     : {required: "必填项！",digits:'tel格式不对'},
            useremail   : {required: "必填项！",email:'邮箱格式不对！'}
        }
    });



showRemind('input[type=text], textarea','placeholder');
</script>
</html>