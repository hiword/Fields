<?php
namespace Fields;
abstract class Field {
	
	/**
	 * 请求数据
	 * @var array
	 */
	protected static $request = null;
	
	/**
	 * 设置请求数据
	 * @param array $data
	 * @return array
	*/
	public static function setRequest($request) {
		return static::$request = $request;
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
	public function getResolveFields(array $data = array('*'),array $attributes = array()) {
	
		empty($data) && $data = array('*');
		
		//
		empty($attributes) && $attributes = $this->fieldAttributes();
		//
		foreach ($attributes as $key=>&$items) {
			
			if ($data !== array('*') && !in_array($key, $data,true))
			{
				//不存在则删除
				unset($attributes[$key]);
				continue;
			}
			
			if (is_array($items) && $items) 
			{
				//当$key是第二次循环的时候，好像不再是字段key，所以传入array(*)，先这样回头再测试
				$items = $this->getResolveFields(array('*'),$items);
			} 
			//is_string是为了解决，有内部函数名与字符串冲突
			elseif (is_callable($items) && !is_string($items)) 
			{//callable
				$items = call_user_func($items);
			} 
// 			elseif (method_exists($this, $method = "{$key}FieldRule")) 
// 			{//method_Exists
// 				$value = $this->$method();
// 			}
				
		}
		
		return $attributes;
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