<?php
namespace Fields;
use Illuminate\Support\Arr;
abstract class Fields {
	
	protected static $components = [];
	protected $allowFields = array();
	
	public static function factory($component) {
		if (!isset(self::$components[$component])) {
			$class =  "\Fields\Component\\".ucfirst($component);
			self::$components[$component] = new $class;
		} 
		return self::$components[$component];
	}
	
	/**
	 * 抽象方法的实现
	 * @param array|string $model
	 */
	abstract public function get(array $models,array $data = array());
	
	/**
	 * 获取允许的字段
	 * @param string|object $model
	 * @param bool|array $resolve
	 */
	abstract protected function allowFields($model,$data = array());
	
	/**
	 * 模型对像
	 * @param unknown $model
	 * @return \Fields\str_replace
	 */
	protected function modelObject($model) {
		$model = str_replace(' ', '\\', ucwords(str_replace(['_','-'], ' ',$model)));
		return new $model;
	}
	
	/**
	 * 转换对象名
	 * @param string|object $model
	 * @return mixed
	 */
	protected function modelString($model) {
		$model = is_object($model) ? get_class($model) : $model;
		return str_replace('\\', '_', $model);
	}

	/**
	 * 返回允许的字段
	 * @return Ambigous <unknown, mixed>
	 */
	protected function returnAllowFields() {
		return count($this->allowFields)===1 ? array_shift($this->allowFields) : $this->allowFields;
	}
	
	/**
	 * 模型字段
	 * @param object|string $model
	 * @param boolean|array $data 是否解析  FALSE:不解析  Array:值给模型注入数据值
	 * @throws \Exception
	 * @return array
	 */
	protected function modelFields($model,$data = false) {
		
		!is_object($model) && $model = $this->modelObject($model);
		
		//数据值为false则不会执行字段callable解析
		if ($data === false) {
			return $model->fields();
		} elseif (is_array($data) && !empty($data)) {
			//传入需要解析的数据
			$model->setFieldsData($data);
		}
		
		$fields = array();
		foreach ($model->fields() as $key=>$values) {
			$fields[$key] = $model->setFieldsCallable($values);
		}
		return $fields;
	}
// 	/**
// 	 * 模型字段
// 	 * @param object $model
// 	 * @param boolean|array $resolve
// 	 * @throws \Exception
// 	 * @return array
// 	 */
// 	protected function modelFields($model,$resolve = true) {
		
// 		!is_object($model) && $model = $this->modelObject($model);
		
// 		//不解析的情况下直接返回
// 		if (is_bool($resolve) && !$resolve) {
// 			return $model->fields();
// 		} elseif (is_array($resolve)) {//需要解析的数组
// 			$array = $resolve;
// 		} else {
// 			throw new \Exception('Illegal parameter!', E_USER_ERROR);
// 		}
// 		$fields = array();
// 		foreach ($model->fields() as $key=>$values) {
// 			if (!empty($array) && !in_array($key, $array,true)) {
// 				continue;
// 			}
// 			$fields[$key] = $model->setFieldsCallable($values);
// 		}
// 		return $fields;
// 	}
	
}