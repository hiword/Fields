<?php
namespace Fields\Component;
use Fields\FieldInterface;
use Fields\Field;
class Validator implements FieldInterface {
	
	/**
	 * (non-PHPdoc)
	 * @see \Fields\FieldsInterface::getFields()
	 */
	public function get(Field $object,array $data = array()) {
		
		$allowFields = array();
		
		foreach ($object->getResolveFields($data) as $k=>$item) {
			
			//过滤选项
// 			if (!empty($data) && !in_array($k,$data,true)) {
// 				continue;
// 			}
	
			if (!empty($item['validator_php'])) {
				$allowFields[$k] = $item['validator_php'];
			}
		}

		return $allowFields;
	}
	
}