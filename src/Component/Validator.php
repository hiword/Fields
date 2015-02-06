<?php
namespace Fields\Component;
use Fields\Fields;
class Validator extends Fields {
	
	/**
	 * 获取字段验证规则
	 * @return multitype:Ambigous <NULL>
	 */
	public function get(array $models,array $data = array()) {
		
		foreach ($models as $model) {
			$this->allowFields[parent::modelString($model)] = $this->allowFields($model,$data);
		}
		
		return parent::returnAllowFields();
	} 
	
	/**
	 * 获取允许的可操作字段
	 * (non-PHPdoc)
	 * @see \Fields\Fields::allowFields()
	 */
	protected function allowFields($model, $data = false) {
		
		$allowFields = array();
		
		foreach (parent::modelFields($model,null)  as  $key=>$values) {
			if (!empty($values['validator_php']) && isset($data[$key])) {
				$allowFields[$key] = $values['validator_php'];
			}
		}
		
		return $allowFields;
	}
	
}