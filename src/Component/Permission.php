<?php
namespace Fields\Component;
use Fields\Fields;
use Fields\FieldsInterface;
class Permission implements FieldsInterface {
	
	/**
	 * (non-PHPdoc)
	 * @see \Fields\FieldsInterface::getFields()
	 */
	public function getFields(Fields $object,array $data = array()) {
	
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