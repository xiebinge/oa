<?php
namespace Admin\Model;

use \Think\Model;
/*
 *department table model
 */
class DeptModel extends Model
{
    //给部门表字段缓存，提高表的性能防止分析表结构（跟我们的页面缓存一个性质）
    protected $fields = array('id','name','pid','add_time','intro','sort','_pk'=>'id');

    //add data
    public function model_add($data = array())
    {
        $ret = null;
        if(!empty($data)){
            $ret = $this -> add($data);
        }
        return $ret;
    }

    //get all department paging
    public function getAll()
    {
        //总记录数
        $count = $this -> field(' count(id) as total') -> where(' id > 0') -> select();
        if($count){
            $count_dept = intval($count[0]['total']);
            //分页
            $page = new \Think\Page($count_dept,5);
            //设置分页样式
            $page -> setConfig('prev','上一页');
            $page -> setConfig('next','下一页');
            $show = $page -> show();
            $list = $this -> field(' tb1.*,tb2.name p_name')
                          -> join(' tb1 left join oa_dept tb2 on tb1.pid=tb2.id')
                          -> limit($page->firstRow.','.$page->listRows)
                          -> select();

            $ret = array(
                'page' => $show,
                'list' => $list
            );

            return $ret;
        }
        return null;
    }

    #get dept tree
    public function getTree($id=0)
    {
        $data = $this -> where('id > 0') -> select();
        $depts = getTree($data,$id);
        if(is_array($depts)){
            return $depts;
        }
        return null;
    }
}