<?php
namespace Admin\Controller;

/*
 * user controller
 * */

class UserController extends CommonController
{

    public $userModel = null; //初始化user模型

    public function __construct()
    {
        parent :: __construct();
        if(class_exists('Admin\Model\UserModel') && !isset($this -> userModel)){
            $this -> userModel = D('User');
        }
    }
    //用户登录页面展示
    public function login()
    {
        if(IS_AJAX){
            $username = I('post.username');
            $password = I('post.password');
            $code = I('post.code');
            $remember = I('post.remember');
            $password = md5(md5($password).C('SALT')); //密码加盐

            $verify = new \Think\Verify(); //实例化验证码类
            //验证验证码
            if( !$verify -> check($code) ){
                $data = array(
                    'code' => 0, //失败返回零，成功返回1
                    'msg'  => '验证码错误'
                );
                $this -> ajaxReturn($data);
            }
            //检查用户是否存在
            $userInfo = $this -> userModel -> checkName($username);
            if(!$userInfo){
                $data = array(
                    'code' => 0, //失败返回零，成功返回1
                    'msg'  => '找不到这个用户'
                );
                $this -> ajaxReturn($data);
            }
            //检查密码是否正确
            if($password != $userInfo['password']){
                $data = array(
                    'code' => 0, //失败返回零，成功返回1
                    'msg'  => '密码不对'
                );
                $this -> ajaxReturn($data);
            }
            //用户输入合法把用户id保存在session中
            session('session_user_id',$userInfo['id']);
            session('session_user_name',$userInfo['username']);
            //七天登录
            if($remember == 'on'){
                cookie('oa_user_id',$userInfo['id'],3600*24*7);
            }else{
                cookie('oa_user_id',null);
            }
            $data = array(
                'code' => 1, //失败返回零，成功返回1
                'msg'  => '登陆成功！'
            );
            $this -> ajaxReturn($data);
        }
        $this -> display();
    }

    //退出登录
    public function logout()
    {
        //清空之前保存的session
        session('session_user_id',null);
        session('session_user_name',null);
        cookie('oa_user_id',null);
        redirect('/Admin/User/login');
    }

    //职员列表
    public function index()
    {
        $where = 1;
        #搜索功能
        if(IS_GET){
            $key = I('get.key')?:'';
            $start = I('get.start');
            $end = I('get.end');
            $start = intval(strtotime($start));
            $end = intval(strtotime($end));
            if(!empty($key)){
                $where .= " and tb1.username like '%{$key}%'";
                $this -> key = $key;
            }
            if($start < $end){

                if(!empty($start)){
                    $where .= " and tb1.add_time > '{$start}'";
                    $this -> start = $start;
                }
                if(!empty($end)){
                    $where .= " and tb1.add_time < '{$end}'";
                    $this -> end = $end;
                }
            }

        }
        $users = $this -> userModel -> getUsers($where);
        $page = $users['page'];
        $list = $users['list'];
        $this -> assign('page',$page);
        $this -> assign('list',$list);
        $this -> display();
    }

    //职员添加
    public function add()
    {
        if(IS_POST){
            $userInfo = $this -> userModel -> create();
            $userInfo['birthday'] = strtotime($userInfo['birthday']);
            $userInfo['add_time'] = time();
            $userInfo['role_id'] = 1;
            $userInfo['password'] = md5(md5(C('default_password')).C('SALT'));
            $ret = $this -> userModel -> add($userInfo);
            if($ret){
                $this -> success('添加成功',U('Admin/User/index'));
            }else{
                $this -> error('添加失败');
            }
            die;
        }
        $deptModel = D('Dept');
        $dept = $deptModel -> getTree(0);
        $this -> assign('dept',$dept);
        $this ->  display();
    }

    //职员编辑
    public function edit()
    {
        $id = I('get.id');
        if(IS_POST){
            $userInfo = $this -> userModel -> create();
            $repassword = I('post.repassword');
            $uid = I('post.uid');
            if($userInfo['password'] != $repassword){
                $this -> error('两次输入的密码不一致');
            }
            if(empty($userInfo['password'])){
                unset($userInfo['password']);
            }else{
                $userInfo['password'] = md5(md5($userInfo['password']).C('SALT'));
            }
            $userInfo['birthday'] = strtotime($userInfo['birthday']);
            //dump($userInfo);die;
            $ret = $this -> userModel ->where("id=$uid") -> setField($userInfo);
            //echo $this -> userModel -> getLastSql();die;
            if($ret){
                $this -> success('编辑成功',U('Admin/User/index'));
            }else{
                $this -> error('编辑失败');
            }
            die;
        }
        $users = $this -> userModel -> where("id = $id") -> find();
        if(!$users){
            $this -> error('数据有误！');
            die;
        }
        $deptModel = D('Dept');
        $dept = $deptModel -> getTree(0);
        $this -> assign('users',$users);
        $this -> assign('dept',$dept);
        $this -> display();
    }

    //职员删除
    public function ajaxDel()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $ret = $this -> userModel -> where("id=$id") -> delete();
            if($ret){
                $retInfo = array('code' => 1,'msg' => '删除成功');
                $this -> ajaxReturn($retInfo);
            }else{
                $retInfo = array('code' => 0,'msg' => '删除失败');
                $this -> ajaxReturn($retInfo);
            }
        }
    }

    //验证码
    public function verify()
    {
        $config = array(
            'length' => 3,
            'useNoise' => false,
            'useCurve' => false,
            'fontSize' => 20,
            'bg'       => array(93,202,27),
        );
        $verify = new \Think\Verify($config);
        $verify -> entry();
    }

    //各部门人数统计图表
    public function charts()
    {
        //获取各部门数据
        $charts = $this -> userModel -> getCharts();
        $this -> assign('data',json_encode($charts));
        $this -> display();
    }

    //ajax请求获取用户
    public function ajaxGetUsers()
    {
        if(IS_AJAX){
            $key = I('post.key');
            $map = array(
                'username' => array('like',"%{$key}%")
            );
            $user = $this -> userModel -> where($map) ->limit(6)-> select();
            //echo $this -> userModel -> getLastSql();
            $this -> ajaxReturn(['code' => 1,'msg' => $user]);
        }
    }
}