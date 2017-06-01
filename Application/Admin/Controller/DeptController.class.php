<?php
namespace Admin\Controller;

/*
 * department controller
 */
class DeptController extends CommonController
{

    #depart index
    public function index()
    {
        $dept = D('Dept');
        $data = $dept -> getAll();
        if(isset($data['page'])&&isset($data['list'])){
            $this -> assign('page',$data['page']);
            $this -> assign('list',$data['list']);
        }
        $this -> display();
    }

    #department add
    public function add()
    {
        if(IS_POST){
            $name = I('post.name');
            $add_time = time(I('POST.add_time'));//时间格式化成时间戳
            $pid = I('post.pid');
            $sort = I('post.sort');
            $intro = I('post.intro');
            //验证数据的合法性
            //.....
            $data = array(
                'name'     => $name,
                'pid'      => $pid,
                'add_time' => $add_time,
                'intro'    => $intro,
                'sort'     => $sort
            );
            $dept = D('dept');
            $ret = $dept-> model_add($data);
            if(!$ret){
                $this -> error('添加失败');
            }
            $this -> success('添加成功','index');
        } else {
            $dept = D('Dept');
            $data = $dept -> getTree(0);
            $this -> assign('data',$data);
            $this -> display();
        }
    }

    #department del
    public function del()
    {
        if(IS_GET){
            $id = I('get.id');
            //此处验证id的合法性（正则匹配）

            $dept = D('Dept');
            $map = array('id' => $id);
            $ret = $dept -> where($map) -> delete();
            if(!$ret){
                $this -> error('删除失败');
            }
            $this -> success('删除成功',U('Admin/dept/index'),array('id'=>5),'.html');
        }
    }

    #ajax delete
    public function ajaxDel()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $dept = D('Dept');
            $map = array('id' => $id);
            $ret = $dept -> where($map) -> delete();
            if(!$ret){
                echo json_encode(array('code' => 0,'msg' => '删除失败！'));
            }else{
                echo json_encode(array('code' => 1,'msg' => '删除成功！'));
            }

        }
    }

    #department edit
    public function edit()
    {
        $dept = D('Dept');
        if(IS_POST){
            #首先编辑自己不能是自己的上级，还有儿子不能是自己的上司
            $name     = I('post.name');
            $id       = intval(I('post.id'));
            $pid      = intval(I('post.pid'));
            $sort     = I('post.sort');
            $add_time = I('post.add_time');
            $intro    = I('post.intro');
            //自己不能是自己的上级部门
            if($pid == $id){
                $this -> error('上级部门不能是自己！');
                exit();
            }
            //下级部门不能成为上级(关键是要找到它下级的id)
            $sons = $dept -> getTree($id);
            foreach($sons as $val){
                if($pid == $val['id']){
                    $this -> error('下级不能成为自己的父类');
                    break;
                }
            }

            $data = array(
                'name'     => $name,
                'pid'      => $pid,
                'sort'     => $sort,
                'add_time' => time($add_time),
                'intro'    => $intro
            );

            $res = $dept -> where("id=$id") -> save($data);
            if(!$res){
                $this -> error('编辑失败！');
            }
            $this -> success('编辑成功',U('Admin/dept/index'));
            exit();
        }
        $id = I('get.id');
        $oneDept = $dept -> where("id=$id") -> find();//根据id查询出对应的数据
        $data_dept = $dept -> getTree(0); //获取所有部门的具有层级的数据
        $this -> assign('oneDept',$oneDept);
        $this -> assign('dept',$data_dept);
        $this -> display();
    }
}