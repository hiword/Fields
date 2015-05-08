<?php
namespace Fields;

use Fields\Field;

interface FieldInterface {
	
// 	public function __construct(array $data = array());
	
	/**
	 * 字段abstract函数，用于设置字段规则
	 */
// 	public function fieldAttributes();

	public function get(Field $object,array $data = array());
}