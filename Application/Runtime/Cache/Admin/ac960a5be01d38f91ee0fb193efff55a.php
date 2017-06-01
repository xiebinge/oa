<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
    <style>
        #name-error{
            color: red;
            width: 135px;
        }
        #sort-error{
            color: red;
            width: 136px;
        }
        #add_time-error{
            color: red;
        }
        #intro-error{
            float: right;
            color: red;
            margin-right: 580px;
            width: 124px;
        }

    </style>
</head>

<body>
<div class="title"><h2>信息登记</h2></div>
<form action="/index.php/Admin/Dept/add" method="POST" id="myForm" >
<div class="main">
    <p class="short-input ue-clear">
    	<label>部门名称：</label>
        <input type="text" name="name" placeholder="部门名称" />
    </p>
    <div class="short-input select ue-clear">
    	<label>上级部门：</label>
        <div class="select-wrap">
        	<!-- <div class="select-title ue-clear"><span>平件</span><i class="icon"></i></div>
            <ul class="select-list">
            	<li>平件</li>
                <li>保密</li>
                <li>高级保密</li>
            </ul> -->
			 <select name="pid" style=" width: 262px; height: 32px;" class="select-title ue-clear"  id="">
                <?php if(empty($data)): ?><option value="0">顶级部门</option>
                <?php else: ?>
                    <option value="0">顶级部门</option>
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo (str_repeat("--",$vo["level"])); echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </select>
        </div>
    </div>
    <p class="short-input ue-clear">
        <label>排序：</label>
        <input type="text" name="sort" placeholder="排序" />
    </p>
    <p class="short-input ue-clear">
    	<label>添加时间：</label>
        <input type="text" name="add_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" />
    </p>
    <p class="short-input ue-clear">
    	<label>备注：</label>
        <textarea placeholder="请输入内容" name="intro"></textarea>
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
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/Public/Admin/laydate/laydate.js"></script>
<script type="text/javascript">
//表单验证规则
$('#myForm').validate({
    rules:
    {
        name:{required:true,maxlength:10},
        sort:{required:true,digits:true},
        add_time:{required:true,dateISO:true},
        intro:{required:true}

    },
    messages:
    {
        name: {required: "请输入部门名称！", maxlength: "用户名不能大于10个字符！"},
        sort: {required: "请输入排序号，例如50。",digits:"必须是整数！"},
        add_time: {required: "必填项目！",dateISO: "请输入正确的时间格式！"},
        intro: {required: "请输入部门介绍！"}
    }
});

showRemind('input[type=text], textarea','placeholder');
</script>
</html>