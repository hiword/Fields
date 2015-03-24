<?php
namespace Fields;

use Field;

interface FieldInterface {
	
	/**
	 * 字段abstract函数，用于设置字段规则
	 */
// 	public function fieldAttributes();

	public function get(Field $object,array $data = array());
}