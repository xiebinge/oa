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
<div class="title"><h2>添加公文</h2></div>
<form action="/index.php/Admin/Doc/add" method="POST" enctype="multipart/form-data" id="myForm" >
<div class="main">
    <p class="short-input ue-clear">
    	<label>标题：</label>
        <input type="text" name="doc_title" placeholder="标题" />
    </p>
    <p class="short-input ue-clear">
        <label>添加时间：</label>
        <input type="text" name="doc_add_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD  hh:mm:ss'})" />
    </p>
    <p class="short-input ue-clear">
        <label>附件：</label>
        <input type="file" name="myfile" placeholder="上传文件" />
    </p>
    <p class="short-input ue-clear">
        <label>正文：</label>
        <textarea placeholder="请输入内容" id="content" name="doc_content"></textarea>
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
//ckeditor编辑器（未有引入文件）
CKEDITOR.replace( 'ckeditor88',{
    language:'zh-cn',
    width :600,
    height:300,
    toolbar:'Basic',
    toolbarCanCollapse:true
});
//表单验证规则
$('#myForm').validate({
    rules:
    {
        name:{required:true,maxlength:100},
        add_time:{required:true,dateISO:true},
        intro:{required:true}

    },
    messages:
    {
        name: {required: "请输入标题！", maxlength: "标题不能大于100个字符！"},
        add_time: {required: "必填项目！",dateISO: "请输入正确的时间格式！"},
        intro: {required: "请输入部门介绍！"}
    }
});

showRemind('input[type=text], textarea','placeholder');
</script>
</html>