<?php
    class TypeController extends BaseController {
        public function addAction(){
            include CUR_VIEW_PATH . "goods_type_add.html";
        }
        // 添加类动作
        public function insertAction(){
            // 1 接收表单数据
            $data['type_name'] = trim($_POST['type_name']);

            // 2 验证以及处理
            if(empty($data['type_name'])) {
                $this->jump('index.php?p=admin&c=type&a=add',"商品名称不能为空哦",3);
            }
            $this->helper('input');
            deepslashes($data);
            deepspecialchars($data);

            // 3 调用模型 完成入库
            $typeModel = new TypeModel('goods_type');
            if($typeModel->insert($data)) {
                $this->jump('index.php?p=admin&c=type&a=index',"添加商品类型成功",2);
            } else {
                $this->jump('index.php?p=admin&c=type&a=add',"添加商品类型失败",3);
            }

        }
        // 显示商品类型
        public function indexAction() {
            // 1 获取商品类型的数据
            $typeModel = new TypeModel("good_type");
            // $types = $typeModel->getTypes();

            // 获取当前页数
            $current = isset($_GET['page']) ? $_GET['page'] : 1 ;
            // 设置一页显示2页
            $pagesize = 2;
            // 获取当前在数据库的偏移量
            $offset = ($current - 1) * $pagesize;
            $types = $typeModel->getTypes($offset, $pagesize);

            // 通过分页类来获取分类信息
            $where = '';
            // 获取总的记录数
            $total = $typeModel->total($where);
            $this->library('Page');
            $page = new Page($total,$pagesize,$current,'index.php',array('p'=>'admin','c'=>'type','a'=>'index'));

            $pageinfo = $page->showPage();
//            在视图对应的地方中输出
//            echo $pageinfo;
            // 展示到视图
            include CUR_VIEW_PATH . "goods_type_list.html";
        }
    }

