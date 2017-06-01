<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<?php if(empty($list)): ?><div class="">对不起，没有数据！</div>
<?php else: ?>
    <div class="table-operate ue-clear">
        <a href="javascript:;" class="add">添加</a>
        <a href="javascript:;" class="del">删除</a>
        <a href="javascript:;" class="edit">编辑</a>
        <a href="javascript:;" class="count">统计</a>
        <a href="javascript:;" class="check">审核</a>
    </div>
    <div class="table-box">
    <table>
        <thead>
        <tr>
            <th class="num">序号</th>
            <th class="name">部门名称</th>
            <th class="process">上级部门</th>
            <th class="node">部门介绍</th>
            <th class="time">添加时间<span>（小时）</span></th>
            <th class="operate">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td class="num"><?php echo ($key+1); ?></td>
                <td class="name"><?php echo ($vo["name"]); ?></td>
                <td class="process">
                    <?php if($vo["p_name"] == null): ?>顶级部门
                    <?php else: ?>
                        <?php echo ($vo["p_name"]); endif; ?>
                </td>
                <td class="node" title="<?php echo ($vo["intro"]); ?>"><?php echo ($vo["intro"]); ?></td>
                <td class="time"><?php echo (date("Y-m-d",$vo["add_time"])); ?></td>
                <td class="operate">
                    <a href="<?php echo U('Admin/Dept/edit',array('id'=>$vo['id']));?>" >编辑</a> |
                    <!--<a href="/index.php/Admin/Dept/del/id/<?php echo ($vo["id"]); ?>" onclick="return confirm('确定要删除吗？')" >删除</a>-->
                    <a href="javascript:void(0)" class="ajax-delete" id="<?php echo ($vo["id"]); ?>" >删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div><?php endif; ?>
<div class="pagination ue-clear" style="float: right"><?php echo ($page); ?></div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.pagination.js"></script>
<script type="text/javascript">
$('.ajax-delete').bind('click',function(){
    //var id = $(this).parent().siblings('.num').text();
    var me = this;
    var id = $(me).attr('id');
    if(confirm('确定要删除吗？')){
        $.ajax({
            type:'POST',
            url:'/index.php/Admin/Dept/ajaxDel',
            data:{id:id},
            dataType:'json',
            success: function(data){
                console.log(data);
                if(data.code == 1){
                    alert(data.msg);
                    //删除当前行<tr>
                    $(me).parents('tr').remove();
                    //思路是 删除后我们是要把行里面的序号重新排列所以要先查看剩下的行数然后再循环这些行重新把序号赋予这些行
                    //查看还剩下多少行
                    var lines = $("tbody tr").length;
                    if(lines > 0){
                        //循环剩下的行
                        $("tbody tr").each(function(k,v){
                            //重新索引
                            $(this).find("td:first-child").html(k+1);
                        });
                    }else{
                       // $("body").empty().append('<div class="title"><h2>信息管理</h2></div> <div class="">对不起，没有数据！</div>');
                        window.location.href="/index.php/Admin/Dept/index";
                    }

                }else{
                    alert(data.msg);
                }
            },
            error:function(data){
                alert('操作失败');
            }
        });
    }
});


$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})


$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>