<?php
/**
* 登入控制器	
*/
class LoginController extends Controller
{
	// 载入用户登入界面
	// 要修改下静态资源的html文件
	public function loginAction() {
		include CUR_VIEW_PATH . "login.html";
	}

	// 处理用户登入的动作
	public function signinAction(){
		// 0. 先判断， 有没有灌水 通过验证码来判断
		$captcha = trim($_POST['captcha']);
		if(strtolower($captcha) != $_SESSION['captcha']) {
			$this->jump('index.php?p=admin&c=login&a=login',"别灌水了啊",3);
		}
		// 1. 手机用户的用户名和密码
		$this->helper('input');
		$username = trim($_POST['user_name']);
		$password = trim($_POST['password']);
		// 2.  处理用户名的可能特殊字符防止sql注入
		$username = deepslashes($username);
		$password = deepslashes($password);

		// 2. 验证以及处理数据 每次创建的时候要传递一个表名  是没有后缀的表名
	    $adminModel = new AdminModel('admin');
	    // 保存数据以便设置session
	    $userinfo = $adminModel->checkUser($username,$password);
	    if(empty($userinfo)) {
	    	$this->jump('index.php?p=admin&c=login&a=login',"用户名和密码错误，请从新输入",3);
	    } else {
	    	$this->jump('index.php?p=admin&c=index&a=index',"",0);
	    }
	}

	// 注销
	public function logoutAction() {
		// 销毁session
		unset($_SESSION['admin']);
		session_destroy();
		$this->jump('index.php?p=admin&c=login&a=login','',0);
	}

	// 生成验证码
	public function captchaAction() {
		// 载入验证码类，继承自Controller
		$this->library('Captcha');
		// 实例化验证码类，并调用方法生成验证码
		$captcha = new Captcha();
		$captcha->generateCode();
		// 保存到session中
		$_SESSION['captcha'] = $captcha->getCode();
	}

}