<?php
class BaseController extends Controller{
    // 构造方法
    public function __construct() {
        $this->checkLogin();
    }

    // 验证用户是否登入
    public function  checkLogin(){
        // 只需要检查session即可
        if(empty($_SESSION['admin'])){
            // 说明没有登录，需要给出提醒
            $this->jump("index.php?p=admin&c=login&a=login","你还没有登入",3);
//            $this->jump("index.php?p=admin&c=login&a=login","你还没有登入",3);
        }
    }
}