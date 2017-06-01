<?php
namespace Admin\Model;

use Think\Model;
/*
 * email model
 */
class EmailModel extends Model
{
    protected $fields = ['id','title','file','content','send_id','addressee_id','send_time','is_read','_pk'=>'id'];

    //获取收件箱
    public function getEmail()
    {
        $map = [
            'tb1.addressee_id' => session('session_user_id'),
        ];
        $count = $this -> where(['addressee_id' => session('session_user_id')]) -> count();
        $page = new \Think\Page(intval($count),10);
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $show = $page -> show();

        $list = $this -> where($map)
            -> field(' tb1.*,tb2.username sender')
            -> join(' tb1 left join oa_user tb2 on tb1.send_id = tb2.id ')
            -> limit($page -> firstRow.','.$page -> listRows)
            -> order(' send_time desc')
            -> select();

        return ['page' => $show,'list' => $list];
    }
}