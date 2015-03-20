<?php
namespace Fields;
abstract class Fieldsa {
	
	/**
	 * 所有允许的字段
	 * @var array
	 */
	protected $allowFields = array();
	
	/**
	 * 模型别名
	 * @var array
	 */
	protected $alias = array();
	
	/**
	 * 获取字段结果
	 * @param unknown $object
	 * @param array $data
	 */
	abstract public function getFields($object,array $data = array());
	
	/**
	 * 抽象方法的实现数据的获取
	 * @param array|string $model
	 */
	abstract public function get($object,array $data = array());
	
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
	public function alias(array $alias) {
		$this->alias = $alias;
		return $this;
	}
	
	/**
	 * 模型对像
	 * @param unknown $model
	 * @return \Fields\str_replace
	 */
	protected function getObject($objectName) {
		//解析别名获取真正的模型
		if (isset($this->alias[$objectName])) {
			$objectName = $this->alias[$objectName];
		}
		
		$objectNamespace = ucwords(str_replace(['_','-'], '\\', $objectName));
		return new $objectNamespace;
	}
	
	/**
	 * 转换对象名
	 * @param string|object $model
	 * @return mixed
	 */
	protected function getObjectName($object) {
		
		is_object($object) && $object = get_class($object);
		
		//有别名则返回别名
		if ((boolean) $object = array_search($object, $this->alias)) {
			$model = $key;
		} 
		//替换命名空间
		else {
			$object = str_replace('\\', '_', $object);
		}
		
		return $object;
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