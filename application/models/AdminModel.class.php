\<?php 
/**
 * Admin 模型
 */
class AdminModel extends Model {
	public function test() {
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}
	// 检测用户是否合法 
	public function checkUser($username, $password) {
//		$password = md5($password);
//		// 对用户名字 和密码进行转义
//		$username = adslashes($username);
//		$password = adslashes($password);
		// 其中admin_name 和 password 是数据库表中定义的字段
		$sql = "SELECT *FROM {$this->table} WHERE admin_name = '$username' AND password = 'password' LIMIT 1";
		// 获取一行
		return $this->db->getRow($sql);
	}

}
