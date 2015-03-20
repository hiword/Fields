<?php
namespace Fields;

use Fields;

interface FieldsInterface {
	
	/**
	 * 字段abstract函数，用于设置字段规则
	 */
// 	public function fieldAttributes();

	public function getFields(Fields $object,array $data = array());
}