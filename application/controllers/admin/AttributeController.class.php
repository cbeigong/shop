<?php
class AttributeController extends BaseController {
    // 显示商品属性
    public  function indexAction() {
        // 获取所有的商品类型
        $typeModel = new TypeModel('goods_type');
        $types =  $typeModel->getTypes();

        $attrModel = new AttributeModel('attribute');
        // 接收type_id
        $type_id = $_GET['type_id'] + 0;

        $where = 'type_id = $type_id';
        $total = $attrModel->total($where);
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = 2;
        $offset = ($current - 1) * $pagesize;

        $attrs = $attrModel->getPageAttrs($type_id, $offset, $pagesize);

//        生成page类
        $this->library('Page');
        $page = new Page($total,$pagesize,$offset,'index.php', array('p'=>'admin','c'=>'attribute','a'=>'index','type_id'=>$type_id));

        $pageinfo = $page->showPage();
        include CUR_VIEW_PATH . "attribute_list.html";

    }
    // 展示添加界面
    public function addAction(){
        // 获取所有的商品类型
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();
        include CUR_VIEW_PATH . "attribute_add.html";
    }
    public function insertAction() {
        // 1. 接收表单数据
        $data['attr_name'] = trim($_POST['attr_name']);
        $data['type_id'] = $_POST['type_id'];
        $data['attr_type'] = $_POST['attr_type'];
        $data['attr_input_type'] = $_POST['attr_input_type'];

        // 2. 对可选值做一个判断
        $data['attr_value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : '';

        $this->library('input');
        $data = deepslashes($data);
        $data = deepspecialchars($data);

        // 3 调用模型完成入库 ，并给出提示
        $attrModel = new AttributeModel('attribute');
        if($attrModel->insert($data)) {
            $this->jump("index.php?p=admin&c=attribute&=index","添加属性成功", 2);
        } else {
            $this->jump("index.php?p=admin&c=attribute&a=add","添加商品失败", 3);
        }
    }
}