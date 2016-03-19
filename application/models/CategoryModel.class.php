<?php
class CategoryModel extends Model {

	public function getCats() {
		// 从数据库中取出所有的分类
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll("$sql");
		return tree($cats);
	}

	// 获取指定节点的所有子节点的id
	public function getSubId($pid) {
		// 1 : 取出数据
		$sql = "SELECT * FROM  {$this->table}";
		$cats = $this->db->getAll("$sql");
		$cats = $this->tree($cats, $pid);

		// 2 : 获取id
		foreach($cats as $cat) {
			$list = $cat['cat_id'];
		}
		return $list;
	}

	/**
	 * @param $arr array 给定数组
	 * @param $pid int 指定从哪个节点开始找
	 * @return array 构造好的数组
	 */
	public function tree($arr, $pid=0, $level=0) {
		static $tree = array();
		foreach ($arr as $v) {
			if($v['parent_id'] == $pid) {
				$v['level'] = $level;
				$tree[] = $v;
				$this->tree($arr,$v['cat_id'],level + 1);
			} 
		}
		return $tree;
	}

	// 将二维数组转换为 多维数组  包含关系
	public function childList($arr,$pid=0) {
		$list = array();
		foreach($arr as $v) {
			if($v['parent_id'] == $pid) {
				$child = $this->childList($arr,$v['cat_id']);
				$v['child'] = $child;
				$list[] = $v;
			}
		}
		return $list;
	}

	// 在前台获取所有的分类数据
	public function frontCats() {
		$sql = "SELECT * FROM  {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->childList($cats);
	}
}