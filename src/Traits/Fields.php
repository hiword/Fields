<?php
namespace Fields\Traits;
use Fields\Fields;
trait Fields {
	
	/**
	 * 字段数据值，主要用于callable
	 * @var array
	 */
	protected static $fieldsData = array();
	
	/**
	 * 字段值的设置
	 * 此处不止包含于VALUE，其它属性仍然可以
	 * @param array $data
	 */
	public function setFieldsData(array $data) {
		self::$fieldsData = $data;
	}
	
	/**
	 * Model字段的定义
	 */
	abstract public function fields();
	
	/**
	 * 解析数组callabel
	 * @param array $array
	 * @return array
	 */
	public function setFieldsCallable(array $array) {
		foreach ($array as $key=>&$value) {
			if (is_array($value)) {
				$value = $this->setFieldsCallable($value);
			} elseif (is_callable($value)) {//callable
				$value = call_user_func($value);
			} elseif (strpos($value, '_fieldCallable') !== false) {//当前类方法，
	
			}
		}
		return $array;
	}
	
	/**
	 * 过滤获取白名单数据
	 * @param array $data
	 * @param string|array $model
	 * @return array
	 */
	public function filterFillableData($data,array $model = array()) {
		$Permission = Fields::factory('Permission');
		$fields = $Permission->get(empty($model) ? array($this) : $model);
	
		foreach ($data as $key=>$value) {
			if (!in_array($key, $fields,true)) unset($data[$key]);
		}
		return $data;
	}
	
	/**
	 * 设置字段值函数操作
	 * @param array $data
	 * @param string $action
	 * @return unknown
	 */
	public function setFieldsFormat(array $data,$action = '') {
	
		foreach ($data as $key=>&$value) {
	
			$actionMethod = "_{$action}{$key}Format";
			$method = "_{$key}Format";
	
			if (method_exists($this, $actionMethod)) {
				$value = $this->$actionMethod($value);
			} elseif (method_exists($this, $method)) {
				$value = $this->$method($value);
			}
				
		}
		return $data;
	}
	
}