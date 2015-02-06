<?php
namespace Fields\Component;
use Fields\Fields;
class Permission extends Fields {
	
	
	public function get(array $models,array $data = array()) {
		
		foreach ($models as $model) {
			$this->allowFields[parent::modelString($model)] = $this->allowFields($model);
		}
		
		return parent::returnAllowFields();
	}
	
	
	protected function allowFields($model,$data = false) {
		
		$allowFields = array();
		
		$fields = parent::modelFields($model,$data);
		foreach ($fields as $k=>$item) {
			$item['is_fillable'] == 1 && $allowFields[] = $k;
		}
		return $allowFields;
	}
	
}