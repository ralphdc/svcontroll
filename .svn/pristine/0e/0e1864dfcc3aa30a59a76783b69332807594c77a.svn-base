<?php
use Think\Model;
						
class CommonModel extends SendmessageModel {//  extends  SendmessageModel

	// 操作状态
	const MODEL_INSERT          =   1;      //  插入模型数据
	const MODEL_UPDATE          =   2;      //  更新模型数据
	const MODEL_BOTH            =   3;      //  包含上面两种方式
	const MUST_VALIDATE         =   1;      // 必须验证
	const EXISTS_VALIDATE       =   0;      // 表单存在字段则验证
	const VALUE_VALIDATE        =   2;      // 表单值不为空则验证
	
	// 当前数据库操作对象
	protected $db               =   null;
	// 主键名称
	protected $pk               =   'id';
	// 主键是否自动增长
	protected $autoinc          =   false;
	// 数据表前缀
	protected $tablePrefix      =   null;
	// 模型名称
	protected $name             =   '';
	// 数据库名称
	protected $dbName           =   '';
	//数据库配置
	protected $connection       =   '';
	// 数据表名（不包含表前缀）
	protected $tableName        =   '';
	// 实际数据表名（包含表前缀）
	protected $trueTableName    =   '';
	// 最近错误信息
	protected $error            =   '';
	// 字段信息
	//protected $fields           =   array();
	// 数据信息
	protected $data             =   array();
	protected $tradedata		=	array();
	// 查询表达式参数
	protected $options          =   array();
	protected $_validate        =   array();  // 自动验证定义
	protected $_auto            =   array();  // 自动完成定义
	protected $_map             =   array();  // 字段映射定义
	protected $_scope           =   array();  // 命名范围定义
	// 是否自动检测数据表字段信息
	protected $autoCheckFields  =   true;
	// 是否批处理验证
	protected $patchValidate    =   false;
	// 链操作方法列表
	protected $methods          =   array('order','alias','having','group','lock','distinct','auto','filter','validate','result','token');
	
	/**
	 * 架构函数
	 * 取得DB类的实例对象 字段检查
	 * @access public
	 * @param string $name 模型名称
	 * @param string $tablePrefix 表前缀
	 * @param mixed $connection 数据库连接信息
	*/
	public function __construct($name='',$tablePrefix='',$connection='') {

	}
	
	// 回调方法 初始化模型
	protected function _initialize() {
		
	}

	/**
	 * 设置数据对象的值
	 * @access public
	 * @param string $name 名称
	 * @param mixed $value 值
	 * @return void
	 */
	public function __set($name,$value) {
		// 设置数据对象属性
		$this->data[$name]  =   $value;
	}
	
