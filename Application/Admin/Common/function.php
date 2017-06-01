<?php
/*
 * common functions
 */

if(!function_exists('getTree')){
    function getTree($arr,$pid = 0,$level = 0)
    {
        static $list = array();
        foreach($arr as $val){
            if($val['pid'] == $pid){
                $val['level'] = $level;
                $list[] = $val;
                getTree($arr,$val['id'],$level+1); //这里这个自调用函数必须放在if条件语句里面引文它的第二个参数是很关键的
            }
        }
        return $list;
     }
}