<?php
class CategoryController extends BaseController {
	//	 显示商品分类
	public function indexAction() {
//		$categoryModel = new CategoryModel("category");
//		$cats = $categoryModel->getCats();
		// 载入显示的页面
		include CUR_VIEW_PATH . "cat_list.html";
	}
	// 载入编辑分类动作
	public function editAction() {
		// 此处的加0是
		// $cat_id = $_GET['cat_id'] + 0 ;
		// $categoryModel = new CategoryModel('category');
		// $cat = $categoryModel->selectByPk($cat_id);
		// // 获取所有的分类信息
		// $cats = $categoryModel->getCats();

		include CUR_VIEW_PATH . 'cat_edit.html';
	}


	//
    public function addAction() {
    	$categoryModel = new CategoryModel("category");
    	$cats = $categoryModel->getCats();
        include CUR_VIEW_PATH . "cat_add.html";
    }

   public function insertAction () {
   		// 1 收集表单数据 
   		$data['cat_name'] = trim($_POST['cat_name']);
   		$data['unit'] = trim($_POST['unit']);
   		$data['sort_order'] = trim($_POST['sort_order']);
   		$data['is_show'] = $_POST['is_show'];
   		$data['cat_desc'] = trim($_POST['cat_desc']);

   		// 验证以及处理
   		if($data['cat_name'] === "") {
   			$this->jump("index.php?p=admin&c=category&a=add","分类名称不能为空",3);
   		}
	   // 注意html字符防止xss攻击
	   $this->helper('input');
	   $data = deepspecialchars($data);

   		// 调用模型，完成入库。 传递的是一个不带前缀的表名
   		$categoryModel = new CategoryModel("category");
   		if($categoryModel->insert($data)) {
   			$this->jump("index.php?p=admin&c=category&a=index","添加分类成功",2);
   		} else {
   			$this->jump("index.php?p=admin&c=category&a=add","添加分类失败",3);
   		}
   }

   // 更新
   public function updateAction() {
   		   		// 1 收集表单数据 
   		$data['cat_name'] = trim($_POST['cat_name']);
   		$data['unit'] = trim($_POST['unit']);
   		$data['sort_order'] = trim($_POST['sort_order']);
   		$data['is_show'] = $_POST['is_show'];
   		$data['cat_desc'] = trim($_POST['cat_desc']);
   		// 获取隐藏域中的id
   		$data['cat_id'] = $_POST['cat_id'];

   		// 2 验证以及处理 
   		if($data['cat_name'] == "") {
   			$this->jump('index.php?p=admin&c=category&a=add',"分类名称不能为空",3);
   		}

   		// 2.1 处理当前节点的子节点，或者自己本身会当做自己的父亲节点，形成断链的情况
   		$categoryModel = new CategoryModel('category');
	    $ids = $categoryModel->getSubId($data['cat_id']);
   		$ids[] = $data['cat_id'];

   		if(in_array($data['parent_id'],$ids)) {
   			$this->jump('index.php?p=admin&c=category&a=edit&cat_id='.$data['cat_id'],"当前的节点或者子节点不能当做其父亲的节点",3);
   		}
   		
   		// 3 : 完成入库 
   		if($categoryModel->update($data)) {
   			$this->jump("index.php?p=admin&c=category&a=index","更新成功",2);
   		} else {
   			$this->jump("index.php?p=admin&c=category&a=edit&cat_id=".$data['cat_id'],"更新失败",2);
   		}
    }
	// 删除商品分类
	public function deleteAction() {
		// 1 : 获取cat_id 作为条件
		$cat_id = $_GET['cat_id'] + 0;
		// 2 : 进行一些基础判断
		// 如果不是叶子则不允许其删除
		$categoryModel = new CategoryModel('category');
		$cats = $categoryModel->getSubId($cat_id);
		if(!empty($cats)) {
			$this->jump("index.php?p=amdin&c=category&a=index","不允许删除非子节点",3);
		}
		// 3 : 调用模型完成入库
		if($categoryModel->delete($cat_id)) {
			$this->jump("index.php?p=admin&c=category&a=index","删除商品分类成功",2);
		} else {
			$this->jump("index.php?p=admin&c=category&a=index","删除商品分类失败",3);
		}
	}
}