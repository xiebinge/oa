<?php
namespace Admin\Model;

use Think\Model;
/*
 * document model
 */
class DocModel extends Model
{
    //添加字段防止缝隙表结构
    protected $fields = ['id','title','content','file','add_time','author_id','_pk'=>'id'];

    //映射（安全性考虑）
    protected $_map = ['doc_title'=>'title','doc_add_time'=>'add_time','doc_content'=>'content'];

    //获取公文列表
    public function getDoc()
    {
        $count = $this ->where('id>0') -> count();
        $page = new \Think\Page($count,5);//实例化分页
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $show = $page -> show();
        $list = $this -> where('tb1.id>0')
                      -> order('add_time desc')
                      -> field(' tb1.*,tb2.username as author')
                      -> join(' tb1 left join oa_user as tb2 on tb1.author_id=tb2.id')
                      -> limit($page->firstRow.','.$page->listRows)
                      -> select();
        $docs = array(
            'page' => $show,
            'list' => $list
        );
        return $docs;
    }
}