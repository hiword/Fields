<?php
namespace Fields\Component;
use Fields\FieldInterface;
use Fields\Field;

class Form implements FieldInterface {

	/**
	 * (non-PHPdoc)
	 * @see \Fields\FieldsInterface::getFields()
	 */
	public function get(Field $object,array $data = array()) {
		
		$allowFields = array();
		
		foreach ($object->getResolveFields($data) as $k=>$item) {
			
			!empty($item['form']) && !empty($item['form']['role']) && $allowFields[$k] = $item['form'];
			
		}
		
		uasort($allowFields,function ($a,$b){
			$sort1 = isset($a['sort']) ? intval($a['sort']) : 0;
			$sort2 = isset($b['sort']) ? intval($b['sort']) : 0;
			return $sort2 - $sort1 ;
		});
		
		return $allowFields;
	}
	
}