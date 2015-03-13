<?php
namespace Fields\Traits;
trait Fields {
	
	/**
	 * 请求数据
	 * @var array
	 */
	protected static $requestData = array();
	
	/**
	 * 设置请求数据
	 * @param array $data
	 * @return array
	 */
	public static function setRequestData(array $data) {
		self::$requestData = $data;
		return $data;
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
			} elseif (is_callable($value)) {//callable
				$value = call_user_func($value);
			} elseif (method_exists($this, $method = "{$key}FieldRule")) {//method_Exists
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
	protected function setFieldsValue(array $data,$action = '') {
		
		!empty($action) && $action = ucwords($action);
		
		foreach ($data as $key=>&$value) {
			
			if(method_exists($this, $method = "{$key}{$action}Value")) {
				$value = $this->$method($value);
			} elseif (method_exists($this,$method = "{$key}Value")) {
				$value = $this->$method($value);
			}
			
		}
		return $data;
	}
	
}