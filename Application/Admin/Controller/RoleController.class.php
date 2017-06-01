<?php
namespace Admin\Controller;

/*
*role controller
*/
class RoleController extends CommonController
{
    //角色列表
    public function index()
    {
        $authModel = M('role');
        $role = $authModel -> where(['id>0']) -> select();
        $this -> assign('list',$role);
        $this -> display();
    }

    //显示编辑权限页面
    public function auth()
    {
        if(IS_GET){
            $id = I('get.id');
            $auth_ids = I('get.auth_ids');
            $role = I('get.role');
            $this -> auth_ids = $auth_ids;
            $this -> role = $role;
            $this -> id = $id;
        }

        $authModel = M('auth');
        $level1 = $authModel -> where(['level' => 1]) -> select();
        $level2 = $authModel -> where(['level' => 2]) -> select();
        $level3 = $authModel -> where(['level' => 3]) -> select();
        $this -> assign('level1',$level1);
        $this -> assign('level2',$level2);
        $this -> assign('level3',$level3);
        $this -> display();
    }

    //编辑权限
    public function edit_auth()
    {
        if(IS_POST){
            $role_id = I('post.role_id');
            $auth_ids = I('post.ids');

            $auth_ids = implode(',',$auth_ids);

            $roleModel = M('role');
            $ret = $roleModel -> where(['id' => $role_id]) -> setField('auth_ids',$auth_ids);
            if($ret){
                $this -> success('更新成功',U('Admin/Role/index'));
            }else{
                $this -> error('更新失败');
            }
        }
    }
}