<?php
class IndexController extends Controller {
    // 载入首页
    public function indexAction() {
        $categoryModel = new CategoryModel('category');
        $frontCats = $categoryModel->frontCats();

        // 获取商品推荐
        $goodsModel = new GoodsModel('goods');
        $bestGoods = $goodsModel->getBestGoods();
        include CUR_VIEW_PATH . "index.html";
    }
}