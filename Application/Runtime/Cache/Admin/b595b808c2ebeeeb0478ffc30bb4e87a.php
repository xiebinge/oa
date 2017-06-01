<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/jquery.dialog.css" />
<link rel="stylesheet" href="/Public/Admin/css/index.css" />
<link rel="stylesheet" href="/Public/Admin/css/font-awesome.min.css" />
<link rel="stylesheet" href="/Public/Admin/css/lobibox.min.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div id="container">
  <div id="hd">
    <div class="hd-wrap ue-clear">
      <div class="top-light"></div>
      <h1 class="logo"></h1>
      <div class="login-info ue-clear">
        <div class="welcome ue-clear"><span>欢迎您,</span><a href="javascript:;" class="user-name"><?php echo (session('session_user_name')); ?></a></div>
        <div class="login-msg ue-clear"> <a href="javascript:;" class="msg-txt">消息</a> <a href="javascript:;" id="msg-num" class="msg-num"><?php echo ($noRead); ?></a> </div>
      </div>
      <div class="toolbar ue-clear"> <a href="/index.php/Admin/Index/home" target="iframe" class="home-btn">首页</a> <a href="javascript:;" class="quit-btn exit"></a> </div>
    </div>
  </div>
  <div id="bd">
    <div class="wrap ue-clear">
      <div class="sidebar">
        <h2 class="sidebar-header">
          <p>功能导航</p>
        </h2>
        <ul class="nav">
        <li class="nav-info current">
        <div class="nav-header"><a href="javascript:;" date-src="/index.php/Admin/Index/home" class="ue-clear"><span>日常办公</span><i class="icon"></i></a></div>
      </li>
        <?php if(is_array($level1)): $i = 0; $__LIST__ = $level1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] != 1): ?><li class="nav-info">
                    <div class="nav-header"><a href="javascript:;" class="ue-clear"><span><?php echo ($vo['name']); ?></span><i class="icon"></i></a></div>
                    <ul class="subnav">
                    <?php if(is_array($level2)): $i = 0; $__LIST__ = $level2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['pid'] == $vo['id']): ?><li><a href="javascript:;" date-src="/index.php/Admin/<?php echo ($v['c_name']); ?>/<?php echo ($v['a_name']); ?>"><?php echo ($v['name']); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      <div class="content">
        <iframe src="/index.php/Admin/Index/home" name="iframe" id="iframe" width="100%" height="100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div id="ft" class="ue-clear">
    <div class="ft-left"> <span>中国移动</span> <em>Office&nbsp;System</em> </div>
    <div class="ft-right"> <span>Automation</span> <em>V2.0&nbsp;2014</em> </div>
  </div>
</div>
<div class="exitDialog">
  <div class="dialog-content">
    <div class="ui-dialog-icon"></div>
    <div class="ui-dialog-text">
      <p class="dialog-content">你确定要退出系统？</p>
      <p class="tips">如果是请点击“确定”，否则点“取消”</p>
      <div class="buttons">
        <input type="button" class="button long2 ok" value="确定" />
        <input type="button" class="button long2 normal" value="取消" />
      </div>
    </div>
  </div>
</div>

</body>
<script type="text/javascript">
    setInterval(function(){
        var oldMsg = $('#msg-num').html();
        $.ajax({
            url:"/index.php/Admin/Index/ajax_Mail_Notifier",
            type:'post',
            data:{old_msg:oldMsg},
            success:function(data){
                //console.log(data);
                if(data.code == 'newNum'){
                    // 新邮件提醒
                    var newEmail = data.newEmail;
                    Lobibox.notify('info', {
                        size: 'mini',
                        title: '您有新邮件',
                        msg: '<a href="/index.php/Admin/Email/index" target="iframe">新邮件有'+ newEmail +'封</a>'
                    });
                    $('#msg-num').empty().html(parseInt(oldMsg)+parseInt(newEmail));

                }else if(data.code == 'noRead'){
                    //最新未读邮件
                    $('#msg-num').empty().html(data.no_read);
                }
            },
            error:function(){
                alert('fail');
            }
        });
    },60*1000*10)
</script>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/core.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.dialog.js"></script>
<script type="text/javascript" src="/Public/Admin/js/index.js"></script>
<script type="text/javascript" src="/Public/Admin/js/lobibox.js"></script>
</html>