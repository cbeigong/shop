<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/20 0020
 * Time: 下午 12:34
 */

class IndexController extends BaseController{
    public function indexAction() {
//        echo "admin  index ";
        include CUR_VIEW_PATH . "index.html";
	}

	public function topAction() {
		include CUR_VIEW_PATH . "top.html";
	} 

	public function menuAction() {
		include CUR_VIEW_PATH . "menu.html";
		// var_dump(CUR_VIEW_PATH);
	}

	public function dragAction() {
		include CUR_VIEW_PATH . "drag.html";
	} 

	public function mainAction() {
		// include CUR_VIEW_PATH . "main.html";
		// 载入辅助函数
		$this->helper("input");
		f1();


		$adminModel = new  AdminModel("admin");
		$admins =$adminModel->test();
		echo "<pre>";
		var_dump($admins);
		echo "<pre>";

	}
}