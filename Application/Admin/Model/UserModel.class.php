<?php
namespace Admin\Model;

use \Think\Model;
/*
 * USER model
 */
class UserModel extends Model
{
    //设置字段，防止分析表结构
    protected $fields = array(
        'id',
        'username',
        'password',
        'sex',
        'truename',
        'dept_id',
        'role_id',
        'tel',
        'email',
        'birthday',
        'add_time',
        '_pk'=>'id'
    );

    //字段映射
    protected $_map = array(
        'name'          => 'username',
        'nickname'      => 'truename',
        'sjid'          => 'dept_id',
        'usersex'      => 'sex',
        'userbirthday' => 'birthday',
        'usertel'      => 'tel',
        'useremail'    => 'email',
        'userpassword'    => 'password'
    );

    //get users
    public function getUsers($where=1)
    {
        //总记录数
        $count = $this -> field(' count(id) as total') -> where('id>0') -> select();
        if($count){
            $count_dept = intval($count[0]['total']);
            //分页
            $page = new \Think\Page($count_dept,5);
            $page -> setConfig('prev','上一页');
            $page -> setConfig('next','下一页');
            $show = $page -> show();
            $list = $this -> field(' tb1.*,tb2.name p_name')
                -> where($where)
                -> join(' tb1 left join oa_dept tb2 on tb1.dept_id=tb2.id')
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

    //check login
    public function checkName($username = '')
    {
        return $this -> where("username='{$username}'") -> find();
    }

    //get department people
    public function getCharts()
    {
        return $this -> field(" tb2.name as dept_name,count('tb1.id') as count_people")
              -> join(" tb1 left join oa_dept as tb2 on tb1.dept_id=tb2.id")
              -> group(" tb1.dept_id")
              -> select();
    }

}