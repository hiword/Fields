<?php
namespace Fields\Component;
use Fields\Fields;
class Permission extends Fields {
	
	
	/**
	 * 允许操作的字段接口
	 * (non-PHPdoc)
	 * @see \Fields\Fields::get()
	 */
	public function get(array $models,array $data = array()) {
		
		foreach ($models as $model) {
			$this->allowFields[parent::modelString($model)] = $this->allowFields($model);
		}
		
		return parent::returnAllowFields();
	}
	
	/**
	 * 允许的字段
	 * (non-PHPdoc)
	 * @see \Fields\Fields::allowFields()
	 */
	protected function allowFields($model,$data = false) {
		
		$allowFields = array();
		
		foreach (parent::modelFields($model,$data) as $k=>$item) {
			$item['is_fillable'] == 1 && $allowFields[$k] = $k;
		}
		return $allowFields;
	}
	
}