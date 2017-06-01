<?php
namespace Home\Controller;

use \Think\Controller;
/*
 * test controller
 * */
class TestController extends Controller
{
    public function test()
    {
        echo '<h1 color="red">haha</h1>';
        dump('1');
    }
}