<?php
namespace Admin\Controller;
/*
 * 用户首页控制器
 */
class IndexController extends CommonController
{
    #用户首页
    public function index()
    {
        #######不同的角色登录显示不同的菜单######
        //从用户表中获取role_id
        $userModel = M('user');
        $where = ['id' => session('session_user_id')];
        $role_id = $userModel -> where($where) -> getField('role_id');

        //从角色表中获取权限auth_ids
        $roleModel = M('role');
        $auth_ids = $roleModel -> where(['id' => $role_id]) -> getField('auth_ids');
        //取出一级权限
        $authModel = M('auth');
        if($auth_ids == '*'){
           $map =  ['level' => 1];
        }else{
            //$auth_ids = explode(',',$auth_ids);
            $map = ['id' => ['IN',$auth_ids],'level' => 1];
        }
        $level1 = $authModel -> where($map) -> select();
        //取出二级权限
        $map = ['level' => 2];
        $level2 = $authModel -> where($map) -> select();
        //dump($level2);die;

        $emailModel = M('email');
        $map = ['is_read' => 0,'addressee_id' => session('session_user_id')];
        $noRead = $emailModel -> where($map) -> count(); //未读邮件的数量
        $this -> assign('level1',$level1);
        $this -> assign('level2',$level2);
        $this -> assign('noRead',$noRead);
        $this -> display();
    }

    //ajax邮件提醒
    public function ajax_Mail_Notifier()
    {
        if(IS_AJAX){
            $emailModel = M('email');
            $map = ['is_read' => 0,'addressee_id' => session('session_user_id')];
            $noRead = $emailModel -> where($map) -> count(); //未读邮件的数量
            $old_msg = I('post.old_msg');
            $old_msg = intval($old_msg);
            if($old_msg < $noRead){
                //有新邮件
                $newEmail = $noRead - $old_msg;
                $this -> ajaxReturn(['code' => 'newNum','newEmail' => $newEmail]);
            }elseif($old_msg > $noRead){
                //读取后邮件数量减少
                $newEmail = $noRead;
                $this -> ajaxReturn(['code' => 'noRead','no_read' => $newEmail]);
            }
        }
    }

    #HOME页面
    public function home()
    {
        $this -> display();
    }
}