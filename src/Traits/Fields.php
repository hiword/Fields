<?php
namespace Fields\Traits;
trait Fields {
	
	/**
	 * 字段数值值-主要用于show的时候在callable中调用返回即setFieldsCallable中使用
	 * @var array
	 */
	protected static $fieldsData = array();
	
	/**
	 * 字段abstract函数，用于设置字段规则
	 */
	abstract public function fields();
	
	/**
	 * 设置字段数据值
	 * @param array $data
	 */
	public function setFieldsData(array $data) {
		self::$fieldsData = $data;
		return $this;
	}
	
	/**
	 * 解析字段规则，主要用于显示时解析callable或内置字段方法
	 * @param array $array
	 * @return array $array
	 */
	public function resolveFieldsRule(array $array) {
		foreach ($array as $key=>&$value) {
			
			if (is_array($value)) {
				$value = $this->resolveFieldsRule($value);
			} elseif (is_callable($value)) {//callabel
				$value = call_user_func($value);
			} elseif (method_exists($this, $method = "_{$key}FieldRule")) {//method_Exists
				$value = $this->$method();
			}
			
		}
		return $array;
	}
	
	/**
	 * 设置入库时的字段值
	 * @param array $data
	 * @param string $action  Add|Edit
	 * @return array
	 */
	public function setFieldsValue(array $data,$action = '') {
		
		!empty($action) && $action = ucwords($action);
		
		foreach ($data as $key=>&$value) {
			
			if(method_exists($this, $method = "_{$key}{$action}Value")) {
				$value = $this->$method($value);
			} elseif (method_exists($this,$method = "_{$key}Value")) {
				$value = $this->$method($value);
			}
			
		}
		return $data;
	}
// 	public function setFieldsValue(array $data,$action = '') {
// 		foreach ($data as $key=>&$value) {
// 			$actionMethod = "_{$action}{$key}Format";
// 			$method = "_{$key}Format";
// 			if(method_exists($this, $actionMethod)) {
// 				$value = $this->$actionMethod($value);
// 			} elseif (method_exists($this,$method)) {
// 				$value = $this->$method($value);
// 			}
// 		}
// 		return $data;
// 	}
	
}