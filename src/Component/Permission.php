<?php
namespace Fields\Component;
use Fields\FieldInterface;
use Fields\Field;
class Permission implements FieldInterface {
	
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
				
			isset($item['is_fillable']) && $item['is_fillable'] == 1 && $allowFields[$k] = $k;
		}
	
		return $allowFields;
	}
	
}