	/**
	 * 获取数据对象的值
	 * @access public
	 * @param string $name 名称
	 * @return mixed
	 */
	public function __get($name) {
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	
	/**
	 * 检测数据对象的值
	 * @access public
	 * @param string $name 名称
	 * @return boolean
	 */
	public function __isset($name) {
		return isset($this->data[$name]);
	}
	
	/**
	 * 销毁数据对象的值
	 * @access public
	 * @param string $name 名称
	 * @return void
	 */
	public function __unset($name) {
		unset($this->data[$name]);
	}
	
	/**
	 * 利用__call方法实现一些特殊的Model方法
	 * @access public
	 * @param string $method 方法名称
	 * @param array $args 调用参数
	 * @return mixed
	 */
	public function __call($method,$args) {
		if(in_array(strtolower($method),$this->methods,true)) {
			// 连贯操作的实现
			$this->options[strtolower($method)] =   $args[0];
			return $this;
		}elseif(in_array(strtolower($method),array('count','sum','min','max','avg'),true)){
			// 统计查询的实现
			$field =  isset($args[0])?$args[0]:'*';
			return $this->getField(strtoupper($method).'('.$field.') AS tp_'.$method);
		}elseif(strtolower(substr($method,0,5))=='getby') {
			// 根据某个字段获取记录
			$field   =   parse_name(substr($method,5));
			$where[$field] =  $args[0];
			return $this->where($where)->find();
		}elseif(strtolower(substr($method,0,10))=='getfieldby') {
			// 根据某个字段获取记录的某个值
			$name   =   parse_name(substr($method,10));
			$where[$name] =$args[0];
			return $this->where($where)->getField($args[1]);
		}elseif(isset($this->_scope[$method])){// 命名范围的单独调用支持
			return $this->scope($method,$args[0]);
		}else{
			E(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
			return;
		}
	}

	/**
	 * 对保存到数据库的数据进行处理
	 * @access protected
	 * @param mixed $data 要操作的数据
	 * @return boolean
	 */
	protected function _facade($data) {
	
		// 检查数据字段合法性
		if(!empty($this->fields)) {
			if(!empty($this->options['field'])) {
				$fields =   $this->options['field'];
				unset($this->options['field']);
				if(is_string($fields)) {
					$fields =   explode(',',$fields);
				}
			}else{
				$fields =   $this->fields;
			}
			foreach ($data as $key=>$val){
				if(!in_array($key,$fields,true)){
					unset($data[$key]);
				}elseif(is_scalar($val)) {
					// 字段类型检查 和 强制转换
					$this->_parseType($data,$key);
				}
			}
		}
		 
		// 安全过滤
		if(!empty($this->options['filter'])) {
			$data = array_map($this->options['filter'],$data);
			unset($this->options['filter']);
		}
		$this->_before_write($data);
		return $data;
	}
	
	// 写入数据前的回调方法 包括新增和更新
	protected function _before_write(&$data) {}
	
	/**
	 * 新增数据
	 * @access public
	 * @param mixed $data 数据
	 * @param array $options 表达式
	 * @param boolean $replace 是否replace
	 * @return mixed
	 */
	public function add($data='') {

		if(empty($data)) {
			// 没有传递数据，获取当前数据对象的值
			if(!empty($this->data)) {
				$data           =   $this->data;
				// 重置数据
				$this->data     = array();
			}else{
				$this->error    = L('_DATA_TYPE_INVALID_');
				return false;
			}
		}
		
		$method = $_REQUEST['method'];
		//调用java通信接口
		$data['key'] = $this->method[$method];

		$result = $this->request_by_other($data);

		return $result;
	}
	// 插入数据前的回调方法//add by eaglezhao
	protected function _before_insert(&$data,$options) {
		 
	}
	// 插入成功后的回调方法
	protected function _after_insert($data,$options) {}
	
	
	
	
	/**
	 * 保存数据
	 * @access public
	 * @param mixed $data 数据
	 * @param array $options 表达式
	 * @return boolean
	 */
	public function save($data='',$options=array()) {
		if(empty($data)) {
			// 没有传递数据，获取当前数据对象的值
			if(!empty($this->data)) {
				$data           =   $this->data;
				// 重置数据
				$this->data     =   array();
			}else{
				$this->error    =   L('_DATA_TYPE_INVALID_');
				return false;
			}
		}
		$method = $_REQUEST['method'];
		//调用java通信接口
		$data['key'] = $this->method[$method];
		$result = $this->request_by_other($data);

		return $result;
	}
	// 更新数据前的回调方法
	protected function _before_update($postdata,$options) {
		return true;
	}
	// 更新成功后的回调方法
	protected function _after_update($data,$options) { }
	
	
	/**
	 * 删除数据
	 * @access public
	 * @param mixed $options 表达式
	 * @return mixed
	 */
	public function delete($options=array()) {
		$data           =   $this->data;
		//调用java通信接口
		$method = $_REQUEST['method'];
		$data['key'] = $this->method[$method];
		
		$result = $this->request_by_other($data,0);
		// 返回删除记录个数
		return $result;
	}
	
	/**
	 * 删除容器服务数据
	 * @access public
	 * @param mixed $options 表达式
	 * @return mixed
	 */
	public function deleteTradedata() {
		$method = $_REQUEST['tradeMethod'];
		if($method == 'deleteSubscibers'){
			$data[] = $this->tradedata;
		}else{
			$data           =   $this->tradedata;
		}
		//调用java通信接口
		$method = $_REQUEST['tradeMethod'];
		$data['method'] = $this->tradeMethod[$method];
		
		$result = $this->request_by_other($data,1);
		// 返回删除记录个数
		return $result;
	}
	
	// 删除数据前的回调方法
	protected function _before_delete($options) {
		return true;
	}
	// 删除成功后的回调方法
	protected function _after_delete($data,$options) {}
	
	/**
	 * 查询数据集
	 * @access public
	 * @param array $options 表达式参数
	 * @return mixed
	 */
	public function select($options=array()) {
	
		//调用java通信接口
		$data['key'] = $this->method['select'];
		$data = array_merge($data,$options['where']);
		$resultSet = $this->request_by_other($data);
		// 读取数据后的处理
		//$resultSet   =   $this->_read_data($resultSet,2);
		return $resultSet;
	}
	// 查询成功后的回调方法
	protected function _after_select(&$resultSet,$options) {}
	
	
	
	// 表达式过滤回调方法
	protected function _options_filter(&$options) {}
	
	/**
	 * 数据类型检测
	 * @access protected
	 * @param mixed $data 数据
	 * @param string $key 字段名
	 * @return void
	 */
	protected function _parseType(&$data,$key) {
		if(empty($this->options['bind'][':'.$key]) && isset($this->fields['_type'][$key])){
			$fieldType = strtolower($this->fields['_type'][$key]);
			if(false !== strpos($fieldType,'enum')){
				// 支持ENUM类型优先检测
			}elseif(false === strpos($fieldType,'bigint') && false !== strpos($fieldType,'int')) {
				$data[$key]   =  intval($data[$key]);
			}elseif(false !== strpos($fieldType,'float') || false !== strpos($fieldType,'double')){
				$data[$key]   =  floatval($data[$key]);
			}elseif(false !== strpos($fieldType,'bool')){
				$data[$key]   =  (bool)$data[$key];
			}
		}
	}
	
	/**
	 * 数据读取后的处理
	 * @access protected
	 * @param array $data 当前数据
	 * @return array
	 */
	protected function _read_data($data) {
		// 检查字段映射
		if(!empty($this->_map) && C('READ_DATA_MAP')) {
			foreach ($this->_map as $key=>$val){
				if(isset($data[$val])) {
					$data[$key] =   $data[$val];
					unset($data[$val]);
				}
			}
		}
		return $data;
	}
	
	/**
	 * 查询数据
	 * @access public
	 * @param mixed $options 表达式参数
	 * @return mixed
	 */
	public function findall($data,$method='findall') {
		$method = $_REQUEST['method'];
		//调用java通信接口
		$data['key'] = $this->method[$method];
		$resultSet = $this->request_by_other($data);
		return $resultSet;
	}
	
	
	/**
	 * 查询数据
	 * @access public
	 * @param mixed $options 表达式参数
	 * @return mixed
	 */
	public function findbypk() {
		//调用java通信接口
		$data['key'] = $this->method['findbypk'];
		$key = $this->pk;
		$data[$key] = $_REQUEST[$key];
		$resultSet = $this->request_by_other($data);
		// 读取数据后的处理
		//$data   =   $this->_read_data($resultSet,1);//$resultSet[0]
		return $data;
	}
	// 查询成功的回调方法
	protected function _after_find(&$result,$options) {}
	
	protected function returnResult($data,$type=''){
		if ($type){
			if(is_callable($type)){
				return call_user_func($type,$data);
			}
			switch (strtolower($type)){
				case 'json':
					return json_encode($data);
				case 'xml':
					return xml_encode($data);
			}
		}
		return $data;
	}
	
	/**
	 * 处理字段映射
	 * @access public
	 * @param array $data 当前数据
	 * @param integer $type 类型 0 写入 1 读取
	 * @return array
	 */
	public function parseFieldsMap($data,$type=1) {
		// 检查字段映射
		if(!empty($this->_map)) {
			foreach ($this->_map as $key=>$val){
				if($type==1) { // 读取
					if(isset($data[$val])) {
						$data[$key] =   $data[$val];
						unset($data[$val]);
					}
				}else{
					if(isset($data[$key])) {
						$data[$val] =   $data[$key];
						unset($data[$key]);
					}
				}
			}
		}
		return $data;
	}
	
	/**
	 * 设置记录的某个字段值
	 * 支持使用数据库字段和方法
	 * @access public
	 * @param string|array $field  字段名
	 * @param string $value  字段值
	 * @return boolean
	 */
	public function setField($field,$value='') {
		if(is_array($field)) {
			$data           =   $field;
		}else{
			$data[$field]   =   $value;
		}
		return $this->save($data);
	}
	
	
	/**
	 * 创建数据对象 但不保存到数据库
	 * @access public
	 * @param mixed $data 创建数据
	 * @param string $type 状态
	 * @return mixed
	 */
	public function create($data='',$type='') {
		// 如果没有传值默认取POST数据
		if(empty($data)) {
			foreach( $_REQUEST as $k=>$v){
				$data['data'][$k] = trim($v);
				$this->tradedata[$k] = trim($v);
				
			}
		}elseif(is_object($data)){
			$data   =   get_object_vars($data);
		}
		// 验证数据
		if(empty($data) || !is_array($data)) {
			$this->error = L('_DATA_TYPE_INVALID_');
			return false;
		}

		unset($data['data']['method']);
		unset($data['data']['tradeMethod']);
		
		// 赋值当前数据对象
		$this->data =   $data;
		// 返回创建的数据以供其他调用
		return $data;
		
	}
	
	// 自动表单令牌验证
	// TODO  ajax无刷新多次提交暂不能满足
	public function autoCheckToken($data) {
		// 支持使用token(false) 关闭令牌验证
		if(isset($this->options['token']) && !$this->options['token']) return true;
		if(C('TOKEN_ON')){
			$name   = C('TOKEN_NAME');
			if(!isset($data[$name]) || !isset($_SESSION[$name])) { // 令牌数据无效
				return false;
			}
	
			// 令牌验证
			list($key,$value)  =  explode('_',$data[$name]);
			if($value && $_SESSION[$name][$key] === $value) { // 防止重复提交
				unset($_SESSION[$name][$key]); // 验证完成销毁session
				return true;
			}
			// 开启TOKEN重置
			if(C('TOKEN_RESET')) unset($_SESSION[$name][$key]);
			return false;
		}
		return true;
	}
	
	/**
	 * 使用正则验证数据
	 * @access public
	 * @param string $value  要验证的数据
	 * @param string $rule 验证规则
	 * @return boolean
	 */
	public function regex($value,$rule) {
		$validate = array(
				'require'   =>  '/\S+/',
				'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
				'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
				'currency'  =>  '/^\d+(\.\d+)?$/',
				'number'    =>  '/^\d+$/',
				'zip'       =>  '/^\d{6}$/',
				'integer'   =>  '/^[-\+]?\d+$/',
				'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
				'english'   =>  '/^[A-Za-z]+$/',
		);
		// 检查是否有内置的正则表达式
		if(isset($validate[strtolower($rule)]))
			$rule       =   $validate[strtolower($rule)];
		return preg_match($rule,$value)===1;
	}
	
	/**
	 * 自动表单处理
	 * @access public
	 * @param array $data 创建数据
	 * @param string $type 创建类型
	 * @return mixed
	 */
	private function autoOperation(&$data,$type) {
		if(!empty($this->options['auto'])) {
			$_auto   =   $this->options['auto'];
			unset($this->options['auto']);
		}elseif(!empty($this->_auto)){
			$_auto   =   $this->_auto;
		}
		// 自动填充
		if(isset($_auto)) {
			foreach ($_auto as $auto){
				// 填充因子定义格式
				// array('field','填充内容','填充条件','附加规则',[额外参数])
				if(empty($auto[2])) $auto[2] =  self::MODEL_INSERT; // 默认为新增的时候自动填充
				if( $type == $auto[2] || $auto[2] == self::MODEL_BOTH) {
					if(empty($auto[3])) $auto[3] =  'string';
					switch(trim($auto[3])) {
						case 'function':    //  使用函数进行填充 字段的值作为参数
						case 'callback': // 使用回调方法
							$args = isset($auto[4])?(array)$auto[4]:array();
							if(isset($data[$auto[0]])) {
								array_unshift($args,$data[$auto[0]]);
							}
							if('function'==$auto[3]) {
								$data[$auto[0]]  = call_user_func_array($auto[1], $args);
							}else{
								$data[$auto[0]]  =  call_user_func_array(array(&$this,$auto[1]), $args);
							}
							break;
						case 'field':    // 用其它字段的值进行填充
							$data[$auto[0]] = $data[$auto[1]];
							break;
						case 'ignore': // 为空忽略
							if($auto[1]===$data[$auto[0]])
								unset($data[$auto[0]]);
								break;
						case 'string':
						default: // 默认作为字符串填充
							$data[$auto[0]] = $auto[1];
					}
					if(isset($data[$auto[0]]) && false === $data[$auto[0]] )   unset($data[$auto[0]]);
				}
			}
		}
		return $data;
	}
	
	/**
	 * 自动表单验证
	 * @access protected
	 * @param array $data 创建数据
	 * @param string $type 创建类型
	 * @return boolean
	 */
	protected function autoValidation($data,$type) {
		if(!empty($this->options['validate'])) {
			$_validate   =   $this->options['validate'];
			unset($this->options['validate']);
		}elseif(!empty($this->_validate)){
			$_validate   =   $this->_validate;
		}
		// 属性验证
		if(isset($_validate)) { // 如果设置了数据自动验证则进行数据验证
			if($this->patchValidate) { // 重置验证错误信息
				$this->error = array();
			}
			foreach($_validate as $key=>$val) {
				// 验证因子定义格式
				// array(field,rule,message,condition,type,when,params)
				// 判断是否需要执行验证
				if(empty($val[5]) || $val[5]== self::MODEL_BOTH || $val[5]== $type ) {
					if(0==strpos($val[2],'{%') && strpos($val[2],'}'))
						// 支持提示信息的多语言 使用 {%语言定义} 方式
						$val[2]  =  L(substr($val[2],2,-1));
					$val[3]  =  isset($val[3])?$val[3]:self::EXISTS_VALIDATE;
					$val[4]  =  isset($val[4])?$val[4]:'regex';
					// 判断验证条件
					switch($val[3]) {
						case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
							if(false === $this->_validationField($data,$val))
								return false;
								break;
						case self::VALUE_VALIDATE:    // 值不为空的时候才验证
							if('' != trim($data[$val[0]]))
								if(false === $this->_validationField($data,$val))
									return false;
									break;
						default:    // 默认表单存在该字段就验证
							if(isset($data[$val[0]]))
								if(false === $this->_validationField($data,$val))
									return false;
					}
				}
			}
			// 批量验证的时候最后返回错误
			if(!empty($this->error)) return false;
		}
		return true;
	}
	
	/**
	 * 验证表单字段 支持批量验证
	 * 如果批量验证返回错误的数组信息
	 * @access protected
	 * @param array $data 创建数据
	 * @param array $val 验证因子
	 * @return boolean
	 */
	protected function _validationField($data,$val) {
		if($this->patchValidate && isset($this->error[$val[0]]))
			return ; //当前字段已经有规则验证没有通过
		if(false === $this->_validationFieldItem($data,$val)){
			if($this->patchValidate) {
				$this->error[$val[0]]   =   $val[2];
			}else{
				$this->error            =   $val[2];
				return false;
			}
		}
		return ;
	}
	
	
	
	/**
	 * 验证数据 支持 in between equal length regex expire ip_allow ip_deny
	 * @access public
	 * @param string $value 验证数据
	 * @param mixed $rule 验证表达式
	 * @param string $type 验证方式 默认为正则验证
	 * @return boolean
	 */
	public function check($value,$rule,$type='regex'){
		$type   =   strtolower(trim($type));
		switch($type) {
			case 'in': // 验证是否在某个指定范围之内 逗号分隔字符串或者数组
			case 'notin':
				$range   = is_array($rule)? $rule : explode(',',$rule);
				return $type == 'in' ? in_array($value ,$range) : !in_array($value ,$range);
			case 'between': // 验证是否在某个范围
			case 'notbetween': // 验证是否不在某个范围
				if (is_array($rule)){
					$min    =    $rule[0];
					$max    =    $rule[1];
				}else{
					list($min,$max)   =  explode(',',$rule);
				}
				return $type == 'between' ? $value>=$min && $value<=$max : $value<$min || $value>$max;
			case 'equal': // 验证是否等于某个值
			case 'notequal': // 验证是否等于某个值
				return $type == 'equal' ? $value == $rule : $value != $rule;
			case 'length': // 验证长度
				$length  =  mb_strlen($value,'utf-8'); // 当前数据长度
				if(strpos($rule,',')) { // 长度区间
					list($min,$max)   =  explode(',',$rule);
					return $length >= $min && $length <= $max;
				}else{// 指定长度
					return $length == $rule;
				}
			case 'expire':
				list($start,$end)   =  explode(',',$rule);
				if(!is_numeric($start)) $start   =  strtotime($start);
				if(!is_numeric($end)) $end   =  strtotime($end);
				return NOW_TIME >= $start && NOW_TIME <= $end;
			case 'ip_allow': // IP 操作许可验证
				return in_array(get_client_ip(),explode(',',$rule));
			case 'ip_deny': // IP 操作禁止验证
				return !in_array(get_client_ip(),explode(',',$rule));
			case 'regex':
			default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
				// 检查附加规则
				return $this->regex($value,$rule);
		}
	}
	

	
	/**
	 * 得到当前的数据对象名称
	 * @access public
	 * @return string
	 */
	public function getModelName() {
		if(empty($this->name)){
			$name = substr(get_class($this),0,-5);
			if ( $pos = strrpos($name,'\\') ) {//有命名空间
				$this->name = substr($name,$pos+1);
			}else{
				$this->name = $name;
			}
		}
		return $this->name;
	}
	

	
	/**
	 * 返回模型的错误信息
	 * @access public
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}

	
	/**
	 * 获取主键名称
	 * @access public
	 * @return string
	 */
	public function getPk() {
		return $this->pk;
	}
	
	/**
	 * 获取数据表字段信息
	 * @access public
	 * @return array
	 */
	public function getDbFields(){
		if($this->fields) {
			$fields     =  $this->fields;
			unset($fields['_type'],$fields['_pk']);
			return $fields;
		}
		return false;
	}
	
	/**
	 * 设置数据对象值
	 * @access public
	 * @param mixed $data 数据
	 * @return Model
	 */
	public function data($data=''){
		if('' === $data && !empty($this->data)) {
			return $this->data;
		}
		if(is_object($data)){
	
			$data   =   get_object_vars($data);
		}elseif(is_string($data)){
			parse_str($data,$data);
		}elseif(!is_array($data)){
			E(L('_DATA_TYPE_INVALID_'));
		}
		$this->data = $data;
		return $this;
	}
	

	
	/**
	 * 查询SQL组装 join
	 * @access public
	 * @param mixed $join
	 * @param string $type JOIN类型
	 * @return Model
	 */
	public function join($join,$type='INNER') {
		$prefix =   $this->tablePrefix;
		if(is_array($join)) {
			foreach ($join as $key=>&$_join){
				$_join  =   preg_replace_callback("/__([A-Z_-]+)__/sU", function($match) use($prefix){ return $prefix.strtolower($match[1]);}, $_join);
				$_join  =   false !== stripos($_join,'JOIN')? $_join : $type.' JOIN ' .$_join;
			}
			$this->options['join']      =   $join;
		}elseif(!empty($join)) {
			//将__TABLE_NAME__字符串替换成带前缀的表名
			$join  = preg_replace_callback("/__([A-Z_-]+)__/sU", function($match) use($prefix){ return $prefix.strtolower($match[1]);}, $join);
			$this->options['join'][]    =   false !== stripos($join,'JOIN')? $join : $type.' JOIN '.$join;
		}
		return $this;
	}
	

	/**
	 * 指定查询字段 支持字段排除
	 * @access public
	 * @param mixed $field
	 * @param boolean $except 是否排除
	 * @return Model
	 */
	public function field($field,$except=false){
		if(true === $field) {// 获取全部字段
			$fields     =  $this->getDbFields();
			$field      =  $fields?$fields:'*';
		}elseif($except) {// 字段排除
			if(is_string($field)) {
				$field  =  explode(',',$field);
			}
			$fields     =  $this->getDbFields();
			$field      =  $fields?array_diff($fields,$field):$field;
		}
		$this->options['field']   =   $field;
		return $this;
	}
	
	/**
	 * 调用命名范围
	 * @access public
	 * @param mixed $scope 命名范围名称 支持多个 和直接定义
	 * @param array $args 参数
	 * @return Model
	 */
	public function scope($scope='',$args=NULL){
		if('' === $scope) {
			if(isset($this->_scope['default'])) {
				// 默认的命名范围
				$options    =   $this->_scope['default'];
			}else{
				return $this;
			}
		}elseif(is_string($scope)){ // 支持多个命名范围调用 用逗号分割
			$scopes         =   explode(',',$scope);
			$options        =   array();
			foreach ($scopes as $name){
				if(!isset($this->_scope[$name])) continue;
				$options    =   array_merge($options,$this->_scope[$name]);
			}
			if(!empty($args) && is_array($args)) {
				$options    =   array_merge($options,$args);
			}
		}elseif(is_array($scope)){ // 直接传入命名范围定义
			$options        =   $scope;
		}
	
		if(is_array($options) && !empty($options)){
			$this->options  =   array_merge($this->options,array_change_key_case($options));
		}
		return $this;
	}
	
	
	
	/**
	 * 指定查询数量
	 * @access public
	 * @param mixed $offset 起始位置
	 * @param mixed $length 查询数量
	 * @return Model
	 */
	public function limit($offset,$length=null){
		$this->options['limit'] =   is_null($length)?$offset:$offset.','.$length;
		return $this;
	}
	
	/**
	 * 指定分页
	 * @access public
	 * @param mixed $page 页数
	 * @param mixed $listRows 每页数量
	 * @return Model
	 */
	public function page($page,$listRows=null){
		$this->options['page'] =   is_null($listRows)?$page:$page.','.$listRows;
		return $this;
	}
	
	/**
	 * 查询注释
	 * @access public
	 * @param string $comment 注释
	 * @return Model
	 */
	public function comment($comment){
		$this->options['comment'] =   $comment;
		return $this;
	}
	
	/**
	 * 参数绑定
	 * @access public
	 * @param string $key  参数名
	 * @param mixed $value  绑定的变量及绑定参数
	 * @return Model
	 */
	public function bind($key,$value=false) {
		if(is_array($key)){
			$this->options['bind'] =    $key;
		}else{
			$num =  func_num_args();
			if($num>2){
				$params =   func_get_args();
				array_shift($params);
				$this->options['bind'][$key] =  $params;
			}else{
				$this->options['bind'][$key] =  $value;
			}
		}
		return $this;
	}
	
	/**
	 * 设置模型的属性值
	 * @access public
	 * @param string $name 名称
	 * @param mixed $value 值
	 * @return Model
	 */
	public function setProperty($name,$value) {
		if(property_exists($this,$name))
			$this->$name = $value;
		return $this;
	}
	
	/**
	 * 查询数据
	 * @access public
	 * @param mixed $options 表达式参数
	 * @return mixed
	 */
	public function findallTrade($data,$method='findall') {
		$method = $_REQUEST['tradeMethod'];
		//调用java通信接口
		$data['method'] = $this->tradeMethod[$method];
		$resultSet = $this->request_by_other($data,1);
		return $resultSet;
	}
	
	
	//调用交易服务获取数据
	public function getTradeData($method =''){
		//调用java通信接口
		$data           =   $this->tradedata;

		if($method == ''){
			$method = $_REQUEST['tradeMethod'];
		}
		$data['method'] = $this->tradeMethod[$method];
		
		if($method == 'addSubscibers'){
			$temp = $data;
			unset($data);
			$data[] = $temp;
			$data['method'] = $this->tradeMethod[$method];
		}
		$result = $this->request_by_other($data,1);
		return $result;
	}
	
	//调用交易服务获取数据
	public function getDataBase($method ='' ){
		if($method == ''){
			$method = $_REQUEST['method'];
		}
		$this->create();
		$data           =   $this->data;
		
		//调用java通信接口
		$data['key'] = $this->method[$method];
		$result = $this->request_by_other($data,0);
		return $result;
	}

	//一键复制给交易容器发送数据
	public function sendTradeData($method,$senddata){
		$data['method'] = $this->tradeMethod[$method];
		$data['data'] = $senddata;
		
		$result = $this->request_by_other($data,1);
		return $result;
	}
	
	//一键复制给数据库发送数据
	public function sendDataBase($method,$senddata){
		$data['data'] = $senddata ;
		$data['key'] = $this->method[$method];
		$result = $this->request_by_other($data,0);
		return $result;
	}
	
	//给渠道切换发送数据
	public function sendChannelData($method,$senddata=''){
		//$this->create();
		$data           =   $_POST;
		$data['method'] = $this->method[$method];
		$result = $this->request_by_other($data,2);
		return $result;
	}
	
	//给流水监控发送数据
	public function sendWatermoniBase($method,$senddata=''){
		if($method == 'strategyDelete'||$method == 'batchstrategyDelete'){
			$data = $senddata ;
		}else{
			if($senddata['page'] !=''){
				$data['page'] = $senddata['page'];
				unset($senddata['page']);
			}
			$data['data'] = $senddata ;
		}
		$data['key'] = $this->method[$method];
		$result = $this->request_by_other2($data);
		return $result;
	}
	
	//给权重服务和ice服务发送消息
	public function sendJavaData($method,$senddata=''){
		$data['data'] = $senddata ;
		$data['key'] = $this->method[$method];
		$post['data']['systemflag'] = $_SESSION['SYSTEM_FLAG'];
		$result = $this->sendmessage($data);
		return $result;
		
	}
	
	//服务质量监控和主机质量监控 韦庆丁
	public function sendHostSerqualitBase($urlpath){
		$data           =   $_REQUEST;
	
		//调用java通信接口
		//$urlpath = $this->method[$method];
		//$urlpath = str_replace("WEB_ENVIRONMENT", $_SESSION['WEB_ENVIRONMENT'], $urlpath);
		$result = $this->request_by_HostSerqualit($data,$urlpath);
		return $result;
	}
	
	

}
?>