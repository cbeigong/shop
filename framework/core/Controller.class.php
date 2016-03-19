<?php
class Controller {
	// 定义跳转方法 
	public function jump($url, $message, $wait=3) {
		if($wait == 0) {
			// 这个块不太懂 ;                             
			header("Location:$url");
		} else {
			include CUR_VIEW_PATH . "message.html";
//			header("Location:$url");
//			header("refresh:$wait;url=$url");
		}
		// 要强制退出
		exit();
	}

	// 定义辅助函数
	public function helper($helper) {
		// {} 一定要加
		require HELPER_PATH . "{$helper}_helper.php";
	}

	// 定义载入类库方法
	public function library($lib) {
		require LIB_PATH . "{$lib}.class.php";
	}
}