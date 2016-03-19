<?php
class AttributeModel extends Model {
    public function getPageAttrs($type_id,$offset,$pagesize) {
        $sql = 'SELECT a.* b.type_name from cl_attribute as a inner join cl_goods_type as b on a.type_id = b.type_id where a.type_id = $type.id limit $offset, $pagesize';
        return $this->db->getAll($sql);
    }

    public function getAttrsForm($type_id){
        $sql = "SELECT * FROM {$this->table} WHERE type_id = $type_id";
        $attrs = $this->db->getAll($sql);
        $res = '<table width="100%" id = "attrTable">';
        $res .= '<tbody>';

        foreach($attrs as $attr) {
            $res .= '<tr>';
            $res .= '<td>{$attr["attr_name"]}</td>';
            $res .= '<td>';
            $res .= '<input type="hidden" name="attr_id_list[] value="' . $attr['attr_id'] . '">';
            // 根据attr_input_type 不同元素生成不同的表单元素
            switch($attr['input_input_type']) {
                case 0 : #文本框
                    $res .= '<input name = "attr_list_value[]" type="text" size = "40">';
                    break;
                case 1 : #选择框
                    $res .= '<select name="attr_list_value[]">';
                    $res .= '<option  value="">请选择</option>';
                    $opts = explode(PHP_EOL,attr['attr_value']);
                    foreach ($opts as $opt) {
                        $res .= '<optin value="$opt">$opt</optin>';
                    }
                    $res .= '</select>';
                    break;
                case 2 : #多行文本
                    $res .= '<textarea name="attr_value_list[]"></textarea>';
                    break;
            }
            $res .= '<input type="hidden" name="attr_price_list[]" value="0">';
            $res .= '</td>';
            $res .= '</tr>';
        }


        $res .= '</tbody>';
        $res .= '</table>';
    }


}