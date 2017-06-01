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
<div class="title"><h2>发送邮件</h2></div>
<form action="/index.php/Admin/Email/sendEmail" method="POST" enctype="multipart/form-data" id="myForm" >
<div class="main">
    <p class="short-input ue-clear">
    	<label>主题：</label>
        <input type="text" name="title" placeholder="邮件标题" />
    </p>
    <p class="short-input ue-clear">
        <label>收件人：</label>
        <input type="text" name="addressee_name" autocomplete="off" />
        <input type="hidden" name="addressee_id" />
        <div id="box" style="border: 1px solid #8f8f8f;width: 260px;height: 100px;margin-left: 113px;position: absolute;background: white;display: none;">

        </div>
    </p>
    <p class="short-input ue-clear">
        <label>附件：</label>
        <input type="file" name="myfile"  placeholder="上传文件" />
    </p>
    <p class="short-input ue-clear">
        <label>正文：</label>
        <textarea placeholder="请输入内容" id="content" name="content"></textarea>
    </p>
</div>
<div class="btn ue-clear">
     <input type="submit" class="confirm" value="发送"/>
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
//搜索框ajax事件
$("input[name='addressee_name']").unbind().bind('keyup',function(){
    var me = this;
    var key = $(me).val();
    if($.trim(key) == ''){
        $('#box').hide();
    }
    if($.trim(key) != ''){
        $.ajax({
            type:'post',
            url:"/index.php/Admin/User/ajaxGetUsers",
            data:{key:key},
            success:function(data){
                var userInfo = data.msg;
                $('#box').empty().show();
                if(userInfo.length == 0){
                    $('#box').hide();
                }
                if(data.code == 1){
                    var son = '<ul>';
                    $.each(userInfo,function(k,v){
                        son += '<li class="myli" user_id="'+v.id+'">'+ v.username + '<li>';
                    });
                    son += '</ul>';
                    $('#box').append(son);
                }
                //给div里面的li添加鼠标和点击事件
                $('.myli').unbind().bind({mouseover:function(){
                    $(this).css('background','gray');
                },click:function(){
                    var username = $(this).text();
                    var addressee_id = $(this).attr('user_id');
                    $(me).val(username);
                    $("input[name='addressee_id']").val(addressee_id);
                    $('#box').hide();
                },mouseout:function(){
                    $(this).css('background','white');
                }});
            },
            error:function(data){
                alert('数据获取失败');
            }
        });
    }
});
//点击页面任何地方时候隐藏下面的div
$(document).bind('click',function(){
    $('#box').hide();
});

$('form').submit(function(){
    var flag = true;
    var key = $("input[name='addressee_name']").val();
    if($.trim(key) != ''){
        $.ajax({
            url:'/index.php/Admin/Email/ajaxDebug',
            type:'post',
            async:false,
            data:{username:key},
            success:function(data){
                console.log(data);
                if(data.code == 0){
                    alert('没有这个用户');
                    flag = false;
                }else{
                    var id = data.id;
                    $("input[name='addressee_id']").val(id);
                    flag = true;
                }
            },
            error:function(data){

            }
        });
    }
    if(flag){
        return true;
    }else{
        return false;
    }

})

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