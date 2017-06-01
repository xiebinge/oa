<?php
namespace Admin\Controller;
/*
 * document controller
 */
class DocController extends CommonController
{

    public $docModel=null; //初始化user模型

    public function __construct()
    {
        parent :: __construct();
        if(class_exists('Admin\Model\DocModel') && !isset($this -> docModel)){
            $this -> docModel = D('Doc');
        }
    }
    //公文列表
    public function index()
    {
        $docs = $this -> docModel -> getDoc();
        $this -> assign('page',$docs['page']);
        $this -> assign('list',$docs['list']);
        $this -> display();
    }

    //查看公文
    public function checkContent()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $map = ['id' => $id];
            $contents = $this -> docModel ->  where($map) -> find();
            if(empty($contents)){
                $msg = ['code' => 0,'msg' => '没有内容'];
                $this -> ajaxReturn($msg);
                die;
            }
            $msg = ['code' => 1, 'msg' => htmlspecialchars_decode($contents['content'])];//解析取出的html标签
            $this -> ajaxReturn($msg);
        }
    }

    //文件下载
    public function downLoad()
    {
        if(IS_GET){
            $filename = I('get.filename');
            $filename = C('FILE_UPLOAD_PATH').$filename;
            //header("Content-type: application/octet-stream");//告诉浏览器我是一个文件流（也可以不写这一行）
            header('content-disposition:attachment;filename='.basename($filename));
            header('content-length:'.filesize($filename));
            readfile($filename);
        }
    }
    //添加公文
    public function add()
    {
        if(IS_POST){
            $data = $this -> docModel -> create();
            //dump($data);
            if($_FILES['myfile']['error'] == 0){
                $key = $_FILES['myfile'];
                $files = $this -> _upload($key);
                if($files){
                    $data['file'] = $files;
                }else{
                    $data['file'] = '';
                }
            }
            $data['add_time'] = strtotime($data['add_time']);
            $data['author_id'] = session('session_user_id');
            $res = $this -> docModel -> add($data);
            if(!$res){
                $this -> error('添加失败');
            }
            $this -> success('添加成功',U('Admin/Doc/index'));
            die;
        }
        $this -> display();
    }

    //文件上传类(只上传一个文件)
    protected function _upload($key='')
    {
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    C('FILE_UPLOAD_PATH'),
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),//savePath 的名字（可以自定义函数，在这里保存的目录名字如 20160526之类的）
        );
        $upload = new \Think\Upload($config);
        $fileInfo = $upload -> uploadOne($key);
        if(!$fileInfo) {
            // 上传错误提示错误信息
            $this->error($upload->getError());
        }else{
            // 上传成功 获取上传文件信息
            return $fileInfo['savepath'].$fileInfo['savename'];
        }
    }

    //编辑公文
    public function edit()
    {
        if(IS_POST){
            $editDoc = $this -> docModel -> create();
            $file = I('post.file');
            if($_FILES['myfile']['error'] == 0){
                $key = $_FILES['myfile'];
                $fileUpload = $this -> _upload($key);
                if($fileUpload){
                    if(!empty($file)){
                        $file = './Uploads/'.$file;
                        unlink($file);
                    }
                    $editDoc['file'] = $fileUpload;
                }
            }
            $editDoc['add_time'] = strtotime($editDoc['add_time']);
            $ret = $this -> docModel -> where(['id' => $editDoc['id']]) -> setField($editDoc);
            if(!$ret){
                $this -> error('编辑失败');
            }else{
                $this -> success('编辑成功',U('Admin/Doc/index'));
            }
            die;
        }
        $id = I('get.id');
        $docs = $this -> docModel -> where(['id' => $id]) -> find();
        $this -> assign('docs',$docs);
        $this -> display();
    }

    //删除公文
    public function del()
    {
        if(IS_AJAX){
            $id = I('post.id');
            #正则验证id

            $file = I('post.file');
            #验证file

            if(!empty($file)){
                $file = './Uploads/'.$file;
                unlink($file);
            }
            $docInfo = $this -> docModel -> where(['id' => $id]) -> delete();
            if(!$docInfo){
                $this -> ajaxReturn(['code' => 0,'msg' => '删除失败']);
            }else{
                $this -> ajaxReturn(['code' => 1,'msg' => '删除成功']);
            }
        }
    }
}