<?php
namespace Admin\Model;

use Think\Model;
/*
 * knownledge model
 */
class KnowledgeModel extends Model
{
    //知识表字段缓存，防止分析表结构
    protected $fields = ['id','title','content','author_id','ori_img','thumb_img','add_time','_pk'=>'id'];

    //获取知识列表
    public function getknowledge()
    {
        $count = $this -> where('id>0') -> count();
        if(!empty($count)){
            $page = new \Think\Page($count,5);
            $page -> setConfig('prev','上一页');
            $page -> setConfig('next','下一页');
            $showPage = $page -> show();
            $list = $this -> field(' tb1.*,tb2.username author')
                          -> join(' tb1 left join oa_user tb2 on tb1.author_id=tb2.id')
                          -> limit($page->firstRow.','.$page->listRows)
                          -> order('add_time desc')
                          -> select();
            return ['page' => $showPage,'list' => $list];
        }
        return null;
    }

}