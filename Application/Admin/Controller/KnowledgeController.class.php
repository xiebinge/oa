<?php
namespace Admin\Controller;

/*
 *knowledge controller
 */
class KnowledgeController extends CommonController
{
    protected $knowledgeModel = null; //实例化知识模型

    public function __construct()
    {
        parent :: __construct();
        if(class_exists('Admin\Model\KnowledgeModel') && !isset($this -> knowledgeModel)){
            $this -> knowledgeModel = D('Knowledge');
        }
    }

    //知识列表
    public function index()
    {
        //用类似以下的方法可以实现缓存分布式存储
        /*$memcache = new \Memcache();
        $memcache -> addserver('127.1.0.1',11211);
        $memcache -> addserver('192.168.123',11211);
        $memcache -> addserver('192.168.124',11211);

        $ret = $memcache -> get('ret'); //可以用S()方法获取缓存
        if(empty($ret)){
            $ret = $this -> knowledgeModel -> getknowledge();
            $ret = $memcache -> set('ret',$ret,0,3600*12);
        }
        if(isset($ret['page'])&&isset($ret['list'])){
            $this -> assign('page',$ret['page']);
            $this -> assign('list',$ret['list']);
        }
        $this -> display();
        */
        //缓存初始化
        $config = [
            'type'=>'memcache', //缓存的类型我们这里使用memcache缓存
            'host'=>'127.0.0.1', //memcache 服务器地址 在tp3.2版本中S方法不支持多台我们可以用addsever实现
            'port'=>'11211', //memcache 的端口号
            'prefix'=>'',  //缓存前缀
            'expire'=>3600*12  //缓存有效时间
        ];
        S($config);
        $ret = S('ret');
        if(empty($ret)){
            $ret = $this -> knowledgeModel -> getknowledge();
            $ret = S('ret',$ret);
        }
        if(isset($ret['page'])&&isset($ret['list'])){
            $this -> assign('page',$ret['page']);
            $this -> assign('list',$ret['list']);
        }
        $this -> display();
    }

    //添加知识
    public function add()
    {
        if(IS_POST){
            $knowledge = $this -> knowledgeModel -> create();
            $knowledge['author_id'] = session('session_user_id');
            $knowledge['add_time'] = time();
            if($_FILES['myfile']['error'] == 0){
                $thumb = true;
                $fileName = $this -> uploadFile($thumb);
                //dump($fileName);
                $knowledge['ori_img'] = $fileName['ori_img'];
                $knowledge['thumb_img'] = $fileName['thumb_img'];
            }
            $ret = $this -> knowledgeModel -> add($knowledge);
            if($ret){
                $this -> success('添加成功',U('Admin/Knowledge/index'));
            }else{
                $this -> error('添加失败');
            }
            die;
        }
        $this -> display();
    }

    //查看内容
    public function checkContent()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $content = $this -> knowledgeModel -> where(['id'=> $id]) -> getField('content');
            $this -> ajaxReturn(['code' => 1,'msg' => htmlspecialchars_decode($content)]);
        }
    }

    //删除知识
    public function del()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $thumb_img = I('post.thumb_img');
            $ori_img = I('post.ori_img');
            if($ori_img){
                unlink('./Uploads/'.$thumb_img);
                unlink('./Uploads/'.$ori_img);
            }
            $ret = $this -> knowledgeModel -> where(['id' => $id]) -> delete();
            if($ret){
                $this -> ajaxReturn(['code' => 1,'msg' => '删除成功']);
            }else{
                $this -> ajaxReturn(['code' => 0,'msg' => '删除失败']);
            }
        }
    }
}