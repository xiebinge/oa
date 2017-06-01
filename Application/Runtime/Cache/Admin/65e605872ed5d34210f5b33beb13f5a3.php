<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
</style>
</head>

<body>
<div class="title"><h2>职员列表</h2></div>
<div class="table-operate ue-clear">
	<!--<a href="javascript:;" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>-->
    <a href="/index.php/Admin/User/charts" class="count">统计</a>
    <div class="main" style="float: right">
        <form action="/index.php/Admin/User/index" method="get">
            <label>用户名：</label>
            <input name="key" type="text" value="<?php echo ($key); ?>" placeholder="用户名搜索" />
            <label>入职时间(开始)：</label>
            <input name="start" value="<?php echo (date('Y-m-d',$start)); ?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD '})" type="text" placeholder="开始时间" />
            <label>入职时间(结束)：：</label>
            <input name="end" type="text" value="<?php echo (date('Y-m-d',$end)); ?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD '})" placeholder="结束时间" />
            <input type="submit" value="搜索"/>
        </form>
    </div>
    <!--<a href="javascript:;" class="check">审核</a>-->
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">姓名</th>
				<th class="nickname">昵称</th>
                <th class="dept_id">所属部门</th>
				<th class="sex">性别</th>
				<th class="birthday">生日</th>
                <th class="tel">电话</th>
				<th class="email">邮箱</th>
                <th class="addtime">添加时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($key+1); ?></td>
                <td class="name"><?php echo ($vo["truename"]); ?></td>
				<td class="nickname"><?php echo ($vo["username"]); ?></td>
                <td class="dept_id"><?php echo ($vo["p_name"]); ?></td>
                <td class="sex"><?php echo ($vo['sex']?'女':'男'); ?></td>
				<td class="birthday"><?php echo (date("Y-m-d",$vo["birthday"])); ?></td>
				<td class="tel"><?php echo ($vo["tel"]); ?></td>
				<td class="email"><?php echo ($vo["email"]); ?></td>
                <td class="addtime"><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                <td class="operate">
                    <a href="/index.php/Admin/User/edit/id/<?php echo ($vo["id"]); ?>">编辑</a>
                    <!--<a href="/index.php/Admin/User/del/id/<?php echo ($vo["id"]); ?>">删除</a>-->
                    <a href="javascript:void(0)" class="ajax-delete" id="<?php echo ($vo["id"]); ?>" >删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list" style="float: right;">
		<?php echo ($page); ?>
	</div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/laydate/laydate.js"></script>
<script type="text/javascript">
//ajax 无刷新删除
$('.ajax-delete').bind('click',function(){
    //var id = $(this).parent().siblings('.num').text();
    var me = this;
    var id = $(me).attr('id');
    if(confirm('确定要删除吗？')){
        $.ajax({
            type:'POST',
            url:'/index.php/Admin/User/ajaxDel',
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
                        window.location.href="/index.php/Admin/User/index";
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