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
<div class="title"><h2>添加职员</h2></div>
<form action="/index.php/Admin/User/add" method="post" id="myForm">
<div class="main">
    <p class="short-input ue-clear">
    	<label>姓名：</label>
        <input name="name" type="text" placeholder="姓名" />
    </p>
	<p class="short-input ue-clear">
    	<label>真名：</label>
        <input name="nickname" type="text" placeholder="真名" />
    </p>
    <div class="short-input select ue-clear">
    	<label>上级部门：</label>
        <select name="sjid">
        	<option value="-1">请选择</option>
			    <?php if(is_array($dept)): $i = 0; $__LIST__ = $dept;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['id']); ?>"><?php echo (str_repeat("--",$vo["level"])); echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
	<p class="short-input ue-clear">
    	<label>性别：</label>
    	<input name="usersex" type="radio" style="float:none;" value="0" checked='checked' />男
		<input name="usersex" type="radio" style="float:none;" value="1" />女
    </p>
	<p class="short-input ue-clear">
    	<label>生日：</label>
        <input name="userbirthday" type="text" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" />
    </p>
	<p class="short-input ue-clear">
    	<label>联系电话：</label>
        <input type="text" name="usertel" placeholder="联系电话" />
    </p>
	<p class="short-input ue-clear">
    	<label>邮箱：</label>
        <input type="text" name="useremail" placeholder="电子邮箱" />
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