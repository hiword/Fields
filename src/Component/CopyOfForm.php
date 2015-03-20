<?php
namespace Fields\Component;
use Fields\Fields;
use Fields\FieldsInterface;

class Forma implements FieldsInterface {
	
	
	
	public function getFields($object,array $data = array()) {
		
	}
	
	/**
	 * 数据结果集获取入口
	 * (non-PHPdoc)
	 * @see \Fields\Fields::get()
	 */
	public function get($object,array $data = array()) {
		
		$allowFields = $this->allowFields($object,$data);
		
		//解析model
		$models = $this->model($models);
		
		foreach ($models as $model=>$fields) {
			
			
			
			if ($fields === '*') {
				$this->allowFields[$model] = $allowFields;
			} else {
				if (is_string($fields)) {
					$fields = explode(',', $fields);
				}
				foreach ($allowFields as $k=>$item) {
					in_array($k, $fields,true) && $this->allowFields[$model][$k] = $item;
				}
			}
		}
		return parent::returnAllowFields();
	}
	
	/**
	 * 允许显示的模型字段
	 * @param unknown $model
	 * @return multitype:Ambigous <NULL>
	 */
	protected function allowFields($model,$data = array()) {
		$allowFields = array();

		foreach (parent::modelFields($model,$data) as  $k=>$item) {
			$item['is_show'] == 1 && $allowFields[$k] = $item['form'];
		}
		return $allowFields;
	}
	
}