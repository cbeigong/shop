<?php
//	function deepslasheds($data) {
//	if(empty($data)) {
//		return $data;
//	} else if (is_array($data)) {
//		foreach($data as $v) {
//			return deepslasheds($v);
//		}
//	} else {
//		return addslashes($data);
//	}
	// 第二种用map的写法
	function deepslashes($data) {
		if(empty($data)) {
			return $data;
		} else {
			return is_array($data)?array_map(deepslashes,$data) : addslashes($data);
		}
}
	// 批量转义特殊字符 防止xss攻击
	function deepspecialchars($data) {
		if(empty($data)) {
			return $data;
		} else {
			return is_array($data) ? array_map('deepspecialchars',$data):htmlspecialchars($data);
		}
	}

