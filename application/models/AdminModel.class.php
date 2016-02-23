<?php 
/**
 * Admin 模型
 */
class AdminModel extends Model {
	public function test() {
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}

}
