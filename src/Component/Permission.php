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
		
		return $object->getResolveFields($data);
		
	}
	
}