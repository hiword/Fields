<?php
namespace Fields\Component;
use Fields\FieldsInterface;
class Validator implements FieldsInterface {
	
	/**
	 * (non-PHPdoc)
	 * @see \Fields\FieldsInterface::getFields()
	 */
	public function get(Fields $object,array $data = array()) {
	
		$allowFields = array();
	
		foreach ($object->getResolveFields() as $k=>$item) {
	
			//过滤选项
			if (!empty($data) && !in_array($k,$data,true)) {
				continue;
			}
	
			if (!empty($item['validator_php']) && isset($data[$k])) {
				$allowFields[$k] = $item['validator_php'];
			}
		}
	
		return $allowFields;
	}
	
}