<?php
namespace Admin\Controller;

/*
 *email controller
*/
class EmailController extends CommonController
{
    protected $emailModel = null;

    public function __construct()
    {
        parent :: __construct();
        if(class_exists('Admin\Model\EmailModel') && !isset($this -> emailModel)){
            $this -> emailModel = D('Email');
        }
    }

    //收件箱
    public function index()
    {
        $email = $this -> emailModel -> getEmail();
        $this -> assign('page',$email['page']);
        $this -> assign('list',$email['list']);
        $this -> display();
    }

    //查看邮件
    public function checkContent()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $is_read = I('post.is_read'); //状态 0:未读，1:已读
            $ret = 0;
            if($is_read == 0){
                $ret = $this -> emailModel -> where(['id' => $id]) -> setField('is_read',1);
            }
            $ret = $ret?1:0;
            $content = $this -> emailModel -> where(['id' => $id]) -> getField('content');
            $this -> ajaxReturn(['code' => 1,'msg' => htmlspecialchars_decode($content),'ret' => $ret]);
        }
    }

    //附件下载
    public function fileDownload()
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

    //发件箱
    public function sendEmail()
    {
        if(IS_POST){
            $email = $this -> emailModel -> create();
            if($email['addressee_id'] == 0){
                $this -> error('收件人不能为空');
                die;
            }
            $email['send_id'] = session('session_user_id');
            if($email['send_id'] == $email['addressee_id']){
                $this -> error('不能给自己发送邮件');
                die;
            }
            if($_FILES['myfile']['error'] == 0){
                $file = $this -> uploadFile();
                $email['file'] = $file;
            }else{
                $email['file'] = '';
            }
            $email['send_time'] = time();
            $ret = $this -> emailModel -> add($email);
            if($ret){
                $this -> success('发送成功',U('Admin/Email/index'));
            }else{
                $this -> error('发送失败');
            }
            die;
        }
        $this -> display();
    }

    //ajax解决用户漏洞
    public function ajaxDebug()
    {
        if(IS_AJAX){
            $userModel = D('User');
            $username = I('post.username');
            $map = ['username' => $username];
            $userInfo = $userModel -> where($map) -> find();
            if(!$userInfo){
                $this -> ajaxReturn(['code' => 0,'id' => 0]);
            }else{
                $this -> ajaxReturn(['code' => 1,'id' => $userInfo['id']]);
            }

        }
    }

    //ajax无刷新删除
    public function ajaxDel()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $file = I('post.file');
            if(!empty($file)){
                $file = './Uploads/'.$file;
                unlink($file);
            }
            $ret = $this -> emailModel -> where(['id' => $id]) -> delete();
            if($ret){
                $this -> ajaxReturn(['code' => 1,'msg' => '删除成功']);
            } else {
                $this -> ajaxReturn(['code' => 0,'msg' => '删除失败']);
            }
        }
    }
}