<?php
namespace Fields\Component;

use Fields\FieldInterface;
use Fields\Field;
class Form implements FieldsInterface {

	/**
	 * (non-PHPdoc)
	 * @see \Fields\FieldsInterface::getFields()
	 */
	public function get(Field $object,array $data = array()) {
		
		$allowFields = array();
		
		foreach ($object->getResolveFields() as $k=>$item) {
			
			//过滤选项
			if (!empty($data) && !in_array($k,$data,true)) {
				continue;
			}
			
			$item['is_show'] == 1 && $allowFields[$k] = $item['form'];
		}
		
		return $allowFields;
	}
	
}