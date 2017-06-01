<?php
namespace Admin\Controller;

use Think\Controller;
/*
 * common controller  要用到登录的都要继承它
 */
class CommonController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $allow[] = strtolower('Admin/User/login');
        $allow[] = strtolower('Admin/User/verify');
        $url = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
        if(!in_array($url,$allow)){
            if(!session('?session_user_id') || !session('?session_user_name')){

                if(!cookie('oa_user_id')){
                    $this -> redirect('admin/User/login');
                }else{
                    #要考虑我们可能在两台不同的电脑上登录，如果有一台改了电脑我们就无法在另外一台登陆了
                    $userid = cookie('oa_user_id');
                    $map = array(
                        'id' => $userid
                    );
                    $result = D('User') -> where($map) -> find();
                    if(empty($result)){
                        $this -> redirect('admin/User/login');
                    }
                    #把用户名和id存到seesion中，以备后用
                    session('session_user_name',$result['username']);
                    session('session_user_id',$result['id']);
                    $this -> redirect('admin/Index/index');
                }
            }else{
                //有session的情况我们要防止rbac权限漏洞
                //dump(get_defined_constants());die;
                //根据当前所登陆用户的session里面存的id我们可以取出他所属角色的id
               /* $userModel = M('user');
                $role_id = $userModel -> where(['id' => session('session_user_id')]) -> getField('role_id');

                $auth_ids = M('role') -> where(['id' => $role_id]) -> getField('auth_ids');
                if($auth_ids == '*'){
                    $map = ['id' => ['gt',1]];
                    echo '*';
                }else {
                    $map = ['id' => ['in',$auth_ids]];
                    echo 'else';
                }
                $auths = M('auth') -> where($map) -> select();
                $url = array();
                foreach($auths as $key => $val){

                    if(!empty($val['c_name'])){
                        $url[] = strtolower($val['m_name'].'/'.$val['c_name'].'/'.$val['a_name']);
                    }
                }*/
                //dump($url);die;
                //当前的模块控制器和方法
                $module = strtolower(MODULE_NAME);
                $controller = strtolower(CONTROLLER_NAME);
                $action = strtolower(ACTION_NAME);

                $map = array(
                    'm_name' => $module,
                    'c_name' => $controller,
                    'a_name' => $action
                );
                $auth_id = M('auth') -> where($map) -> getField('id');
                //dump($auth_id);
                //取出当前角色的所有权限
                $role_id = M('user') -> where(['id' => session('session_user_id')]) -> getField('role_id');

                $auth_ids = M('role') -> where(['id' => $role_id]) -> getField('auth_ids');

                if($auth_ids == '*'){
                    return true;
                }else{
                    $auth_ids = explode(',',$auth_ids);
                }
                //dump($auth_ids);

                $current_url = $module.'/'.$controller.'/'.$action;
                //dump($current_url);die;

                //设置一个允许访问的方法数组
                $allow_call = array(
                    'admin/index/index',
                    'admin/index/home',
                    'admin/dept/ajaxdel',
                    'admin/doc/checkcontent',
                    'admin/doc/del',
                    'admin/doc/download',
                    'admin/email/checkcontent',
                    'admin/email/ajaxdel',
                    'admin/email/filedownload',
                    'admin/email/ajaxdebug',
                    'admin/index/ajax_mail_notifier',
                    'admin/knowledge/checkcontent',
                    'admin/knowledge/del',
                    'admin/user/ajaxdel',
                    'admin/user/ajaxgetusers',
                    'admin/user/charts',
                );
                if(!in_array($auth_id,$auth_ids) && !in_array($current_url,$allow_call)){
                    $this -> redirect('admin/User/login');
                }
                /*if(!in_array($current_url,$url) && !in_array($current_url,$allow_call)){
                    $this -> redirect('admin/User/login');
                }*/
            }
        }
    }

    //图片上传类(支持多文件传送)
    /*
     * @param bool  default false
     * @return mixd
     */
    protected function uploadFile($thumb = false)
    {
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Uploads/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $fileS = $upload -> upload();

        if($thumb){
            //生成缩略图
            if(!$fileS){
                $this -> error($upload -> getError());
            }
            $ori_img_name = '';
            foreach($fileS as $file){
                $ori_img_name = $file['savepath'].$file['savename']; //原图的名称
            }
            $thumb_img_name = str_replace('/','/thumb_',$ori_img_name); //缩略图的名称
            $ori_img_path = './Uploads/'.$ori_img_name; //原图的保存路径
            $thumb_img_path = './Uploads/'.$thumb_img_name; //缩略图的保存路径
            $image = new \Think\Image();
            $image->open($ori_img_path);
            $image->thumb(150, 150,2)->save($thumb_img_path); //生成缩略图

            return ['ori_img' => $ori_img_name,'thumb_img' => $thumb_img_name]; //返回一个数组
        }else{
            //不生成缩略图
            if(!$fileS){
                $this -> error($upload -> getError());
            }else{
                foreach($fileS as $file){
                    return $file['savepath'].$file['savename']; //返回一个字符串
                }
            }
        }

    }

}