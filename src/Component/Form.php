<?php
namespace Fields\Component;
use Fields\Fields;
class Form extends Fields {
	
	/**
	 * 数据结果集获取入口
	 * (non-PHPdoc)
	 * @see \Fields\Fields::get()
	 */
	public function get(array $models,array $data = array()) {
		
		//解析model
		$models = $this->model($models);
		
		foreach ($models as $model=>$fields) {
			
			$allowFields = $this->allowFields($model,$data);
			
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
	 * 组合模型key=>value值
	 * @param string|array $model
	 * @return array
	 */
	protected function model($model) {
		//一维数组自动添加*所有字段
		if (is_array($model) && count($model)===count($model,true)) {
			$model = array_combine($model, array_pad(array(), count($model), '*'));
		}
		
		return $model;
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