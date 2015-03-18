<?php
namespace Fields;
abstract class Fields {
	
	/**
	 * 组件容器
	 * @var array
	 */
	protected static $componentContainers =  array();
	
	/**
	 * 所有允许的字段
	 * @var array
	 */
	protected $allowFields = array();
	
	/**
	 * 模型别名
	 * @var array
	 */
	protected $modelAlias = array();
	
	/**
	 * 组件实例
	 * @param unknown $component
	 * @return multitype:
	 */
	public static function component($component) {
		if (!isset(self::$componentContainers[$component])) {
			$class =  "\Fields\Component\\".ucwords($component);
			self::$componentContainers[$component] = new $class;
		} 
		return self::$componentContainers[$component];
	}
	
	/**
	 * 抽象方法的实现数据的获取
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
	 * 添加字段别名
	 * @param array $alias
	 * @return \Fields\Fields
	 */
	public function modelAlias(array $alias) {
		$this->modelAlias = $alias;
		return $this;
	}
	
	/**
	 * 模型对像
	 * @param unknown $model
	 * @return \Fields\str_replace
	 */
	protected function modelObject($model) {
		//解析别名获取真正的模型
		if (isset($this->modelAlias[$model])) {
			$model = $this->modelAlias[$model];
		}
		
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
		
		//有别名则返回别名
		if ((boolean) $key = array_search($model, $this->allowFields)) {
			$model = $key;
		} 
		//替换命名空间
		else {
			$model = str_replace('\\', '_', $model);
		}
		
		return $model;
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
			return $model->fieldAttributes();
		}
		//有解析数据则传入需要解析的数据
		elseif (is_array($data) && !empty($data)) {
			$model->setFieldsData($data);
		}
		
		//解析字段规则即callable
		$fields = array();
		foreach ($model->fieldAttributes() as $key=>$values) {
			$fields[$key] = $model->resolveFieldsRule($values);
		}
		
		return $fields;
	}
	
}