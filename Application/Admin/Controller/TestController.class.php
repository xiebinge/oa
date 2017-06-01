<?php
namespace Admin\Controller;

use \Think\Controller;
/*
 * test controller
 * */
class TestController extends Controller
{
    public function test()
    {
        $this -> assign('date',time());
        cookie('daxia',22);
        session('fengjie','美女');
        $this -> display();
        //echo '<h1 color="red">跳转来自于test2 success方法</h1>';
    }

    public function test2()
    {
        //dump($_GET);die;
        $get = $_GET['num']?$_GET['num']:1;
        //var_dump($get);die;
        if($get){
            $this -> success('成功','test');
        }else{
            $this -> error('失败','test3');
        }
    }

    public function test3()
    {
        echo "跳转来自于test2 error 方法";
    }

    public function test4()
    {
        $get = $_GET['num'];
        //var_dump($get);die;
        if($get){
            $this -> redirect('/home/test/test',array('num' => 10,'age' => 1100),2,'跳转中。。。');
        }
    }

    public function test5()
    {
        $model = D('Dept');
        $ret = $model -> where("id >2") -> buildSql();
        dump($ret);
        echo $model -> getLastSql();


       /* $User = M("dept"); // 实例化User对象// 查找status值为1name值为think的用户数据
        $User->where('id = 1')->find();
        dump($User->data());*/

        //$conrect = D('Dept');
        //$conrect = new \Admin\Model\DeptModel();
        /*$conrect = M('dept');
        dump($conrect);*/
    }

    public function checkModel()
    {
        $model = M();
        $res = $model -> getError();

        dump($res);
    }

    public function _empty()
    {
        echo "方法不存在";
    }
}