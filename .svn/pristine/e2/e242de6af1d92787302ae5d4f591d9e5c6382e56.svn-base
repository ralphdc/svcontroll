<?php
/**
 * 服务管制和java通信公共数据接口类
 * @author zengguangqiu
 *
 */
class CommunicationModel {
	

	var $method =array();
	var $public_method=array(
	     'replaceparam'=>'xgd.auth.check.parammap',
	     'permentry'=>'xgd.auth.check.permentry',
	);
	var $primaryKey = 'seqid';
	var $count = '';
	var $server = '/omp/servicectrol';
	/**
	 * 设置查询的字段和显示字段
	 * @var array
	 */
	var $pareTable = array();
	
	/**
	 * 外键映射数组,foreignKey1为需要映射的外键,有多个。
	 * tableClass 对应表的类名
	 * mappingKey 对应外表的字段名称
	 * displayKey 显示的字段名称
	 * externKeys 附加条件数组
	 * @var array
	 */
	
	/**
	 * 模糊搜索组合字段
	 * @var unknown_type
	 */
	
	var $inStr = '';
	/**
	 * 
	 * 数据库查找字段
	 * @var string
	 */
	var $fields = '';
	
	/**
	 * LEFT JOIN 外表附件条件
	 * @var string
	 */
	var $externSql = '';
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录条数
	 * @param array $post
	 * @return int
	 */
	function countByPost ($post, $get) {
		if(empty($this->count)){
		   $this->count = 0;
		}
		return $this->count;	
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
	  	$Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
		if ($post['numPerPage']!='') {
			setcookie('numPerPage',$post['numPerPage']);
			$numPer = $post['numPerPage'];
		}
		else {
			$numPer = $_COOKIE['numPerPage']!=0 ?$_COOKIE['numPerPage'] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		$post['method']=$this->method['index'];
		$post['pageno']=intval($Num);
		$post['pagesize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$this->count = $array['count'];
		return $array['data'];
	}
	function getAll ($post, $get) {
	  	
		$post['method']=$this->method['getAll'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other( $post);
		$array = json_decode($array,true);
		$this->count = $array['count'];
		return $array['data'];
	}
	/**
	 * 针对每个动作  验证
	 * Enter description here ...
	 */
	function  validatePermition($code){
		$data = array(
		    'username'=>'',
		    'test_add'=>''
		);
		return true;
	}
	
	/**
	 * 需将当前用户id   和entrycode传进去
	 * 产品id
	 * Enter description here ...
	 * @param unknown_type $code
	 */
	function valideatePermEntry($code,$productid){
		$post['method']=$this->public_method['permentry'];
		//产品ID从配置文件中读取		
		$productid = FLEA::getAppInf('app_products');
		$post['productid']=$productid[0]['productid'];
		$post['entrycode']=$code;
		$post['session']=$_SESSION['MPOSSESS']['session'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		return json_decode($array,true);
	}
	
	function postSave($post,$get=null){
		$result = '';
		if($post['form_act']=='createShellscript'){
			$post['key'] = $this->method['createShellscript'];
			$post = $this->formatPost($post,$get);			
			$result =$this->request_by_other( $post);
			//dump($result);
		}elseif($post['form_act']=='updateShellscript'){
			$post['key'] = $this->method['updateShellscript'];
			$post = $this->formatPost($post,$get);
			//dump($post);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='deleteShellscript'){
			$post['key'] = $this->method['deleteShellscript'];
			$post = $this->formatPost($post,$get);
			//dump($post);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='searchShellscript'){
			$post['key'] = $this->method['searchShellscript'];
			$post = $this->formatPost($post,$get);
			//dump($post);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='addItemKind'){
			$post['key'] = $this->method['addItemKind'];
			$post = $this->formatPost($post,$get);			
			$result =$this->request_by_other( $post);
			//dump($result);
		}elseif($post['form_act']=='addItem'){
			$post['key'] = $this->method['addItem'];
			$post = $this->formatPost($post,$get);
			//dump($post);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='addInstanceKind'){
			$post['key'] = $this->method['addInstanceKind'];
			$post = $this->formatPost($post,$get);
			//dump($post);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='addInstance'){
			$post['key'] = $this->method['addInstance'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='updateItemKind'){
			$post['key'] = $this->method['updateItemKind'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='updateItem'){
			$post['key'] = $this->method['updateItem'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='updateInstanceKind'){
			$post['key'] = $this->method['updateInstanceKind'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='updateInstance'){
			$post['key'] = $this->method['updateInstance'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);updateInstance
		}elseif($post['form_act']=='deleteItemKind'){
			$post['key'] = $this->method['deleteItemKind'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='getIpProductTree'){
			$post['key'] = $this->method['getIpProductTree'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='getInstanceDetail'){
			$post['key'] = $this->method['getInstanceDetail'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='getRepConfigTree'){
			$post['key'] = $this->method['getRepConfigTree'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='getInstanceDetail'){
			$post['key'] = $this->method['getInstanceDetail'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
			//dump($post);
		}elseif($post['form_act']=='createPlans'){
			$post['key'] = $this->method['createPlans'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='createconfig'){
			$post['key'] = $this->method['createconfig'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}
		return json_decode($result,true);
	}
	
	function findByPk($get){
		$post['method']=$this->method['get'];
		$post[$this->primaryKey]=$get[$this->primaryKey];
		$post = $this->formatPost($post);
		$result = $this->request_by_other( $post);
		return json_decode($result,true);
	}
	
	function postRemove($pk){
		$data=array(
		     'method'=>$this->method['delete'],
		     $this->primaryKey=>$pk,
		);
		$data = $this->formatPost($data);
		$result = $this->request_by_other( $data);
		return json_decode($result,true);
	}
	
	function findCount($post){
		//验证唯一性
		$post['method']=$this->method['get'];
		$post = $this->formatPost($post);
		$result = $this->request_by_other( $post);
		$array = json_decode($result,true);
		if(isset($array['object'])&& !empty($array['object']) ){
			return 1;
		}else{
			return 0;
		}
	}
	
	function replaceParam($key){
		$post['paramno']=$key;
		$post['method']=$this->public_method['replaceparam'];
		$post= $this->formatPost($post);
		$result = json_decode($this->request_by_other($post),true);
		return $result;
	}
	
	function formatPost($post,$get=null){
		//添加系统参数
		date_default_timezone_set('Asia/Shanghai');
		$post['ver']='v1.0';
		$post['encoding']='utf-8';
		$post['timestamp']=date('Y-m-d H:i:s');
		$post['format']='json';
		//新增加环境数据
		$post['data']['submitor'] = $_SESSION['cUserNo'];
		$post['data']['envType']= trim($_SESSION['WEB_ENVIRONMENT']);
		$post['envType']= trim($_SESSION['WEB_ENVIRONMENT']);
		$post['data']['environment']= trim($_SESSION['WEB_ENVIRONMENT']);
		//appid
		//$post['appid']='0001';
		$post['signtype']='md5';
		$post['cuserid']=intval($_SESSION['MPOSSESS']['userid']);
		if(isset($get)){
			foreach ($get as $key =>$val){
				if(isset($this->pareTable['getColumns'])){
					if(in_array($key,$this->pareTable['getColumns']) &&isset($val[$key])){
						$post[$key]=$val;
					}	
				}else{
					break;
				}
				
			}
		}
		return $post;
	}
	
	
	
/**

 * Curl版本

 * 使用方法：

 * $post_string = "app=request&version=beta";

 * request_by_other('http://facebook.cn/restServer.php',$post_string);

 */

	function request_by_other( $post_string)

	{
		$str = json_encode($post_string);
		Think\Log::write("////////////////////////////// request_by_other post is ".$str);
		Think\Log::write("////////////////////////////// URL post is ".C('SERVICE_JAVA_NAME').$this->server);
// 		dump($str);
		
		$context = array(

        	'http' => array(

            'method' => 'POST',
        	
        	'timeout'=>600,
        			 
            'header' => 
        			
        				'Content-type: application/x-www-form-urlencoded' .

                        '\r\n'.'User-Agent : Jimmy\'s POST Example beta' .

                        '\r\n'.'Content-length:' . strlen($str) + 8,

            'content' => 'json='.$str.'&sign='.md5($str).'&customProperty='.$post_string['customProperty'],
		)

        );
		
	    $stream_context = stream_context_create($context);
		
	    $data = file_get_contents(C('SERVICE_JAVA_NAME').$this->server, false, $stream_context);
	    
        Think\Log::write("request_by_other file_get_contents data is".$data);

	
	    return $data;
	}
	
	/**
	 * 请求C++监控服务
	 * @param string $fucname
	 * @param array $option
	 * @return mixed
	 */
	function requestBySoap($fucname,$option){
		$soap_url = C('MNT_GSOAP_SERVER_DealNotice');
		header("Content-Type: text/html; charset=utf-8");
		$soap = new SoapClient($soap_url);
		$soap->soap_defencoding = 'utf-8';
		$soap->xml_encoding = 'utf-8';
		try{
			$ret = $soap->__soapCall($fucname,$option);
			return $ret;
		}catch(Exception $e){
			return $e->getMessage();
		}
	
	}
	/**
	 * 请求C++监控报警服务
	 * @param string $fucname
	 * @param array $option
	 * @return mixed
	 */
	function requestBySoapForMoni($fucname,$option){
		$soap_url = C('MNT_GSOAP_SERVER');
		header("Content-Type: text/html; charset=utf-8");
		$soap = new SoapClient($soap_url);
		$soap->soap_defencoding = 'utf-8';
		$soap->xml_encoding = 'utf-8';
		try{
			$ret = $soap->__soapCall($fucname,$option);
			return $ret;
		}catch(Exception $e){
			return $e->getMessage();
		}
	
	}
	/**
	 * 
	 * php crul请求其他服务器脚本数据
	 * @param string $url
	 * @param Array $param
	 */
	function phpCrulRequest($url,$param=null)
	{
		
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		$output = curl_exec($ch) ;
		return json_decode($output);
	}
	

	
	function request_by_otherUrl($url, $post_string)
	
	{
		$str = json_encode($post_string);
		$url .= '?jsonParams='.$str;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		return json_decode($output,TRUE);
		
	}
	
	
	function do_service($url,$param,$method='POST')
	{
	   
	    $psr = parse_url($url);
	    $host = $psr['host'];
	    $port = $psr['port'];
	    $errno = '';
	    $errstr = '';
	    $timeout = 30;
	    $path = $psr['path'];
	    
	    
	    $msg = "";
	    $msglen = count($param);
	    $msgI=0;
	    foreach ($param as $pk=>$pv){
	        $msgI ++;
	        $msg .= $pk."=".$pv;
	        $splitTag = $msgI == $msglen ? "" : "&";
	        $msg .= $splitTag;
	    }
	    
	    $path = $path.'?'.$msg;
	    
	    $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	    
	    if(!$fp){
	        return false;
	    }
	    
	    $jsid = trim(cookie('JSID'));
	    if($jsid)  $cookie = "JSESSIONID=".$jsid;
	   
	    // send request
	    $out = "{$method} {$path} HTTP/1.1\r\n";
	    $out .= "Host: {$host}\r\n";
	    if($cookie) $out .= "Cookie:".$cookie."\r\n";
	    $out .= "Connection:close\r\n\r\n";
	    
	    fputs($fp, $out);
	    
	    $response = '';
	    while($row=fread($fp, 4096)){
	        $response .= $row;
	    }
	    
	    fclose($fp);
	    
	    Think\Log::write("////////////////////////////// login_do_service url is ".$url);
	    Think\Log::write("////////////////////////////// login_do_service params is ".print_r($param,true));
	    Think\Log::write("////////////////////////////// login_do_service method is ".print_r($method,true));
	    Think\Log::write("////////////////////////////// login_do_service request is ".print_r($out,true));
	    Think\Log::write("////////////////////////////// login_do_service response is ".print_r($response,true));
	    
	    return $response;
	}

}