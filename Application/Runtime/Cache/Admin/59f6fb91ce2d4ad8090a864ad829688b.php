<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
    <style>
        #title-error{
            color: red;
            width: 135px;
        }
        #content-error{
            float: right;
            color: red;
            margin-right: 580px;
            width: 124px;
        }

    </style>
</head>

<body>
<div class="title"><h2>添加知识</h2></div>
<form action="/index.php/Admin/Knowledge/add" method="POST" enctype="multipart/form-data" id="myForm" >
<div class="main">
    <p class="short-input ue-clear">
    	<label>标题：</label>
        <input type="text" name="title" placeholder="标题" />
    </p>
    <p class="short-input ue-clear">
        <label>作者：</label>
        <input type="text" name="author_id" value="<?php echo (session('session_user_name')); ?>" />
    </p>
    <p class="short-input ue-clear">
        <label>附件：</label>
        <input type="file" name="myfile" id="f" placeholder="上传文件" onchange="change()" />
        <p style="padding-left: 114px;">
            <img id="preview"  alt="" width="180" name="pic" />
        </p>
    </p>
    <p class="short-input ue-clear">
        <label>正文：</label>
        <textarea placeholder="请输入内容" id="content" name="content"></textarea>
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
<script type="text/javascript" src="/Public/Admin/js/placeImage.js"></script>
<script type="text/javascript" src="/Public/Admin/editor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="/Public/Admin/editor/lang/zh-CN.js"></script>
<script type="text/javascript">
//kindeditor编辑器
KindEditor.ready(function(k){
    window.editor = k.create('#content',{
        width:'700px',
        height:'320px',
        afterBlur:function(){
            this.sync();
        }
    });
});
//表单验证规则
$('#myForm').validate({
    rules:
    {
        title:{required:true,maxlength:100},
        content:{required:true}

    },
    messages:
    {
        title: {required: "请输入标题！", maxlength: "标题不能大于100个字符！"},
        content: {required: "请输入部门介绍！"}
    }
});

showRemind('input[type=text], textarea','placeholder');
</script>
</html>