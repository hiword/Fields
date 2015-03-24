<?php
namespace Fields;
abstract class Field {
	
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
		static::$requestData = $data;
		return $data;
	}
	
	/**
	 * 字段属性
	 */
	abstract public function fieldAttributes();
	
	/**
	 * 解析字段规则，主要用于显示时解析callable或内置字段方法
	 * @param array $data
	 * @return array $array
	 */
	public function getResolveFields(array $data = array()) {
	
		//
		empty($data) && $data = $this->fieldAttributes();
		
		//
		foreach ($data as $key=>&$items) {
				
			if (is_array($items) && $items) 
			{
				$items = $this->getResolveFields($items);
			} 
			elseif (is_callable($items)) 
			{//callable
				$items = call_user_func($items);
			} 
// 			elseif (method_exists($this, $method = "{$key}FieldRule")) 
// 			{//method_Exists
// 				$value = $this->$method();
// 			}
				
		}
		return $data;
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
				
			if(method_exists($this, $method = "{$key}{$action}Value")) 
			{
				$value = $this->$method($value);
			} 
			elseif (method_exists($this,$method = "{$key}Value")) 
			{
				$value = $this->$method($value);
			}
			
			
		}
		return $data;
	}
	
}