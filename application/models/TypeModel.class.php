<?php
    class TypeModel extends Model {
//        public function getTypes($offset, $pagesize) {
//            $sql = "SELECT * FROM {$this->table} ORDER_BY type_id LIMIT $offset,$pagesize";
//            return $this->db->getAll($sql);
//        }
        // 分页获取商品类型数据 改进版
        public function getTypes($offset,$pagesize) {
            $sql = "SELECT a.*,COUNT(b.attr_name) AS num FROM {$this->table} AS a LEFT JOIN cl_attribute AS b ON a.type_id=b.type_id GROUP BY a.type_id ORDER BY type_id LIMIT $offset,$pagesize";
            return $this->db-getAll($sql);
        }
    }