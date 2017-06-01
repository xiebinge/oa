<?php
namespace Admin\Controller;

use \Think\Controller;

class EmptyController extends Controller
{
    public function index()
    {
        echo "empty_index";
    }

    public function _empty()
    {
        echo"404,页面找不到！";
    }
}