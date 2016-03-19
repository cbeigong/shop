<?php
 class GoodsController extends BaseController{
     // 载入添加商品界面
     public function addAction() {
         $categoryModel = new CategoryModel('category');
         $cats = $categoryModel->getCats();

         // 获取商品品牌信息

         // 获取商品类型信息
         $typeModel = new TypeModel('goods_type');
         $types = $typeModel->getTypes();

         // 载入视图
         include CUR_VIEW_PATH . "goods_add.html";
     }

     // 获取制定类型下的属性
     public function getAttrsAction() {
         // 获取type_id
         $type_id = $_GET['type_id'] + 0;
          // 调用模型 直接找属性，并构造表单返回
         $attrModel = new AttributeModel('attribute');
         $attrs = $attrModel->getAttrsForm($type_id);
         echo <<<STR
         <script>
            window.parent.document.getElementById("tbody-goodsAttr").innerHTML = "$attrs";
         </scrip>
STR;
     }
    public function insertAction() {
        // 1 手机数据
        $data['goods_name'] = trim($_POST['goods_name']);
        $data['goods_sn'] = trim($_POST['goods_sn']);
        $data['brand_id'] = $_POST['brand_id'];
        $data['cat_id'] = $_POST['cat_id'];
        $data['type_id'] = $_POST['type_id'];
        $data['shop_price'] = trim($_POST['shop_price']);
        $data['market_price'] = trim($_POST['market_price']);
        $data['promote_start_time'] = strtotime($_POST['promote_start_time']);
        $data['promote_end_time'] = strtotime($_POST['promote_end_time']);
        $data['goods_desc'] =  trim($_POST['desc']);
        $data['goods_number'] =  trim($_POST['goods_number']);
        $data['add_time'] = time();
        $data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
        $data['is_new'] = isset($_POST['is_new']) ? $_POST['is_new'] : 0;
        $data['is_hot'] = isset($_POST['is_hot']) ? $_POST['is_hot'] : 0;
        $data['is_onsale'] = isset($_POST['is_onsale']) ? $_POST['is_onsale'] : 0;

        // 处理图片上传
        $this->library('Upload');
        $upload = new Upload();
        if($filename = $upload->up($_FILES['goods_img'])) {
            $data['goods_img'] = $filename;
        } else {
            $this->jump('index.php?p=admin&c=goods&a=add',$upload->error(),3);
        }

        //  验证以及处理
        $this->helper('input');
        deepspecialchars($data);
        deepslashes($data);

        // 调用模型完成入库，并且给出相应的提示
        $goodsModel = new GoodsModel('goods');
        if($goods_id = $goodsModel->insert($data)) {
            // 成功，同时完成扩展属性的插入

            $attr_ids = $_POST['attrs_id_list'];
            $attr_values = $_POST['attr_value_list'];
            $attr_prices = $_POST['attr_price_list'];

            // 批量循环插入表单
            foreach($attr_ids as $k=>$v) {
                $list['goods_id'] = $goods_id;
                $list['attr_id'] = $v;
                $list['attr_value'] = $attr_values[$k];
                $list['attr_price'] = $attr_values[$k];

                // 调用模型完成入库
                $emptyModel = new Model('goods_attr');
                $emptyModel->insert($list);
            }
            // 给出提示
            $this->jump("index.php?p=admin&c=goods&a=index"," 添加商品成功",2);
        } else {
            $this->jump("index.php?p=admin&c=goods&a=add","添加商品失败",3);
        }

    }
 }