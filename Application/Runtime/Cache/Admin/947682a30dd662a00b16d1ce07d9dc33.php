<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html charset='utf-8'>
<head>
    <title>权限分配</title>
    <style>
        .mydiv{margin-top: -10px;margin-left: 10px}

        .mydiv ul{list-style:none; margin-bottom: 40px;font-size: 16px}
        .mydiv ul li{list-style: none;  margin-bottom: 0px;  margin-left: 23px;}
        .mydiv ul li input{height: 30px;width: 20px;margin-bottom: 6px;}
        .mydiv ul li .name{margin-left: 20px;color: #0480be;float:left}
    </style>
</head>
<body>
<?php $ids=explode(',',$auth_ids)?>
<div id="content">
    <div class="mydiv">
        <h2>给角色[<span style="color:#ff804a"><?php echo ($role); ?></span>]分配权限: </h2>
            <form action="/index.php/Admin/Role/edit_auth" method="post">
                <input type="hidden" value="<?php echo ($id); ?>" name="role_id">
                <div class="info">
                    <?php if(is_array($level1)): $i = 0; $__LIST__ = $level1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i; if($value['id'] != 1): ?><ul>
                                <input class="pmenu"    type="checkbox" name="ids[]"  value="<?php echo ($value['id']); ?>" <?php if(in_array($value['id'],$ids)){echo "checked='checked'";}?> style="height: 30px;width: 20px;margin-bottom: 6px;" ><span><?php echo ($value['name']); ?></span>
                                <?php if(is_array($level2)): $i = 0; $__LIST__ = $level2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['pid'] == $value['id']): ?><li><span class="name"><input name="ids[]"  class="smenu" <?php if(in_array($vo['id'],$ids)){echo "checked='checked'";}?>   value="<?php echo ($vo['id']); ?>" type="checkbox"  ><?php echo ($vo['name']); ?></span></li>
                                        <?php if(is_array($level3)): $i = 0; $__LIST__ = $level3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['pid'] == $vo['id']): ?><li><span class="name"><input name="ids[]"  class="smenu" <?php if(in_array($v['id'],$ids)){echo "checked='checked'";}?>  value="<?php echo ($v['id']); ?>" type="checkbox"  ><?php echo ($v['name']); ?></span></li><?php endif; endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                            </ul><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    <hr/>
                </div>
                <input type="submit"  value="确定"/>
                <input type="reset" name="chongzhi"  value="重置"/>
            </form>
    </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript">
    //重置
    $('input[name="chongzhi"]').click(function(){
       $('input:checked').attr('checked',false);
    });

    //一级菜单
    $('input[class="pmenu"]').bind('click',function(){
        var me = this;
        if($(me).attr('checked')){
            $(me).parent().find('.smenu').attr('checked',true);
        }else{
            $(me).parent().find('.smenu').attr('checked',false);
        }
    });

    //子级菜单(方法一)
    /*$('.smenu').bind('click',function(){
        var me = this;
        var brother = $(me).parents('ul').find('.smenu');
        var flag = false;
        $.each(brother,function(){
            if($(this).attr('checked')){
                flag = true;
            }
        });

        if(flag){
            $(me).parents('ul').find(".pmenu").attr('checked',true);
        }else{
            $(me).parents('ul').find(".pmenu").attr('checked',false);
        }
    });*/

    //子级菜单(方法二)
    $('.smenu').bind('click',function(){
        var me = this;
        var brother = $(me).parents('ul').find('.smenu:checked').length;
        if(brother){
            $(me).parents('ul').find(".pmenu").attr('checked',true);
        }else{
            $(me).parents('ul').find(".pmenu").attr('checked',false);
        }
    });

</script>

</html>