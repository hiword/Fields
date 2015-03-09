<?php
namespace Fields\Traits;
trait Fields {
	
	/**
	 * 字段数值值-主要用于show的时候在callable中调用返回即setFieldsCallable中使用
	 * @var array
	 */
// 	protected static $fieldsData = array();
	
	protected static $requestData = array();
	
// 	/**
// 	 * 字段abstract函数，用于设置字段规则
// 	 */
// 	abstract public function fields();
	
	/**
	 * 设置字段数据值
	 * @param array $data
	 */
// 	public function setFieldsData(array $data) {
// 		self::$fieldsData = $data;
// 		return $this;
// 	}
	
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
// 				dd($value);exit();
// 				\ReflectionParameter::export($function, $parameter)
// 				$ReflectionFunction = new \ReflectionFunction($value);
// 				$params = array();
// 				foreach ($ReflectionFunction->getParameters() as $param) {
// 					echo 'param name: ' . $param->getName(),"\n";
// // 					dd( $param->isOptional());
// // 					if ($param->isOptional()) {
// 						echo 'Default value: ' . $param->getValue(),"\n";
// // 					}
// 				}
// 				exit();
// 				foreach ($ReflectionFunction->getParameters() as $param) {
// 					$params[] = $param;
					
					
// 				}
// 				dd($params);exit();
// 				dd($ReflectionFunction->getParameters()[0]->reflection);
// 				$value = call_user_func_array($value, $ReflectionFunction->getParameters());
// 				print_r($value);exit();
				
			} elseif (method_exists($this, $method = "{$key}FieldRule")) {//method_Exists
				$value = $this->$method();
			}
			
		}
// 		print_r($array);exit();
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